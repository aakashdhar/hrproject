<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    protected $redirectTo = '/home';

    public function __construct()
    {

        $this->middleware('guest');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'user_name' => 'required|string|min:6|max:255|unique:users',
            'user_first_name' => 'required|string|max:255',
            'user_email' => 'required|string|email|max:255|unique:users',
            'user_password' => 'required|string|min:6',
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'user_name' => $data['user_name'],
            'user_first_name' => $data['user_first_name'],
            'user_last_name' => $data['user_last_name'],
            'user_email' => $data['user_email'],
            'user_password' => Hash::make($data['user_password']),
            'user_password_raw' => $data['user_password'],
        ]);
    }
}
