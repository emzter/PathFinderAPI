<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class User extends Model {
    protected $fillable = [
        'email',
        'user_group',
        'status',
        'skip',
        'validate',
        'language',
        'profile_image',
        'header_image',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        'password'
    ];

    public function setPasswordAttribute($pass){
        $salt = sha1(md5($pass));
        $newpass = md5($pass.$salt);
        $this->attributes['password'] = $newpass;
    }

    public function check($pass) {
        $salt = sha1(md5($pass));
        $newpass = md5($pass.$salt);
        if ($this->attributes['password'] === $newpass) {
            return true;
        } else {
            return false;
        }
    }

    public function details() {
        return $this->hasOne('App\Models\PersonalDetail', 'user_id', 'id');
    }
}