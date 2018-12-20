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
                <th class="text-center">Details</th>
                <th class="text-center">Task title</th>
                <th class="text-center">Task Description</th>
                <th class="text-center">Task Status</th>
                <th class="text-center">Action</th>
            </thead>
            <tbody>
                @php
                    $count = 0;
                @endphp
                @foreach ($tasks as $task)
                    <tr id="{{$task->task_id}}">
                        <td class="text-center"><a href="javascript:data_details('.data-list-{{ $task->task_id }}')" class="btn btn-primary" style="border-radius: 20px;"><i class="fa fa-arrow-down"></i></a></td>
                        <td class="text-center">{{ $task->task_title or "-"}}</td>
                        <td class="text-center"> {{ $task->task_description or "No task body" }} </td>
                        <td class="text-center"> {{ $task->task_status }} </td>
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
                    @php
                        $count = 0;
                    @endphp
                    <tr class="data-list data-list-{{ $task->task_id }}">
                        <th></th>
                        <th class="text-center">Sr no.</th>
                        <th class="text-center">Started at</th>
                        <th class="text-center">Finished at</th>
                        <th class="text-center">Status</th>
                    </tr>
                    @foreach($task->timeline as $timeline)
                    <tr class="data-list data-list-{{ $task->task_id }}">
                        <td></td>
                        <td class="text-center"> <i>{{ ++$count }}</i> </td>
                        <td class="text-center"> <i>{{ \Carbon\Carbon::parse($timeline->log_task_started_at)->toDayDateTimeString() }} </i></td>
                        <td class="text-center"><i>
                            @if ($timeline->log_task_finished_at == null)
                                -
                            @else
                                {{ \Carbon\Carbon::parse($timeline->log_task_finished_at)->toDayDateTimeString() }}
                            @endif
                            </i>
                        </td>
                        <td class="text-center"> <i>{{ $timeline->log_task_status }}</i> </td>
                    </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </div>
@stop
