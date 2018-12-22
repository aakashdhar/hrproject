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
use App\Models\LogTask;
use App\Models\Constants\TaskStatus;

class TaskDistributionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    //this function is just to show view to admin
    public function showPage_admin()
    {
        $users = User::with(['type'])->whereNotIn('user_type_id',[UserType::ADMIN])->get();
        $tasks = Tasks::with(['timeline'])->leftjoin("users", "users.user_id", "tasks.task_assigned_to")
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
        
        $res = false;
        $task_id = $request->input('task_id');
        $status = $request->input('status');
        $timeline_id = $request->input('timeline_id');
        $user_id = $request->input('user_id');
        // $date_time = $request->input('date_time');
        $date_time = date('Y/m/d H:i:s');
        $j_date = $date_time;
        $date_time = date('Y/m/d H:i:s',strtotime($date_time));
        $task = Tasks::find($task_id);
        if($status == 'Pause'){
            $task_status = TaskStatus::PAUSED;
            $task->task_status = TaskStatus::PAUSED;
        }
        if($status == 'Start'){
            $task_status = TaskStatus::STARTED;
            $task->task_status = TaskStatus::STARTED;
        }
        if($status == 'Stop'){
            $task_status = TaskStatus::FINISHED;
            $task->task_status = TaskStatus::FINISHED;
        }
        $task->update();
        
        $logs = LogTask::where('log_task_id', '=', $task_id)->get();
        if($logs->count() > 0) {
            $last_log = LogTask::where('log_task_id', '=', $task_id)
            ->where('log_task_finished_at', '=', null)
            ->orderBy('log_task_details_id', 'desc')->first();
            if(isset($last_log) && !empty($last_log)) {
                $last_log->log_task_status = $task_status;
                $last_log->log_task_finished_at = $date_time;
                $last_log->update();
            } else {
                if($status != 'Stop') {
                    $new_log = new LogTask();
                    $new_log->log_task_id = $task_id;
                    $new_log->log_task_started_at = $date_time;
                    $new_log->log_task_status = $task_status;
                    $res = $new_log->save();
                }
            }
            // echo json_encode(['status'=>true,'task_status'=>$status,'date_time'=>$j_date]);
            $get_timer_data = $this->getTaskMonthYear($task,$status);
            return redirect()->back()->with(['timer_data'=>$get_timer_data]);
        } else {
            $new_log = new LogTask();
            $new_log->log_task_id = $task_id;
            $new_log->log_task_started_at = $date_time;
            $new_log->log_task_status = $task_status;
            $res  = $new_log->save();
            // echo json_encode(['status'=>true,'task_status'=>$status,'date_time'=>$j_date]);
            $get_timer_data = $this->getTaskMonthYear($task,$status);
            return redirect()->back()->with(['timer_data'=>$get_timer_data]);
        }
        }

        public function editTask(Request $request)
        {
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

            return redirect()->to("tasks");
        }
        //this function is just to show view to user
        public function showPage_user()
        {
            $tasks = Tasks::with(['timeline'])
                    ->Where('task_assigned_to', '=', Auth::id())
                    ->get();
            $started_count = Tasks::where('task_status', '=', 'Started')->get()->count();
            $this->addData('started_count', $started_count);
            $auth = $this->getData()['auth'];
            $this->addData('tasks', $tasks);
            $this->addData('auth', $auth);
            return $this->getView('employees.employeetask');
        }


        public function getTaskMonthYear($task,$status)
        {
            $total_time_spent = '0000-00-00 00:00:00';
            $t_minute = 0;
            $t_hour = 0;
            $t_seconds = 0;
            if(count($task->timeline) > 0){
                foreach ($task->timeline as $timeline)
                {
                    if($timeline->log_task_finished_at != null && $timeline->log_task_started_at != null) {
                        $started = date('H:i:s', strtotime($timeline->log_task_started_at));
                        $end = date('H:i:s', strtotime($timeline->log_task_finished_at));
                        $spent = date_diff(new \DateTime($started), new \DateTime($end));

                        $started = new \DateTime($started);
                        $end = new \DateTime($end);
                        $diff = new \DateTime();

                        $diff = $end->diff($started);
                        $second = $diff->s;
                        $minute = $diff->i;
                        $hours  = $diff->h;
                        $t_minute += $minute;
                        $t_hour += $hours;
                        $t_seconds += $second;
                    }
                }
            }

            if($t_seconds > 60){
                $minute = $t_seconds/60;
                $t_minute = $t_minute + floor($minute);
                $minute_fl = floor($minute);
                $seconds = $t_seconds - ($minute_fl * 60);
                $t_seconds = $seconds;
            }

            if($t_minute > 60){
                $hour = $t_minute/60;
                $t_hour = $t_hour + floor($hour);
                $hour_fl = floor($hour);
                $minutes = $t_minute - ($hour_fl * 60);
                $t_minute = floor($minutes);
            }


            $data = ['hour'=>$t_hour,'minute'=>$t_minute,'second'=>$t_seconds,'task_name'=>$task->task_title,'status'=>$status];
            
            return $data;
        }

    }