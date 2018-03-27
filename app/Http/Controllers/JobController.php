<?php
namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
class JobController extends Controller {
    public function getAll() {
        return response()->json(Job::all(), 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
    }

    public function getOne($id) {
        return response()->json(Job::find($id), 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
    }

    public function getCategory($id) {
        return response()->json(Job::find($id)->category, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
    }

    public function post(Request $request) {
        $this->validate($request, [
            'name' => 'required',
            'responsibilities' => 'required',
            'qualification' => 'required',
            'benefit' => 'required',
            'cap_type' => 'required',
            'disability_req' => 'required',
            'salary' => 'required',
            'salary_type' => 'required',
            'location' => 'required',
            'type' => 'required',
            'level' => 'required',
            'exp_req' => 'required',
            'edu_req' => 'required',
            'category_id' => 'required',
            'company_id' => 'required',
        ]);

        $newrequest = $request->all();
        $newrequest['type'] = implode(",", $request->type);
        if ($request->negetiable) {
            $newrequest['negetiable'] = 1;
        }

        $job = Job::create($newrequest);
        return response()->json($job, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
    }

    public function update($id, Request $request) {
        $this->validate($request, [
            'name' => 'required',
            'responsibilities' => 'required',
            'qualification' => 'required',
            'benefit' => 'required',
            'cap_type' => 'required',
            'disability_req' => 'required',
            'salary' => 'required',
            'salary_type' => 'required',
            'location' => 'required',
            'type' => 'required',
            'level' => 'required',
            'exp_req' => 'required',
            'edu_req' => 'required',
            'category_id' => 'required',
            'company_id' => 'required',
        ]);

        $newrequest = $request->all();
        $newrequest['type'] = implode(",", $request->type);

        $job = Job::findOrFail($id);
        $job->update($newrequest);

        return response()->json($job, 200, 200, array('Content-Type' => 'application/json;charset=utf8'), JSON_UNESCAPED_UNICODE);
    }

    public function delete($id) {
        Job::findOrFail($id)->delete();
        return response('Deleted Successfully', 200);
    }
}