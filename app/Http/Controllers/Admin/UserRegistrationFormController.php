<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Admins\UserType;
use Illuminate\Support\Facades\Hash;

class UserRegistrationFormController extends Controller
{
    public function showPage()
    {
        return view("admins.userregistrationform");
    }
    public function addUser(Request $request)
    {
        
        $usertype = UserType::select("user_type_id")->where("user_type","=",$request->get("usertype"))->first();
        $user = new User;
        $user->user_name = $request->get("username");
        $user->user_first_name = $request->get("userfirstname");
        $user->user_last_name = $request->get("userlastname");
        
        $user->user_email = $request->get("useremail");
        $user->user_contact_no = $request->get("usercontactno");
        $user->user_password = Hash::make($request->get("userpassword"));
        $user->user_password_raw = $request->get("userpassword");
        $user->user_type_id = $usertype->user_type_id;
        $user->user_address = $request->get("useraddress");
        $res = $user->save();
        return redirect()->back();
    }
}
