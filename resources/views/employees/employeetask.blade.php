
@extends('adminlte::page')

@section('title', 'Admins')

@section('content_header')
    <div class="row">
        
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
@stop