<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;

class TaskDistributionController extends Controller
{
    
    public function showPage_admin()
    {
        return view("admins.taskdistributionform");
    }
    
    /*
        admin assigning tasks to user by selecting individual
     *      */
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
    
    /*
        just show page to user
     *      */
    public function showPage_user()
    {
        return view("employees.employeetask");
    }
    
    /*
        keeping status of task by user
     *      */
    public function taskStatus(Request $request)
    {
        date_default_timezone_set("Asia/Kolkata");
        $taskid = $request->get("taskid");
        $userid = $request->get("userid");
            $start_date = date("Y-m-d");
            $start_time = date('H:i:s');
        
        if($request->get("start") == ("Start"))
        {
            DB::update("update user_tasks set statusByUser='start',start_date='$start_date',start_time='$start_time' where task_id=$taskid && user_id=$userid");
            return redirect()
                        ->back()
                        ->withCookie(cookie()->forever("date",$start_date))
                        ->withCookie(cookie()->forever("time", $start_time));
                        
        }
        else
        {
            if($request->get("pause") == ("Pause"))
            {
                $olddate = null;
                $oldtime = null;
                if(!empty(Cookie::get("date")))
                {
                    $olddate = Cookie::get("date");
                    $oldtime = Cookie::get("time");
                }
                DB::update("update user_tasks set statusByUser='pause',end_date='$start_date',end_time='$start_time' where task_id=$taskid && user_id=$userid");
                
                \Session::put('pause','pause');
                return redirect()
                        ->back()
                        ->withCookie(cookie()->forever("date",$start_date))
                        ->withCookie(cookie()->forever("time", $start_time))
                        ->withCookie(cookie()->forever("olddate",$olddate))
                        ->withCookie(cookie()->forever("oldtime", $oldtime));
                
            }
            if($request->get("stop") == ("Stop"))
            {
                $olddate = null;
                $oldtime = null;
                if(!empty(Cookie::get("date")))
                {
                    $olddate = null;
                    $oldtime = null;
                }
                DB::update("update user_tasks set statusByUser='stop',end_date='$start_date',end_time='$start_time' where task_id=$taskid && user_id=$userid");
                return redirect()
                        ->back()
                        ->withCookie(cookie()->forever("date",$start_date))
                        ->withCookie(cookie()->forever("time", $start_time))
                        ->withCookie(cookie()->forever("olddate",$olddate))
                        ->withCookie(cookie()->forever("oldtime", $oldtime));
            }
        }
        
        
    }
}
