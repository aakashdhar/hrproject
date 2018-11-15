<?php
namespace App\Http\Managers;


use App\Models\Admins\Admin;
use App\Models\Constants\UserType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserManager
{
    public static function validateAdmin($request) {
        return Validator::make($request, [
            'user_name' => 'required|string|min:6|max:255|unique:users',
            'user_first_name' => 'required|string|max:255',
            'user_email' => 'required|string|email|max:255|unique:users',
            'user_password' => 'required|string|min:6',
            'user_contact_no' => 'required|string|min:10|unique:users',
        ]);
    }

    public function postNewAdmin(Request $request) {
        $admin = new Admin;
        $admin->user_name = $request->get('user_name');
        $admin->user_first_name = $request->get('user_first_name');
        $admin->user_last_name = $request->get('user_last_name');
        $admin->user_email = $request->get('user_email');
        $admin->user_contact_no = $request->get('user_contact_no');
        $admin->user_password = Hash::make($request->get('user_password'));
        $admin->user_password_raw = $request->get('user_password');
        $admin->user_type_id = UserType::ADMIN;
        $admin->user_address = $request->get('user_address');
        $res = $admin->save();
        return $res;
    }
    
    public function postEditAdmin($id,Request $request) {
        $admin = new Admin;
        $admin->user_name = $request->get('user_name');
        $admin->user_first_name = $request->get('user_first_name');
        $admin->user_last_name = $request->get('user_last_name');
        $admin->user_email = $request->get('user_email');
        $admin->user_contact_no = $request->get('user_contact_no');
        $admin->user_password = Hash::make($request->get('user_password'));
        $admin->user_password_raw = $request->get('user_password');
        $admin->user_type_id = UserType::ADMIN;
        $admin->user_address = $request->get('user_address');
        $res = $admin->save();
        return $res;
    }
}