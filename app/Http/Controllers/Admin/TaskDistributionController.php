<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use App\Models\Tasks;
use Toastr;

class TaskDistributionController extends Controller
{
    //this function is just to show view to admin
    public function showPage_admin()
    {
        return view("admins.taskdistributionform");
    }
    
    //this function is to assign task to user
    //it recevies user name with his id just to distinguish in case of same name
    public function assignTask(Request $request)
    {
        $res = false;
        $temp = $request->get("userwithid");
        $temp = explode(",", $temp);
        $id = $temp[0];
        $task = $request->get("task");
        if(!empty($task)) {
            $data = array(
                "user_id" => $id,
                "task" => trim($task)
            );
            $res = Tasks::create($data); 
        }
        if($res) {
            Toastr::success('Task is assigned successfully');
        } else {
            Toastr::error('Something went wrong');
        }
        return redirect()->back();  
    }
    
    public function deleteTask(Request $request)
    {
        
        Tasks::where("task_id",$request->get("taskid"))->delete();
        return redirect()->back();
    }

    //this function is just to show view to user    
    public function showPage_user()
    {
        return view("employees.employeetask");
    }
    
    
}
