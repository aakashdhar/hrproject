<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mail;
use App\Models\User;

class MailController extends Controller
{
    public function sendMail(Request $request)
    {
        $data = User::all()->where("user_id","=",$request->get("userid"))->first();
            $from_content="admin";
            $to_content="admin";
            $body="Your Password is :".$data->user_password_raw;
            Mail::send('employees.email',["from_content"=>$from_content,"to_content"=>$to_content,'body'=>$body],function($massage) use($data){
            $massage->to($data->user_email)->subject("Siimteq Password");
            $massage->from("vajakishan92@gmail.com","Kishan Vaja");
            });

        return redirect()->back();
    }
}
