<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;

class PasswordResetController extends Controller
{
    public function sendLink(Request $request)
    {
        $data = User::all()->where("user_email","=", $request->get("email"))->first();
            $from_content="";
            $to_content="";
            $body = "<br><br><br><a href='www.localhost:8000/password/password-recover/userid=".$data->user_id."'>Click here for password</a>";
            
            Mail::send('employees.email',["from_content"=>$from_content,"to_content"=>$to_content,'body'=>$body],function($massage) use($data){
            $massage->to($data->user_email)
            ->subject("SiimteqHR Password");
            $massage->from("vajakishan92@gmail.com","Kishan Vaja");
            });
            return redirect()->to("login");
    }
}
