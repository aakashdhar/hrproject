<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskDistributionController extends Controller
{
    public function showPage_admin()
    {
        return view("admins.taskdistributionform");
    }
    public function assignTask(Request $request)
    {
        
        $temp = $request->get("userwithid");
        $temp = explode(",", $temp);
        $id = $temp[0];
        $task = $request->get("task");
        $data = array(
            "user_id" => $id,
            "task" => $task,
            "start_datetime" => null,
            "pause_datetime" => null,
            "end_datetime" => null,
            "task_status_user" => null,
            "task_status_admin" => null,
        );
        DB::table("user_tasks")->insert($data); 
        return redirect()->back();  
    }
    public function showPage_user()
    {
        return view("employees.employeetask");
    }
}
