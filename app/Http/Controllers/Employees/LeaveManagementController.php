<?php

namespace App\Http\Controllers\Employees;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class LeaveManagementController extends Controller
{
    public function showPage(Request $request)
    {
        return view("employees.employeeleave");
    }
    
    /*
        user apllies for leave
     *      */
    public function apply(Request $request)
    {
        $start_date = $request->get("start_date");
        $sd = date_create($start_date);
        $end_date = $request->get("end_date");
        $ed = date_create($end_date);
        $subject = $request->get("subject");
        $start_date = $request->get("start_date");
        $reason = $request->get("reason");
        if(!empty($request->file("file")))
            $request->file("file")->store("upload");
        
        $data = User::all()->where("user_id",'=',\Auth::user()->user_id)->first();
       
            $from_content="User";
            $to_content="User";
            $body="Please consider my Leave :<br>"
                    . "ID : $data->user_id"
                    . "Name : $data->user_first_name $data->user_last_name"
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
            "user_holiday_doc"=> "C:\Users\Siimteq\Documents\GitHub\hrproject\storage\app\upload",
            "user_holiday_subject" => $subject,
            "user_holiday_reason" => $reason
        );      
        DB::table("user_holiday")->insert($dataholiday);
        return redirect()->back();
    }
    
    public function showPage_admin(Request $request)
    {
        return view("admins.acceptleave");
    }
    
    /*
        admin gives responce back to employee via email about his leave app
     *      */
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