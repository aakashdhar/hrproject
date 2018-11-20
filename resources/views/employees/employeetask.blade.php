
@extends('adminlte::page')

@section('title', 'Admins')

@section('content_header')
    <div class="row">
        <div class="col-md-3"></div>
        
   </div>

@stop

@section('content')
    <!--timer-->
    <link rel="stylesheet" type="text/css" href="{{asset("timer/TimeCircles.css")}}">
    <link rel="stylesheet" type="text/css" href="{{asset("timer/boostrap.min.css")}}">
    <script src="{{asset("timer/TimeCircles.js")}}"></script>
    <script src="{{asset("timer/jquery.min.js")}}"></script>
    <br>
    <div class="panel">
        <div class="container">
            <h1>TimeCircle examples</h1>
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
            <hr>
        </div>
        <script>
            $("#DateCountdown").TimeCircles();
            $("#CountDownTimer").TimeCircles({ time: { Days: { show: false }, Hours: { show: false } }});
            $("#PageOpenTimer").TimeCircles();
            
            var updateTime = function(){
                var date = $("#date").val();
                var time = $("#time").val();
                var datetime = date + ' ' + time + ':00';
                $("#DateCountdown").data('date', datetime).TimeCircles().start();
            }
            $("#date").change(updateTime).keyup(updateTime);
            $("#time").change(updateTime).keyup(updateTime);
            
            // Start and stop are methods applied on the public TimeCircles instance
            $(".startTimer").click(function() {
                $("#CountDownTimer").TimeCircles().start();
            });
            $(".stopTimer").click(function() {
                $("#CountDownTimer").TimeCircles().stop();
            });

            // Fade in and fade out are examples of how chaining can be done with TimeCircles
            $(".fadeIn").click(function() {
                $("#PageOpenTimer").fadeIn();
            });
            $(".fadeOut").click(function() {
                $("#PageOpenTimer").fadeOut();
            });

        </script>   
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
                <td>{{$val->start_datetime or "-"}}</td>
                <td>{{$val->pause_datetime or "-"}}</td>
                <td>{{$val->stop_datetime or "-"}}</td>
                <td>{{$val->task_status_user or "-"}}</td>
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
@stop