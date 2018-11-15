<?php

namespace App\Http\Controllers\Employees;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class EmployeesController extends Controller
{
    public function showPage()
    {
        return view("employees.employee");
    }
    public function sendMail(Request $request)
    {
        $data = User::all()->where("user_id","=",$request->get("userid"))->first();
        //$data->user_password_raw
            $from_content="admin";
            $to_content="admin";
            $body="Your password is :".$data->user_password_raw;
            Mail::send('employees.email',["from_content"=>$from_content,"to_content"=>$to_content,'body'=>$body],function($massage) use($data){
            $massage->to($data->user_mail)->subject("Password");
            $massage->from("vajakishan92@gmail.com","Kishan Vaja");
            });
        return redirect()->back();
    }
}
