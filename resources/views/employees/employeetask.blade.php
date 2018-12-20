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

        
    

    <div class="panel mt-3">
        <h2>Tasks</h2>
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
