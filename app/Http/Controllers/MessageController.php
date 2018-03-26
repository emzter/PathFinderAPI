<?php
namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
class MessageController extends Controller {
    public function getAll() {
        return response()->json(Message::all());
    }

    public function getOne($id) {
        return response()->json(Message::find($id));
    }

    public function getByReceiver($id) {
        return response()->json(Message::where('reciever', $id)->get());
    }

    public function getBySender($id) {
        return response()->json(Message::where('sender', $id)->get());
    }

    public function post(Request $request) {
        $this->validate($request, [
            'title' => 'required',
            'text' => 'required',
            'sender' => 'required',
            'reciever' => 'required',
            'type' => 'required'
        ]);

        $message = Message::create($request->all());
        return response()->json($message, 201);
    }

    public function update($id, Request $request) {
        $message = Message::findOrFail($id);
        $message->update($request->all());

        return response()->json($message, 200);
    }

    public function delete($id) {
        Message::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }
}