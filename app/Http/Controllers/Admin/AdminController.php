<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Managers\UserManager;
use Illuminate\Http\Request;
use App\Models\Admins\Admin;
use App\Models\Constants\UserType;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Admins\UserType as Type;

class AdminController extends Controller
{
    private $manager;

    public function __construct(UserManager $manager)
    {
        parent::__construct();
        $this->setTitle('Admins');
        $this->manager = $manager;
    }

    public function index(Request $request)
    {
        $admins = User::where('user_type_id', '=', UserType::ADMIN)->get();
        $user_types = Type::all();
        $this->addData('user_types', $user_types);
        $this->addData('admins', $admins);
        return $this->getView('admins.index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        
        UserManager::validateAdmin($request->all());
        $this->manager->postNewAdmin($request);
        return redirect()->back();
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update($id, Request $request)
    {
        
    }

    public function destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->back();

    }
    public function UpdateAdmin($id, Request $request)
    {
        $admin = Admin::find($id);
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
        return redirect()->back();
    }
}
