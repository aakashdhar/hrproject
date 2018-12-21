<?php

namespace App\Http\Controllers\Employees;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Admins\UserType;
use Illuminate\Support\Facades\Hash;

class EmployeesController extends Controller
{
    //this function is just to show view
    public function showPage()
    {
        $userdata = User::with(['type'])
                    ->where('user_type_id','<>','1')
                    ->get();
        $this->addData('userdata',$userdata);
        return $this->getView("employees.employee");
    }
    //Function for creating the employee
    public function store(Request $request)
    {
      $user = new User;
      $user->user_name = $request->get('user_name');
      $user->user_first_name = $request->get('user_first_name');
      $user->user_last_name = $request->get('user_last_name');
      $user->user_email = $request->get('user_email');
      $user->user_contact_no = $request->get('user_contact_no');
      $user->user_password = Hash::make($request->get('user_password'));
      $user->user_password_raw = $request->get('user_password');
      $user->user_address = $request->get('user_address');
      $user->joining_date = $request->get('joining_date');
      $user->user_dob = $request->get('user_dob');
      $user->user_hobbies = $request->get('user_hobbies');
      $user->user_leave = $request->get('user_leave');
      $user->user_emergency_name = $request->get('user_emergency_name');
      $user->user_emergency_contact = $request->get('user_emergency_contact');
      $user->user_type_id = 2;
      $res = $user->save();
      return redirect()->back();
    }
    //function is for updating employee
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
        $user->joining_date = $request->get('joining_date');
        $user->user_dob = $request->get('user_dob');
        $user->user_hobbies = $request->get('user_hobbies');
        $user->user_emergency_name = $request->get('user_emergency_name');
        $user->user_emergency_contact = $request->get('user_emergency_contact');
        $res = $user->save();
        return redirect()->back();
    }

    //this function is for delete employee
    public function deleteEmployee($id,Request $request) {

        $user = User::find($id);
        $res = $user->delete();
        return redirect()->back();
    }
}
