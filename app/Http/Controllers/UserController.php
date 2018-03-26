<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
class UserController extends Controller {
    public function getAll() {
        return response()->json(User::all());
    }

    public function getOne($id) {
        return response()->json(User::find($id));
    }

    public function getDetail($id) {
        return response()->json(User::find($id)->details, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
    }

    public function update($id, Request $request) {
        $user = User::findOrFail($id);
        $user->update($request->all());

        return response()->json($user, 200);
    }

    public function delete($id) {
        User::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }
}