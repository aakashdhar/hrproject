<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cookie;

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
        
        $temp = $request->get("userwithid");
        $temp = explode(",", $temp);
        $id = $temp[0];
        $task = $request->get("task");
        $data = array(
            "user_id" => $id,
            "task" => $task,
            "start_date" => null,
            "start_time" => null,
            "end_date" => null,            
            "end_time" => null,
            "status_user" => null,
            "status_admin" => null,
        );
        
        DB::table("user_tasks")->insert($data); 
        return redirect()->back();  
    }
    
    //this function is just to show view to user    
    public function showPage_user()
    {
        return view("employees.employeetask");
    }
    
    //In function user sets the status "start, pause or stop"
    //when starting it takes system time and put it in cookies
    //when pause again system time and but if start again then takes time for cookies
    //when stop it stops with system date
    public function taskStatus(Request $request)
    {
        date_default_timezone_set("Asia/Kolkata");
        $taskid = $request->get("taskid");
        $userid = $request->get("userid");
            $start_date = date("Y-m-d");
            $start_time = date('H:i:s');
        
        if($request->get("start") == ("Start"))
        {
            DB::update("update user_tasks set status_user='start',start_date='$start_date',start_time='$start_time' where task_id=$taskid && user_id=$userid");
            DB::update("update user_tasks set status_user='pause',end_date='$start_date',end_time='$start_time' where task_id!=$taskid && user_id=$userid");
           

            return redirect()
                        ->back()
                        ->withCookie(cookie("date",$start_date))
                        ->withCookie(cookie("time",$start_time));
                        
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
                
                DB::update("update user_tasks set status_user='pause',end_date='$start_date',end_time='$start_time' where task_id=$taskid && user_id=$userid");
                
                
                return redirect()
                        ->back()
                        ->withCookie(cookie("date",$start_date))
                        ->withCookie(cookie("time",$start_time))
                        ->withCookie(cookie("olddate",$olddate))
                        ->withCookie(cookie("oldtime", $oldtime));
                
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
                
                DB::update("update user_tasks set status_user='stop',end_date='$start_date',end_time='$start_time' where task_id=$taskid && user_id=$userid");
                return redirect()
                        ->back()
                        ->withCookie(cookie("date",$start_date))
                        ->withCookie(cookie("time", $start_time))
                        ->withCookie(cookie("olddate",$olddate))
                        ->withCookie(cookie("oldtime", $oldtime));
            }
        }
    }
    
    //admin sets status, reassign or comeplete
    public function taskStatusByAdmin(Request $request)
    {
        
        $user_id = $request->get("userid");
        $task_id = $request->get("taskid");        
        $adminanswer = $request->get("adminanswer");
        
        if($adminanswer == "Reassign")
        {
            
            //DB::update("update user_tasks set status_admin='reassign',status_user=null where user_id=$user_id and task_id=$task_id");
            DB::table('user_tasks')->where('user_id','=',$user_id)->where('task_id','=',$task_id)->update(['status_admin'=>'reassign','status_user'=>null]);
        }
        if($adminanswer == "Complete")
        {
//            DB::update("update user_tasks set status_admin='complete' where user_id=$user_id and task_id=$task_id");            
            DB::table('user_tasks')->where('user_id','=',$user_id)->where('task_id','=',$task_id)->update(['status_admin'=>'complete']);
        }
        return redirect()->back();
    }
}
