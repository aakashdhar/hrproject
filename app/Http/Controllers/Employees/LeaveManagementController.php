<?php

namespace App\Http\Controllers\Employees;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Models\UserHoliday;
use Illuminate\Support\Facades\Storage;
use App\Models\LeaveApplication;
use Toastr;

class LeaveManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    // this function is just to show view to user
    public function showPage_user(Request $request)
    {

        return view("employees.employeeleave");
    }

    //this function is for applying leave to admin and it send mail notification as well
    public function apply(Request $request)
    {
        $name = '';
        $msg = array();
        $start_date = $request->get("start_date");
        $sd = date_create($start_date);
        $end_date = $request->get("end_date");
        $ed = date_create($end_date);
        $subject = $request->get("subject");
        $start_date = $request->get("start_date");
        $reason = $request->get("reason");
        if(!empty($request->file("file")))
        {
                Storage::disk("uploads")->put("Medical-Documents",$request->file("file"));
                $name = $request->file("file")->hashName();
        }

//        if(preg_match("/[A-z.\s]/i", $subject))
//        {
//        }
//        else
//        {
//            //$msg = ["subject"=>""];
//        }
        $data = User::all()->where("user_id",'=',\Auth::user()->user_id)->first();

        $from_content="User";
        $to_content="User";
        $body="Please consider my Leave :<br>"
                . "ID : $data->user_id<br>"
                . "Name : $data->user_first_name $data->user_last_name<br>"
                . "Start Date : $start_date<br>"
                . "End Date   : $end_date<br>"
                . "Subject    : $subject<br>"
                . "reason    : $reason";
        Mail::send('employees.email',["from_content"=>$from_content,"to_content"=>$to_content,'body'=>$body],function($massage) use($data){
        $massage->to("vajakishan92@gmail.com","To Kishan Vaja")->subject("Leave Application");
        $massage->from($data->user_email,$data->user_first_name." ".$data->user_last_name);
        });


        $dataholiday = array(
            "user_id" => $data->user_id,
            "user_holiday_from" => $start_date,
            "user_holiday_to" => $end_date,
            "user_holiday_docname"=> $name,
            "user_holiday_doc"=> public_path()."/Medical-Documents",
            "user_holiday_subject" => $subject,
            "user_holiday_reason" => $reason
        );
        DB::table("user_holiday")->insert($dataholiday);
        Toastr::success('Application has been sent.');
        return redirect()->back();
    }

    public function deleteLeave(Request $request)
    {
        $file = UserHoliday::all()->where("user_holiday_id","=",$request->get('holidayid'))->first();
        unlink(public_path()."/Medical-Documents/".$file->user_holiday_docname);
        DB::delete("delete from user_holiday where user_holiday_id ='".$request->get('holidayid')."'");
        return redirect()->back();
    }

    public function editLeave(Request $request)
    {
        $leavedata = UserHoliday::all()->where("user_holiday_id","=",$request->get('holidayid'))->first();

        $this->addData("leavedata", $leavedata);
        return $this->getView("employees.employeeleave_edit");
    }
    public function editLeaveDetails(Request $request)
    {
        $holiday_id = $request->get('user_holiday_id');
        $start_date = $request->get("start_date");
        $end_date = $request->get("end_date");
        $subject = $request->get("subject");
        $reason = $request->get("reason");
        $holiday = UserHoliday::find($holiday_id);
        $holiday->user_holiday_from = $start_date;
        $holiday->user_holiday_to = $end_date;
        $holiday->user_holiday_reason = $reason;
        $holiday->user_holiday_subject = $subject;
        $holiday->save();
        return view('employees.employeeleave');
//        return redirect()->back();


    }

    //this function is just to show view to admin
    public function showPage_admin(Request $request)
    {
        $data = LeaveApplication::with(['applicant'])->get();
        
        $this->addData('leaves', $data);
        return $this->getView('admins.acceptleave');
    }

    public function view_leave(Request $request) {
        $leave = UserHoliday::with(['user'])->where('user_holiday_id', '=', $request->get('user_holiday_id'))->first();
        $this->addData('leave', $leave);
        return $this->getView('admins.view_leave');
    }

    // admin gives responce back to employee via email about his leave app
    public function respond(Request $request)
    {
        
        $check = $request->get("answer");
        $id = $request->get("id");
        $hid = $request->get("holidayid");
        $start_date = $request->get("start_date");
        $end_date = $request->get("end_date");
        $data = DB::select("select DATEDIFF(user_holiday_to,user_holiday_from) as days,uh.user_holiday_id,u.user_email,u.user_first_name,u.user_last_name from user_holiday uh join users u on u.user_id=uh.user_id where u.user_id=".$id);


        $from_content="admin";
        $to_content="admin";
        if($check=="accept")
        {
            foreach($data as $val)
            {

                DB::update("update user_holiday set user_holiday_count=user_holiday_count-$val->days,user_holiday_approval_status='$check' where user_id=$id and user_holiday_id=$hid");
                $body="Your Leave Application from $start_date to $end_date is Accepted";
                Mail::send('employees.email',["from_content"=>$from_content,"to_content"=>$to_content,'body'=>$body],function($massage) use($val){
                $massage->to($val->user_email,"To $val->user_first_name $val->user_last_name")->subject("Approval");
                $massage->from("vajakishan92@gmail.com","Kishan Vaja");
                });
            }
        }
        if($check=="reject")
        {
            DB::update("update user_holiday set user_holiday_approval_status='$check' where user_id=$id and user_holiday_id=$hid");
            foreach($data as $val)
            {
                $body="Your Leave Application from $start_date to $end_date is Rejected";
                Mail::send('employees.email',["from_content"=>$from_content,"to_content"=>$to_content,'body'=>$body],function($massage) use($val){
                $massage->to($val->user_email,"To $val->user_first_name $val->user_last_name")->subject("Rejection");
                $massage->from("vajakishan92@gmail.com","Kishan Vaja");
                });
            }

        }
        return redirect()->back();
    }
}