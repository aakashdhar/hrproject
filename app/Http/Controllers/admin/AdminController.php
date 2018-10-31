<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Managers\UserManager;
use Illuminate\Http\Request;
use App\Models\User;

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
        $admins = User::with(['type'])->where('user_type_id', '=', 1)->get();
        $this->addData('admins', $admins);
        return $this->getView('admins.index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        dd($request->all());
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

    public function update(Request $request, $id)
    {
        dd($request->all(), $id);
    }

    public function destroy($id)
    {
        dd($id);
    }
}
