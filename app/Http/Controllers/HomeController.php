<?php

namespace App\Http\Controllers;

use App\Models\Reminder;
use App\Models\QuickTask;
use App\Models\User;
use App\Models\Constants\UserType;
use App\Models\UserHoliday;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = Auth::user()->user_id;
        $reminders = Reminder::where('user_reminder_status', '=', 'pending')
                    ->where('user_remind_on', '=', date('Y-m-d'))
                    ->get()->count();
        $quickTask = QuickTask::where('user_quicktask_userid',$userId)->get();
        $admins = User::where('user_type_id', '=', UserType::ADMIN)->get()->count();
        $employee = User::where('user_type_id', '=', UserType::EMPLOYEE)->get()->count();
        $leave_count = UserHoliday::where('user_id', '=', Auth::id())->get()->count();


        $this->addData('quickTask',$quickTask);
        $this->addData('leave_count', $leave_count);
        $this->addData('employee_count', $employee);
        $this->addData('admin_count', $admins);
        $this->addData('reminder_count', $reminders);
        return $this->getView('home');
    }
}
