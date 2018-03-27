<?php
namespace App\Http\Controllers;

use App\Models\Application;
use Illuminate\Http\Request;
class ApplicationController extends Controller {
    public function getAll() {
        return response()->json(Application::all(), 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
    }

    public function getOne($id) {
        return response()->json(Application::find($id), 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
    }

    public function getByJobId($id) {
        return response()->json(Application::where('job_id', $id), 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
    }

    public function post(Request $request) {
        $application = Application::create($request->all());
        return response()->json($application, 201);
    }

    public function update($id, Request $request) {
        $application = Application::findOrFail($id);
        $application->update($request->all());

        return response()->json($application, 200);
    }

    public function updateStatus($id, Request $request) {
        $application = Application::findOrFail($id);
        $application->status = $request->input('status');
        $application->save();

        return response()->json($application, 200);
    }

    public function delete($id) {
        Application::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }

}