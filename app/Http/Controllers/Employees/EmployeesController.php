<?php

namespace App\Http\Controllers\Employees;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Admins\UserType;
use Illuminate\Support\Facades\Hash;

class EmployeesController extends Controller
{
    public function showPage()
    {
        return view("employees.employee");
    }
    public function updateEmployee($id,Request $request) {
        $user = User::find($id);
        
        $user->user_name = $request->get('user_name');
        $user->user_first_name = $request->get('user_first_name');
        $user->user_last_name = $request->get('user_last_name');
        $user->user_email = $request->get('user_email');
        $user->user_contact_no = $request->get('user_contact_no');
        $user->user_password = Hash::make($request->get('user_password'));
        $user->user_password_raw = $request->get('user_password');
        
        $user->user_address = $request->get('user_address');
        $res = $user->save();
        return redirect()->back();
    }
    public function deleteEmployee($id,Request $request) {
        
        $user = User::find($id);
        $res = $user->delete();
        return redirect()->back();
    }
}
