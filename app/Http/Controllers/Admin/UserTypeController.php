<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admins\UserType;
use App\Models\User;

class UserTypeController extends Controller
{
    /*
        adding new types of user like employee
     *      */
    public function addUserType(Request $request)
    {
//        dd($request->all());
        $this->validate($request, [
            'usertype' => 'required',
            'userstatus' => 'required'
        ]);
               

        $usertype = new UserType([
            'user_type' => $request->get('usertype'),
            'user_type_status' => $request->get('userstatus')
        ]);
        $usertype->save();
        return redirect()->back();
    }
    
    /*
        assigning type to registered user
     *      */
    public function assignUserType(Request $request)
    {
       $usertype = $request->get("usertype");
       
       $usertypes = UserType::select("user_type_id")->where("user_type","=","$usertype")->first();
       $user = \Auth::user();                            
      
       $user_update = User::find($request->get("userid"));
       $user_update->user_type_id = $usertypes->user_type_id;
       $user_update->save();
       return redirect()->back();
    }
}