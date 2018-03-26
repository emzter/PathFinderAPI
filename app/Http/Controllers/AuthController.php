<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PersonalDetail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
class AuthController extends Controller {
    public function login(Request $request) {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::whereEmail($request->input('email'))->first();
        if ($user !== null) {
            if ($user->check($request->input('password'))) {
                return response()->json($user, 200);
            } else {
                return response()->json($request, 401);
            }
        } else {
            return response()->json($request, 404);
        }
    }

    public function register(Request $request) {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
        ]);

        $user = new User();
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->save();

        $detail = new PersonalDetail();
        $detail->first_name = $request->input('firstname');
        $detail->last_name = $request->input('lastname');
        $detail->user_id = $user->id;
        $detail->save();
    }
}