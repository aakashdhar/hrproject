<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskDistributionController extends Controller
{
    public function showPage()
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
            "start_date" => null,
            "start_time" => null,
            "end_time" => null,
            "end_date" => null,
            "statusByUser" => null,
            "statusByAdmin" => null,
        );
        DB::table("user_tasks")->insert($data); 
        return redirect()->back();  
    }
}
