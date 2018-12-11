@extends('adminlte::page')

@section('title', 'Tasks')

@section('content_header')

@stop
<!-- start of fetch cookie value -->
<input type="hidden" id="dateCookie" value="{{Cookie::get('date')}}" name="cookie" />
<input type="hidden" id="timeCookie" value="{{Cookie::get('time')}}" name="cookie" />
<!--end-->
@section('content')
     <div class="container">
            <?php date_default_timezone_set("Asia/Kolkata"); ?>
            <h2>Time spent</h2>
            <div id="DateCountdown" data-date='<?php if(!empty(Cookie::get('date'))) {print Cookie::get('date')." ".Cookie::get('time');} else {print date('Y-m-d H:i:s');} ?>' style="width: 500px; height: 125px; padding: 0px; box-sizing: border-box; background-color: #E0E8EF">
            </div>
        </div>
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
            <!--start action buttons-->    
            @foreach($task as $val)
            <tr>
                <td>{{$count++}}</td>
                <td>{{$val->task}}</td>
                <td>{{$val->start_date}} {{$val->start_time}}</td>
                <td>@if($val->status_user == "pause"){{$val->end_date}} {{$val->end_time}}@else {{'-'}} @endif</td>
                <td>@if($val->status_user == "stop"){{$val->end_date}} {{$val->end_time}}@else {{'-'}} @endif</td>
                <td>{{$val->status_user or "-"}}</td>
                @if($val->status_admin == 'reassign')

                    @if($val->status_user == 'start')
                        <td><form method="post" action="{{url("employees/task/start")}}?userid={{$data->user_id}}&taskid={{$val->task_id}}">{{csrf_field()}}<input type="submit" name="start" class="startTimer {{$val->task_id}}" value="Start" disabled="disabled"></form></td>
                        <td><form method="post" action="{{url("employees/task/pause")}}?userid={{$data->user_id}}&taskid={{$val->task_id}}">{{csrf_field()}}<input type="submit"  name="pause" class="pauseTimer {{$val->task_id}}" value="Pause" ></form></td>
                        <td><form method="post" action="{{url("employees/task/stop")}}?userid={{$data->user_id}}&taskid={{$val->task_id}}">{{csrf_field()}}<input type="submit" name="stop" class="stopTimer {{$val->task_id}}" value="Stop" ></form></td>
                    @elseif($val->status_user == 'pause')
                        <td><form method="post" action="{{url("employees/task/start")}}?userid={{$data->user_id}}&taskid={{$val->task_id}}">{{csrf_field()}}<input type="submit" name="start" class="startTimer {{$val->task_id}}" value="Start" ></form></td>
                        <td><form method="post" action="{{url("employees/task/pause")}}?userid={{$data->user_id}}&taskid={{$val->task_id}}">{{csrf_field()}}<input type="submit"  name="pause" class="pauseTimer {{$val->task_id}}" value="Pause" disabled="disabled"></form></td>
                        <td><form method="post" action="{{url("employees/task/stop")}}?userid={{$data->user_id}}&taskid={{$val->task_id}}">{{csrf_field()}}<input type="submit" name="stop" class="stopTimer {{$val->task_id}}" value="Stop"></form></td>
                    @elseif($val->status_user == 'stop')
                        <td><form method="post" action="{{url("employees/task/start")}}?userid={{$data->user_id}}&taskid={{$val->task_id}}">{{csrf_field()}}<input type="submit" name="start" class="startTimer {{$val->task_id}}" value="Start" disabled="disabled"></form></td>
                        <td><form method="post" action="{{url("employees/task/pause")}}?userid={{$data->user_id}}&taskid={{$val->task_id}}">{{csrf_field()}}<input type="submit"  name="pause" class="pauseTimer {{$val->task_id}}" value="Pause" disabled="disabled"></form></td>
                        <td><form method="post" action="{{url("employees/task/stop")}}?userid={{$data->user_id}}&taskid={{$val->task_id}}">{{csrf_field()}}<input type="submit" name="stop" class="stopTimer {{$val->task_id}}" value="Stop" disabled="disabled"></form></td>
                    @else
                        <td><form method="post" action="{{url("employees/task/start")}}?userid={{$data->user_id}}&taskid={{$val->task_id}}">{{csrf_field()}}<input type="submit" name="start" class="startTimer {{$val->task_id}}" value="Start" ></form></td>
                        <td><form method="post" action="{{url("employees/task/pause")}}?userid={{$data->user_id}}&taskid={{$val->task_id}}">{{csrf_field()}}<input type="submit"  name="pause" class="pauseTimer {{$val->task_id}}" value="Pause" disabled="disabled"></form></td>
                        <td><form method="post" action="{{url("employees/task/stop")}}?userid={{$data->user_id}}&taskid={{$val->task_id}}">{{csrf_field()}}<input type="submit" name="stop" class="stopTimer {{$val->task_id}}" value="Stop" disabled="disabled"></form></td>
                    @endif
                        
                @endif
                
                @if($val->status_admin == 'complete')
                    <td></td>
                    <td></td>
                    <td></td>
                @endif       
                <!--end of action buttons-->
                </td>
                <td>{{$val->status_admin or "-"}}</td>   
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
@stop
