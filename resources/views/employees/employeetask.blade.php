@extends('adminlte::page')

@section('title', 'Tasks')
<?php
$seconds_timer = 0;
$minutes_timer = 0;
$hour_timer = 0;
$status_timer = false;
$timer_task_name = '';
if(\Session::has('timer_data')){

    $data = \Session::get('timer_data');
    $timer_task_name = $data['task_name'];
    if($data['status'] != 'Stop'){
        $seconds_timer = $data['second'];
        $minutes_timer = $data['minute'];
        $hour_timer = $data['hour'];
        if($data['status'] == 'Start'){
            $status_timer = true;
        }
    }

    \Session::forget('timer_data');
}
?>


@section('content_header')

@stop
<!-- start of fetch cookie value -->
<input type="hidden" id="dateCookie" value="{{Cookie::get('date')}}" name="cookie" />
<input type="hidden" id="timeCookie" value="{{Cookie::get('time')}}" name="cookie" />
<!--end-->
@section('content')
     <div class="container">
            <?php date_default_timezone_set("Asia/Kolkata"); ?>
            <h2 style="font-family:'Digital';font-size:40px;">TIME SPENT</h2>
            {{-- dd-mm-yyyy h:i:s --}}
            @if(!empty($timer_task_name) && $timer_task_name != '')
            <h2 style="text-align:center;font-family:'Digital;font-size:18px;'"><b>Current Task : </b>{{ $timer_task_name }}</h2>
            @endif
            <div id="DateCountdown" style="width: 500px; height: 125px; padding: 0px; box-sizing: border-box; background-color: #E0E8EF;line-height:125px;font-size:100px;font-family:'Digital';text-align:center;margin:0 auto;">
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
                            <?php
                            if($t_seconds > 60){
                                $minute = $t_seconds/60;
                                $t_minute = $t_minute + floor($minute);
                                $minute_fl = floor($minute);
                                $seconds = $t_seconds - ($minute_fl * 60);
                                $t_seconds = $seconds;
                            }

                            if($t_minute > 60){
                                $hour = $t_minute/60;
                                $t_hour = $t_hour + floor($hour);
                                $hour_fl = floor($hour);
                                $minutes = $t_minute - ($hour_fl * 60);
                                $t_minute = floor($minutes);
                            }
                            ?>

                    {{-- {{dd($t_minute,$t_seconds,$t_hour)}} --}}
                    {{-- {{dd($total_time_spent)}} --}}
                    <tr id="{{$task->task_id}}">
                        <td class="text-center"><a href="javascript:data_details('.data-list-{{ $task->task_id }}')" class="btn btn-primary" style="border-radius: 20px;"><i class="fa fa-arrow-down"></i></a></td>
                        <td class="text-center">{{ $task->task_title or "-"}}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#moreDetails-{{$task->task_id}}">View more details</button>
                        </td>
                        <td class="text-center"> {{ $t_hour.":".$t_minute.":".$t_seconds }} </td>
                        <td class="text-center">
                            @if ($task->task_status == 'Finished')
                                Completed
                            @else
                                <div style="display: inline-block">
                                    <form action="/employees/task/start" method="POST" id="{{ $task->task_id }}">
                                        {{ csrf_field() }}
                                        <input type="hidden" value="Start" name="status">
                                        <input type="hidden" value="{{ $auth->user_id }}" name="user_id">
                                        <input type="hidden" value="{{ $task->task_id }}" name="task_id">
                                        <input type="hidden" value="{{ $task->user_task_timeline_id }}" name="timeline_id"> {{-- <button type="submit" class="startTimer btn btn-primary"
                                            onclick="timerStatus('{{ $task->task_id }}','{{ $auth->user_id }}','{{ $task->user_task_timeline_id }}','Start')">Start</button>        --}}
                                            @if ($task->task_status == 'Finished' || $task->task_status == 'Started')
                                            <button type="submit" class="startTimer btn btn-success" disabled>Start</button>
                                        @else
                                        @if ($started_count == 1)
                                        <button type="submit" class="startTimer btn btn-success" disabled>Start</button>
                                        @elseif($task->task_status == 'Paused')
                                        <button type="submit" class="startTimer btn btn-success">Resume</button>
                                        @else
                                        <button type="submit" class="startTimer btn btn-success">Start</button>
                                        @endif
                                        @endif

                                    </form>
                                </div>
                                <div style="display: inline-block">
                                    <form action="/employees/task/start" method="POST" id="{{ $task->task_id }}">
                                        {{ csrf_field() }}
                                        <input type="hidden" value="Pause" name="status">
                                        <input type="hidden" value="{{ $auth->user_id }}" name="user_id">
                                        <input type="hidden" value="{{ $task->task_id }}" name="task_id"> {{-- <button type="submit" class="btn btn-primary pauseTimer"
                                            onclick="timerStatus('{{ $task->task_id }}','{{ $auth->user_id }}','{{ $task->user_task_timeline_id }}','Pause')">Pause</button>        --}} @if ($task->task_status == 'Finished' || $task->task_status == 'Paused' || $task->timeline->count() == 0)
                                        <button type="submit" class="btn btn-warning pauseTimer" disabled>Pause</button> @else
                                        <button type="submit" class="btn btn-warning pauseTimer">Pause</button> @endif

                                    </form>
                                </div>
                                <div style="display: inline-block">
                                    <form action="/employees/task/start" method="POST" id="{{ $task->task_id }}">
                                        {{ csrf_field() }}
                                        <input type="hidden" value="Stop" name="status">
                                        <input type="hidden" value="{{ $auth->user_id }}" name="user_id">
                                        <input type="hidden" value="{{ $task->task_id }}" name="task_id"> {{-- <button type="submit" class="btn btn-primary stopTimer"
                                            onclick="timerStatus('{{ $task->task_id }}','{{ $auth->user_id }}','{{ $task->user_task_timeline_id }}','Stop')">Stop</button>        --}} @if ($task->task_status == 'Finished' || $task->task_status == 'Not Started')
                                        <button type="submit" class="btn btn-danger stopTimer" disabled>Stop</button> @else
                                        <button type="submit" class="btn btn-danger stopTimer">Stop</button> @endif

                                    </form>
                                </div>
                            @endif
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
                    <div id="moreDetails-{{$task->task_id}}" class="modal fade" tabindex="-1" role="dialog">
                        <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Task Details</h4>
                                </div>
                                <div class="modal-body">
                                    <h4><b>Title :</b> {{ $task->task_title }}</h4>
                                    <br>
                                    <h4><b>Description :</b> {{ $task->task_description }}</h4>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>
@stop


@push('body_script')
<script>
        var myclose = false;


        var date;
        var time;
        var datetime;
        var digitsOfDate;
        var digitsofHours;
        var digitsofMinutes;
        var d = new Date();

               var sec_timer = "{{ $seconds_timer }}";
               var min_timer = "{{ $minutes_timer }}";
               var hr_timer  = "{{ $hour_timer }}";
               var stat_timer = "{{ $status_timer }}";

            $('#DateCountdown').countimer({
                enableEvents: false,
                autoStart : stat_timer,
                useHours : true,
                minuteIndicator: '',
                secondIndicator: '',
                separator : ':',
                leadingZeros: 2,
                initHours : hr_timer,
                initMinutes : min_timer,
                initSeconds: sec_timer
              });






    {{--  $("#DateCountdown").TimeCircles().stop();  --}}
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

$(document).ready(function(){
    $(window).on('mouseover', (function () {
        window.onbeforeunload = null;
    }));
    $(window).on('mouseout', (function () {
        window.onbeforeunload = ConfirmLeave;
    }));
    function ConfirmLeave() {
        if(confirm('Test')){
            return false;
        }
    }
    var prevKey="";
    $(document).keydown(function (e) {            
        
        if (e.key.toUpperCase() == "F4" && (prevKey == "ALT" || prevKey == "CONTROL")) {
            return false;
        }
        if (e.key=="F5") {
            window.onbeforeunload = ConfirmLeave();
        }
        else if (e.key.toUpperCase() == "W" && prevKey == "CONTROL") {                
            window.onbeforeunload = ConfirmLeave();   
        }
        else if (e.key.toUpperCase() == "R" && prevKey == "CONTROL") {
            window.onbeforeunload = ConfirmLeave();
        }
        else if (e.key.toUpperCase() == "F4" && (prevKey == "ALT" || prevKey == "CONTROL")) {
            window.onbeforeunload = ConfirmLeave();
            return false;
        }
        prevKey = e.key.toUpperCase();
    
    });

    $(document).keypress(function(e) {
        console.log(e.key.toUpperCase(),prevKey);
        if (e.key.toUpperCase() == "F4" && (prevKey == "ALT" || prevKey == "CONTROL")) {
            window.onbeforeunload = ConfirmLeave;
            return false;
        }
    });
});
</script>

@endpush