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
            {{-- dd-mm-yyyy h:i:s --}}
            <div id="DateCountdown" data-date='<?php
            if(!empty(Session::get("usertaskdata")))
            {

                $auth = Session::get("usertaskdata");
                $task = DB::select('select start_datetime from tasks where user_id='.$auth[0]['userid'].' and task_id='.$auth[0]['taskid']);
                $start_datetime = $task[0]->start_datetime;

                print $start_datetime;
            }
        ?>' style="width: 500px; height: 125px; padding: 0px; box-sizing: border-box; background-color: #E0E8EF">
            </div>
        </div>
    <br>
    <div class="panel">

        <h2>Tasks</h2>
        <div class="panel-body">
            <table border="1" class="table">
                <thead>
                <th>Task ID</th>
                <th>Task</th>


                <th colspan="3">Action</th>
                <th>Status By Admin</th>
                </thead>
            <!--start action buttons-->
            @foreach($tasks as $val)
            <tr>

                <td>{{$val->task_id}}</td>
                <td>{{$val->task}}  <i class="fa fa-plus"></i>
                <hr/>
                <table>
                    <thead>
                        <th>Status :</th>
                        <th>Start  :</th>
                        <th>Pause  :</th>
                        <th>Stop   :</th>
                    </thead>
                    <tbody>
                        @foreach($val->timeline as $taskd)

                        <tr>
                            <td>{{$taskd->status_by_user}}</td>
                            <td>{{$taskd->start_datetime}}</td>
                            <td>{{$taskd->halt_datetime}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </td>


                @if($val->status_by_admin == 'Reassign')

                    @if($val->status_by_user == 'Start')
                        <td><form method="post" action="{{url("employees/task/start")}}?userid={{$auth->user_id}}&taskid={{$val->task_id}}&timelineid={{$val->user_task_timeline_id}}">{{csrf_field()}}<input type="submit" name="start" class="startTimer {{$val->task_id}}" value="Start" disabled="disabled"></form></td>
                        <td><form method="post" action="{{url("employees/task/pause")}}?userid={{$auth->user_id}}&taskid={{$val->task_id}}&timelineid={{$val->user_task_timeline_id}}">{{csrf_field()}}<input type="submit"  name="pause" class="pauseTimer {{$val->task_id}}" value="Pause" ></form></td>
                        <td><form method="post" action="{{url("employees/task/stop")}}?userid={{$auth->user_id}}&taskid={{$val->task_id}}&timelineid={{$val->user_task_timeline_id}}">{{csrf_field()}}<input type="submit" name="stop" class="stopTimer {{$val->task_id}}" value="Stop" ></form></td>
                    @elseif($val->status_by_user == 'Pause')
                        <td><form method="post" action="{{url("employees/task/start")}}?userid={{$auth->user_id}}&taskid={{$val->task_id}}&timelineid={{$val->user_task_timeline_id}}">{{csrf_field()}}<input type="submit" name="start" class="startTimer {{$val->task_id}}" value="Start" ></form></td>
                        <td><form method="post" action="{{url("employees/task/pause")}}?userid={{$auth->user_id}}&taskid={{$val->task_id}}&timelineid={{$val->user_task_timeline_id}}">{{csrf_field()}}<input type="submit"  name="pause" class="pauseTimer {{$val->task_id}}" value="Pause" disabled="disabled"></form></td>
                        <td><form method="post" action="{{url("employees/task/stop")}}?userid={{$auth->user_id}}&taskid={{$val->task_id}}&timelineid={{$val->user_task_timeline_id}}">{{csrf_field()}}<input type="submit" name="stop" class="stopTimer {{$val->task_id}}" value="Stop"></form></td>
                    @elseif($val->status_by_user == 'Stop')
                        <td><form method="post" action="{{url("employees/task/start")}}?userid={{$auth->user_id}}&taskid={{$val->task_id}}&timelineid={{$val->user_task_timeline_id}}">{{csrf_field()}}<input type="submit" name="start" class="startTimer {{$val->task_id}}" value="Start" disabled="disabled"></form></td>
                        <td><form method="post" action="{{url("employees/task/pause")}}?userid={{$auth->user_id}}&taskid={{$val->task_id}}&timelineid={{$val->user_task_timeline_id}}">{{csrf_field()}}<input type="submit"  name="pause" class="pauseTimer {{$val->task_id}}" value="Pause" disabled="disabled"></form></td>
                        <td><form method="post" action="{{url("employees/task/stop")}}?userid={{$auth->user_id}}&taskid={{$val->task_id}}&timelineid={{$val->user_task_timeline_id}}">{{csrf_field()}}<input type="submit" name="stop" class="stopTimer {{$val->task_id}}" value="Stop" disabled="disabled"></form></td>
                    @else
                        <td><form method="post" action="{{url("employees/task/start")}}?userid={{$auth->user_id}}&taskid={{$val->task_id}}&timelineid={{$val->user_task_timeline_id}}">{{csrf_field()}}<input type="submit" name="start" class="startTimer {{$val->task_id}}" value="Start" ></form></td>
                        <td><form method="post" action="{{url("employees/task/pause")}}?userid={{$auth->user_id}}&taskid={{$val->task_id}}&timelineid={{$val->user_task_timeline_id}}">{{csrf_field()}}<input type="submit"  name="pause" class="pauseTimer {{$val->task_id}}" value="Pause" disabled="disabled"></form></td>
                        <td><form method="post" action="{{url("employees/task/stop")}}?userid={{$auth->user_id}}&taskid={{$val->task_id}}&timelineid={{$val->user_task_timeline_id}}">{{csrf_field()}}<input type="submit" name="stop" class="stopTimer {{$val->task_id}}" value="Stop" disabled="disabled"></form></td>
                    @endif

                @elseif($val->status_by_admin == 'Complete')
                    <td></td>
                    <td></td>
                    <td></td>
                @else
                @if($val->status_by_user == 'Start')
                        <td><form method="post" action="{{url("employees/task/start")}}?userid={{$auth->user_id}}&taskid={{$val->task_id}}&timelineid={{$val->user_task_timeline_id}}">{{csrf_field()}}<input type="submit" name="start" class="startTimer {{$val->task_id}}" value="Start" disabled="disabled"></form></td>
                        <td><form method="post" action="{{url("employees/task/pause")}}?userid={{$auth->user_id}}&taskid={{$val->task_id}}&timelineid={{$val->user_task_timeline_id}}">{{csrf_field()}}<input type="submit"  name="pause" class="pauseTimer {{$val->task_id}}" value="Pause" ></form></td>
                        <td><form method="post" action="{{url("employees/task/stop")}}?userid={{$auth->user_id}}&taskid={{$val->task_id}}">{{csrf_field()}}<input type="submit" name="stop" class="stopTimer {{$val->task_id}}" value="Stop" ></form></td>
                    @elseif($val->status_by_user == 'Pause')
                        <td><form method="post" action="{{url("employees/task/start")}}?userid={{$auth->user_id}}&taskid={{$val->task_id}}&timelineid={{$val->user_task_timeline_id}}">{{csrf_field()}}<input type="submit" name="start" class="startTimer {{$val->task_id}}" value="Start" ></form></td>
                        <td><form method="post" action="{{url("employees/task/pause")}}?userid={{$auth->user_id}}&taskid={{$val->task_id}}">{{csrf_field()}}<input type="submit"  name="pause" class="pauseTimer {{$val->task_id}}" value="Pause" disabled="disabled"></form></td>
                        <td><form method="post" action="{{url("employees/task/stop")}}?userid={{$auth->user_id}}&taskid={{$val->task_id}}">{{csrf_field()}}<input type="submit" name="stop" class="stopTimer {{$val->task_id}}" value="Stop"></form></td>
                    @elseif($val->status_by_user == 'Stop')
                        <td><form method="post" action="{{url("employees/task/start")}}?userid={{$auth->user_id}}&taskid={{$val->task_id}}&timelineid={{$val->user_task_timeline_id}}">{{csrf_field()}}<input type="submit" name="start" class="startTimer {{$val->task_id}}" value="Start" disabled="disabled"></form></td>
                        <td><form method="post" action="{{url("employees/task/pause")}}?userid={{$auth->user_id}}&taskid={{$val->task_id}}&timelineid={{$val->user_task_timeline_id}}">{{csrf_field()}}<input type="submit"  name="pause" class="pauseTimer {{$val->task_id}}" value="Pause" disabled="disabled"></form></td>
                        <td><form method="post" action="{{url("employees/task/stop")}}?userid={{$auth->user_id}}&taskid={{$val->task_id}}">{{csrf_field()}}<input type="submit" name="stop" class="stopTimer {{$val->task_id}}" value="Stop" disabled="disabled"></form></td>
                    @else
                        <td><form method="post" action="{{url("employees/task/start")}}?userid={{$auth->user_id}}&taskid={{$val->task_id}}&timelineid={{$val->user_task_timeline_id}}">{{csrf_field()}}<input type="submit" name="start" class="startTimer {{$val->task_id}}" value="Start" ></form></td>
                        <td><form method="post" action="{{url("employees/task/pause")}}?userid={{$auth->user_id}}&taskid={{$val->task_id}}&timelineid={{$val->user_task_timeline_id}}">{{csrf_field()}}<input type="submit"  name="pause" class="pauseTimer {{$val->task_id}}" value="Pause" disabled="disabled"></form></td>
                        <td><form method="post" action="{{url("employees/task/stop")}}?userid={{$auth->user_id}}&taskid={{$val->task_id}}&timelineid={{$val->user_task_timeline_id}}">{{csrf_field()}}<input type="submit" name="stop" class="stopTimer {{$val->task_id}}" value="Stop" disabled="disabled"></form></td>
                    @endif
                @endif
                <!--end of action buttons-->
                </td>
                <td>{{$val->status_by_admin or "-"}}</td>
                </tr>
            @endforeach
            </table>
        </div>

        <br>
        <br>


    </div>

    <div class="panel mt-3">
        <table class="table">
            <thead>
                <th class="text-center">Toggle</th>
                <th class="text-center">Task title</th>
                <th class="text-center">Action</th>
            </thead>
            <tbody>
                @php
                    $count = 0;
                @endphp
                @foreach ($tasks as $task)
                    <tr id="{{$task->task_id}}">
                        <td class="text-center"><button class="btn btn-primary" style="border-radius: 20px;"><i class="fa fa-arrow-circle-down"></i></button></td>
                        <td class="text-center">{{ $task->task_title }}</td>
                        <td class="text-center">
                            <div style="display: inline-block">
                                <form method="post" action="{{url("employees/task/start")}}?user_id={{$auth->user_id}}&task_id={{$task->task_id}}&timelineid={{$task->user_task_timeline_id}}">
                                    {{csrf_field()}}
                                    <input type="hidden" name="start" value="Start">
                                    <button type="submit" class="startTimer btn btn-primary">Start</button>
                                </form>
                            </div>
                            <div style="display: inline-block">
                                <form method="post" action="{{url("employees/task/pause")}}?userid={{$auth->user_id}}&taskid={{$task->task_id}}&timelineid={{$task->user_task_timeline_id}}">
                                    {{csrf_field()}}
                                    <input type="hidden" name="pause" value="Pause">
                                    <button type="submit" class="btn btn-primary pauseTimer">Pause</button>
                                </form>
                            </div>
                            <div style="display: inline-block">
                                <form method="post" action="{{url("employees/task/stop")}}?userid={{$auth->user_id}}&taskid={{$task->task_id}}">
                                    {{csrf_field()}}
                                    <input type="hidden" name="stop" value="Stop">
                                    <button type="submit" class="btn btn-primary stopTimer">Stop</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@stop
