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
        <table class="table" id="table_id">
            <thead>
                <th class="text-center">Details</th>
                <th class="text-center">Task title</th>
                <th class="text-center">Task Description</th>
                <th class="text-center">Total time spent</th>
                <th class="text-center">Action</th>
            </thead>
            <tbody>
                @php
                    $count = 0;
                @endphp
                {{ csrf_field() }}
                @foreach ($tasks as $task)
                    @php
                        $total_time_spent = '0000-00-00 00:00:00';
                        $t_minute = 0;
                        $t_hour = 0;
                        $t_seconds = 0;
                    @endphp
                    @foreach ($task->timeline as $timeline)
                        @php

                            if($timeline->log_task_finished_at != null && $timeline->log_task_started_at != null) {
                                $started = date('H:i:s', strtotime($timeline->log_task_started_at));
                                $end = date('H:i:s', strtotime($timeline->log_task_finished_at));
                                $spent = date_diff(new \DateTime($started), new \DateTime($end));
                                // $total_time_spent = new \DateTime($total_time_spent) + $spent;

                                // $date1 = new DateTime('2006-04-12T12:30:00');
                                // $date2 = new DateTime('2006-04-14T11:30:00');
                                $started = new \DateTime($started);
                                $end = new \DateTime($end);
                                $diff = new \DateTime();

                                $diff = $end->diff($started);
                                $second = $diff->s;
                                $minute = $diff->i;
                                $hours  = $diff->h;
                                $t_minute += $minute;
                                $t_hour += $hours;
                                $t_seconds += $second;
                            }
                        @endphp
                    @endforeach
                    {{-- {{dd($t_minute,$t_seconds,$t_hour)}} --}}
                    {{-- {{dd($total_time_spent)}} --}}
                    <tr id="{{$task->task_id}}">
                        <td class="text-center"><a href="javascript:data_details('.data-list-{{ $task->task_id }}')" class="btn btn-primary" style="border-radius: 20px;"><i class="fa fa-arrow-down"></i></a></td>
                        <td class="text-center">{{ $task->task_title or "-"}}</td>
                        <td class="text-center"> {{ $task->task_description or "No task body" }} </td>
                        <td class="text-center"> {{ $t_hour.":".$t_minute.":".$t_seconds }} </td>
                        <td class="text-center">
                            <div style="display: inline-block">
                                    <button type="button" class="startTimer btn btn-primary" onclick="timerStatus('{{ $task->task_id }}','{{ $auth->user_id }}','{{ $task->user_task_timeline_id }}','Start')">Start</button>
                            </div>
                            <div style="display: inline-block">
                                    <button type="button" class="btn btn-primary pauseTimer" onclick="timerStatus('{{ $task->task_id }}','{{ $auth->user_id }}','{{ $task->user_task_timeline_id }}','Pause')">Pause</button>
                            </div>
                            <div style="display: inline-block">
                                    <button type="button" class="btn btn-primary stopTimer" onclick="timerStatus('{{ $task->task_id }}','{{ $auth->user_id }}','{{ $task->user_task_timeline_id }}','Stop')">Stop</button>
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
                        <td class="text-center"> <i>{{ $timeline->log_task_started_at }} </i></td>
                        <td class="text-center"><i>
                            @if ($timeline->log_task_finished_at == null)
                                -
                            @else
                                {{ $timeline->log_task_finished_at }}
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


@push('body_script')
<script>
        var date;
        var time;
        var datetime;
        var digitsOfDate;
        var digitsofHours;
        var digitsofMinutes;
        var d = new Date();
        @if(!empty($data))
        var cookieDate =  "<?=$data[0]['date']?>";
        @endif
        @if(!empty($data))
        var cookieTime =  "<?=$data[0]['time']?>";
        @endif

        $("#DateCountdown").TimeCircles().stop();
        if(d.getDate()<10)
            digitsOfDate = "0"+d.getDate();
        if(d.getHours()<10)
            digitsofHours = "0"+d.getHours();
        if(d.getMinutes()<10)
            digitsofMinutes = "0"+d.getMinutes();
        <!--start watch-->
function timerStatus(task_id,user_id,timeline_id,status){
    {{--  console.log('task '+task_id,'time '+ timeline_id,'user '+user_id);  --}}
    var _token = $("input[name='_token']").val();
    var dt = new Date();
    var digitsOfDate = d.getDate();
    var digitsofHours = d.getHours();
    var digitsofMinutes = d.getMinutes();
    var digitsOfSeconds = d.getSeconds();
    if(d.getDate()<10){
        digitsOfDate = "0"+d.getDate();
    }
    if(d.getHours()<10){
        digitsofHours = "0"+d.getHours();
    }
    if(d.getMinutes()<10){
        digitsofMinutes = "0"+d.getMinutes();
    }
    var month = dt.getMonth() + 1;
    var current_date = dt.getDate() + '-' + month + '-' + dt.getFullYear();
    var time = digitsofHours + ':' + digitsofMinutes + ':' + digitsOfSeconds;
    var dateTime = current_date + ' ' + time;
    var dateTime = "{{ date('Y-m-d H:i:s') }}";

    $.ajax({
        url: '/employees/task/start',
        type: 'POST',
        data: { _token:_token,status:status,task_id:task_id,timeline_id:timeline_id,user_id:user_id,date_time:dateTime},
        dataType: 'JSON',
        success: function (data) {
            if(data.status){
                if(data.task_status === 'Start'){
                    $("#DateCountdown").TimeCircles().start();
                }else if(data.task_status === 'Pause'){
                    $("#DateCountdown").TimeCircles().stop();
                }else if(data.task_status === 'Stop'){
                    $("#DateCountdown").TimeCircles().stop();
                }
            }
            location.reload();
            $("#table_id").load(window.location + " #table_id");
        }
    });
}

</script>

@endpush