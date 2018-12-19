<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\Tasks;
use Illuminate\Support\Facades\Auth;
use Toastr;
use App\Models\User;
use App\Models\Constants\UserType;
use Carbon\Carbon;

class TaskDistributionController extends Controller
{
    //this function is just to show view to admin
    public function showPage_admin()
    {
        $users = User::with(['type'])->whereNotIn('user_type_id',[UserType::ADMIN])->get();
        $tasks = Tasks::leftjoin("users", "users.user_id", "tasks.task_assigned_to")
            ->leftjoin("user_task_timeline", "user_task_timeline.task_id", "tasks.task_id")
            ->select("tasks.*", "users.user_id", "users.user_first_name", "users.user_last_name", "user_task_timeline.status_by_user")
            ->get();
        $this->addData('tasks', $tasks);
        $this->addData('users', $users);
        return $this->getView('admins.taskdistributionform');
    }

    //this function is to assign task to user
    //it recevies user name with his id just to distinguish in case of same name
    public function assignTask(Request $request)
    {
        $user = Auth::user();
        $res = false;
        $user_id = $request->get("userwithid");
        $tasktitle = $request->get("taskTitle");
        $data = array(
            "task_assigned_by" => Auth::id(),
            "task_title" => $tasktitle,
            "task_description" => $request->get('task'),
            "task_created_by" => Auth::id(),
            "task_assigned_to" => $user_id,
            "created_at" => Carbon::now()
        );

        $res = Tasks::create($data);

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

    //In function user sets the status "start, pause or stop"
    //when starting it takes system time and put it in cookies
    //when pause again system time and but if start again then takes time for cookies
    //when stop it stops with system date
    public function taskStatus(Request $request)
    {
        $taskid = $request->get("taskid");
        $userid = $request->get("userid");
        $timelineid = $request->get("timelineid");
        date_default_timezone_set("Asia/Kolkata");
        $start_date = null;
        $start_time = null;




        if($request->get("start") == ("Start"))
        {
            $start_date = date("Y-m-d");
            $start_time = date('H:i:s');
            DB::update("update tasks set start_datetime='$start_date $start_time' where task_id=$taskid and user_id=$userid");

            $data = DB::select("select * from user_task_timeline where task_id=$taskid and user_id=$userid");
            if(empty($data))
            {
                DB::table("user_task_timeline")->insert([
                    "task_id" => $taskid,
                    "user_id" => $userid,
                    "start_datetime" =>$start_date." ".$start_time,
                    "status_by_user" => "Start"
                ]);
            }
            else
            {
                DB::table("user_task_timeline")
                    ->where("user_id","=",$userid)
                    ->where("task_id","=",$taskid)
                    ->update([
                    "task_id" => $taskid,
                    "user_id" => $userid,
                    "start_datetime" =>$start_date." ".$start_time,
                    "status_by_user" => "Start"
                ]);
            }
            DB::update("update user_task_timeline set start_datetime='$start_date $start_time' where task_id=$taskid and user_id=$userid");
            Session::forget("usertaskdata");
            Session::push('usertaskdata', ['userid'=>$userid,'taskid'=>$taskid,'date'=>$start_date,'time'=>$start_time]);
            return redirect()->back();

        }
        else
        {
            if($request->get("pause") == ("Pause"))
            {

                $olddate = null;
                $oldtime = null;
                $start_date = date("Y-m-d");
                $start_time = date('H:i:s');
                if(!empty(Session::get("usertaskdata")))
                {
                    $data = Session::get("usertaskdata");
                    if($data[0]["taskid"]==$taskid)
                    {
                        $olddate = $data[0]["date"];
                        $oldtime = $data[0]["time"];
                    }

                }


                    DB::table("user_task_timeline")
                        ->where("user_task_timeline_id","=",$timelineid)
                        ->insert([
                        "task_id" => $taskid,
                        "user_id" => $userid,
                        "halt_datetime" =>$start_date." ".$start_time,
                        "status_by_user" => "Pause"
                    ]);
            }


                Session::forget("usertaskdata");
                Session::push('usertaskdata', ['userid'=>$userid,'taskid'=>$taskid,'date'=>$olddate,'time'=>$oldtime]);

                return redirect()
                        ->back();
                        // ->withCookie(cookie("date",$start_date))
                        // ->withCookie(cookie("time",$start_time))
                        // ->withCookie(cookie("olddate",$olddate))
                        // ->withCookie(cookie("oldtime", $oldtime));

            }
            /*if($request->get("stop") == ("Stop"))
            {
                $olddate = null;
                $oldtime = null;
                $start_date = date("Y-m-d");
                $start_time = date('H:i:s');
                if(!empty(Session::get("usertaskdata")))
                {
                    $data = Session::get("usertaskdata");
                    if($data[0]["taskid"]==$taskid)
                    {
                        $olddate = $data[0]["date"];
                        $oldtime = $data[0]["time"];
                    }

                }
                Session::forget("usertaskdata");
                Session::push('usertaskdata', ['userid'=>$userid,'taskid'=>$taskid,'date'=>$olddate,'time'=>$oldtime]);
                DB::update("update tasks set status_by_user='stop',end_date='$start_date',end_time='$start_time' where task_id=$taskid && user_id=$userid");
                return redirect()
                        ->back();
                        // ->withCookie(cookie("date",$start_date))
                        // ->withCookie(cookie("time", $start_time))
                        // ->withCookie(cookie("olddate",$olddate))
                        // ->withCookie(cookie("oldtime", $oldtime));
            }*/
        }
        
        public function editTask(Request $request)
        {
//            dd($request->all());
            $taskid = $request->get("taskid");
            $data = DB::table("tasks")
                    ->where("task_id","=",$taskid)
                    ->join("users","users.user_id","tasks.task_assigned_to")
                    ->select("users.user_first_name","users.user_last_name","tasks.task_title","tasks.task_description","tasks.task_id")
                    ->first();
            $this->addData("taskdata", $data);
            return $this->getView("admins.taskdistributionform_edit");
            
        }
        public function editTaskDetails(Request $request)
        {
            $task_id = $request->get('task_id');
            $task = Tasks::find($task_id);
            $task->task_title = $request->get("taskTitle");
            $task->task_description = $request->get("task");
            $res = $task->update();
            
            return redirect()->back();
        }
        //this function is just to show view to user
        public function showPage_user()
        {
            return view("employees.employeetask");
        }
        
    }