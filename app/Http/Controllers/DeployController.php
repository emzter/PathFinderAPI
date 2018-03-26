<?php
namespace App\Http\Controllers;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class DeployController extends Controller {
    public function deployApp() {
        try {
            $signature = $_SERVER['HTTP_X_GITHUB_EVENT'];
            if (is_null($signature) || $signature != 'push') {
                header('HTTP/1.0 400 Bad Request');
                die("Go Away!");
            }
            $payload = file_get_contents('php://input');
            // get the signature out of the headers and split it into parts
            $signature = $_SERVER['HTTP_X_HUB_SIGNATURE'];
            $sigParts  = explode('=', $signature);
            if (sizeof($sigParts) != 2) {
                throw new Exception('Bad signature: wrong number of \'=\' chars');
            }
            $sigAlgo = $sigParts[0];
            $sigHash = $sigParts[1];
            // verify that the signature is correct
            $hash = hash_hmac($sigAlgo, $payload, $_ENV['GITHUB_SECRET']);
            if ($hash === false) {
                throw new Exception("Unknown signature algo: $sigAlgo");
            }
            if ($hash != $sigHash) {
                throw new Exception("Signatures didn't match. Ours: '$hash', theirs: '$sigHash'.");
            }
            // read the payload
            $data = json_decode($payload);
            if (is_null($data)) {
                throw new Exception('Failed to decode JSON payload');
            }
            // make sure it's the right branch
            $branchRef = $data->ref;
            if ($branchRef != 'refs/heads/'.$_ENV['GITHUB_BRANCH']) {
                die("Ignoring push to '$branchRef'");
            }
            // ssh into the local server
            $sshSession = ssh2_connect('localhost', $_ENV['SSH_PORT']);
            $authSuccess = ssh2_auth_pubkey_file(
                $sshSession,
                $_ENV['SSH_USERNAME'],
                '/home/'.$_ENV['SSH_USERNAME'].'/.ssh/'.$_ENV['KEYPAIR_NAME'].'.pub',
                '/home/'.$_ENV['SSH_USERNAME'].'/.ssh/'.$_ENV['KEYPAIR_NAME'],
                $_ENV['KEYPAIR_PASSPHRASE']
            );
            if (!$authSuccess) {
                throw new Exception('SSH authentication failure');
            }
            // start a shell session
            $shell = ssh2_shell($sshSession, 'xterm');
            if ($shell === false) {
                throw new Exception('Failed to open shell');
            }
            stream_set_blocking($shell, true);
            stream_set_timeout($shell, 15);
            // run the commands
            $output = '';
            $endSentinel = "!~@#_DONE_#@~!";
            fwrite($shell, 'cd ~/public_html/subdomain/api' . "\n");
            fwrite($shell, 'git pull' . "\n");
            fwrite($shell, 'composer install' . "\n");
            fwrite($shell, 'echo ' . escapeshellarg($endSentinel) . "\n");
            while (true) {
                $o = stream_get_contents($shell);
                if ($o === false) {
                    throw new Exception('Failed while reading output from shell');
                }
                $output .= $o;
                if (strpos($output, $endSentinel) !== false) {
                    break;
                }
            }
            fclose($shell);
            fclose($sshSession);
            $mailBody = "GitHub payload:\r\n"
                . print_r($data, true)
                . "\r\n\r\n"
                . "Output of `git pull`:\r\n"
                . $output
                . "\r\n"
                . 'That\'s all, toodles!';
            $mailSuccess = $this->sendEmail(true, $mailBody);
        } catch (Exception $e) {
            $mailSuccess = $this->sendEmail(false, strval($e));
        }
        if(!$mailSuccess) {
            header('HTTP/1.0 500 Internal Server Error');
            die('Failed to send email to admin!');
        }else{
            die("All good here!");
        }
    }

    function sendEmail($success, $message) {
        try {
            $mail = new PHPMailer(true);

            $mail->SMTPDebug = 2;
            $mail->isSMTP();
            $mail->Host = $_ENV['SMTP_HOST'];
            $mail->Port = $_ENV['SMTP_PORT'];
            $mail->Username = $_ENV['SMTP_USER'];
            $mail->Password = $_ENV['SMTP_PASS'];
            $mail->SMTPSecure = 'tls';

            $mail->setFrom($_ENV['SMTP_USER'], 'PathFinder');
            $mail->addAddress($_ENV['ADMIN_EMAIL']);

            if ($success) {
                $mail->Subject = '['.$_ENV['SITE_DOMAIN'].' Deploy Success';
            } else {
                $mail->Subject = '['.$_ENV['SITE_DOMAIN'].' Deploy Failure';
            }

            $mail->Body = $message;

            $mail->send();

            return true;
        }catch (Exception $e) {
            return false;
        }
    }
}