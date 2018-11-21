@extends('adminlte::page')
        <link rel="stylesheet" href="{{asset("inc/bootstrap.min.css")}}" />
         <script type="text/javascript" src="{{asset("inc/jquery.min.js")}}"></script>
        <link rel="stylesheet" href="{{asset("inc/TimeCircles.css")}}" />
        <link rel="stylesheet" href="{{asset("inc/bootstrap.min.css")}}" />
@section('title', 'Admins')

@section('content_header')
    <div class="row">
            <div class="container">
            
            <h2>Time until 2014</h2>
            <div id="DateCountdown" data-date="2014-01-01 00:00:00" style="width: 500px; height: 125px; padding: 0px; box-sizing: border-box; background-color: #E0E8EF"></div>
            <div style="padding: 10px;">
                <input type="date" id="date" value="2014-01-01">
                <input type="time" id="time" value="00:00">
            </div>
            <hr>
            <h2>Counting down 15 minutes (900 seconds)</h2>
            <div id="CountDownTimer" data-timer="900" style="width: 1000px; height: 250px;"></div>
            <button class="btn btn-success startTimer">Start Timer</button>
            <button class="btn btn-danger stopTimer">Stop Timer</button>
            
        </div>
   </div>

@stop

@section('content')
    <!--timer-->
    <br>
    <div class="panel">
              
        <h2>Tasks</h2>
        <div class="panel-body">
            <table class="table">
                <thead>
                <th>No.</th>
                <th>Task</th>
                <th>Start</th>
                <th>Pause</th>
                <th>Stop</th>
                <th>Status</th>
                <th colspan="3">Action</th>
                <th>Status By Admin</th>
                </thead>
                <?php
                $data = \Auth::user();
                
                $task = Illuminate\Support\Facades\DB::select("select * from user_tasks where user_id=$data->user_id");
                $count = 1;
                ?>
                
            @foreach($task as $val)
            <tr>
                <td>{{$count++}}</td>
                <td>{{$val->task}}</td>
                <td>{{$val->start_date}} {{$val->start_time}}</td>
                <td>@if($val->statusByUser == "pause"){{$val->end_date}} {{$val->end_time}}@endif</td>
                <td>@if($val->statusByUser == "stop"){{$val->end_date}} {{$val->end_time}}@endif</td>
                <td>{{$val->statusByUser or "-"}}</td>
                <td><form method="post" action="{{url("employees/task/start")}}?userid={{$data->user_id}}&taskid={{$val->task_id}}">{{csrf_field()}}<input type="submit" name="start" value="Start"></form></td>
                <td><form method="post" action="{{url("employees/task/pause")}}?userid={{$data->user_id}}&taskid={{$val->task_id}}">{{csrf_field()}}<input type="submit" name="pause" value="Pause"></form></td>
                <td><form method="post" action="{{url("employees/task/stop")}}?userid={{$data->user_id}}&taskid={{$val->task_id}}">{{csrf_field()}}<input type="submit" name="stop" value="Stop"></form></td>
                         
                </td>
                <td>{{$val->task_status_admin or "-"}}</td>   
                </tr>
            @endforeach
            </table>
        </div>
        
    </div>

    <div id="newAdminModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                
            </div>

        </div>
    </div>
@stop<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Managers\UserManager;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Admins\Admin;
use App\Models\Constants\UserType;
use Illuminate\Support\Facades\Hash;

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
        //$admins = User::with(['type'])->where('user_type_id', '=', 1)->get();
        //$this->addData('admins', $admins);
        //return $this->getView('admins.index');
        return view('admins.index');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //dd($request->all());
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

    public function update($id,Request $request)
    {
        dd($request->all(), $id);
    }

    public function destroy($id)
    {
        dd($id);
    }
    public function UpdateAdmin($id,Request $request) {
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
