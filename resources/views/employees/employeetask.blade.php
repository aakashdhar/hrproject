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
            
            <div id="DateCountdown" data-date='<?php
            if(!empty(Session::get("usertaskdata")))
            {
                
                $data = Session::get("usertaskdata");           
                $task = DB::select('select start_datetime from tasks where user_id='.$data[0]['userid'].' and task_id='.$data[0]['taskid']);               
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
                <?php
                $data = \Auth::user();
                
                $task = Illuminate\Support\Facades\DB::select("select t.*,tt.status_by_user,tt.user_task_timeline_id,tt.halt_datetime from tasks as t left join user_task_timeline as tt on t.task_id=tt.task_id where t.user_id=$data->user_id");
                
                
                ?>
            <!--start action buttons-->    
            @foreach($task as $val)
            <tr>
                
                <td>{{$val->task_id}}</td>
                <td>{{$val->task}}  <img src="{{asset("icons/plus.png")}}" height="15" width="15">
                <hr/>
                <table>
                    <thead>
                        <th>Status :</th>
                        <th>Start  :</th>
                        <th>Pause  :</th>
                        <th>Stop   :</th>
                    </thead>
                        <?php
                    
                            $tasktime = DB::select("select * from user_task_timeline where task_id=$val->task_id and user_id=$val->user_id");
                            //dump($tasktime);
                            ?>
                    <tbody>
                        @foreach($tasktime as $taskd)
                   
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
                        <td><form method="post" action="{{url("employees/task/start")}}?userid={{$data->user_id}}&taskid={{$val->task_id}}&timelineid={{$val->user_task_timeline_id}}">{{csrf_field()}}<input type="submit" name="start" class="startTimer {{$val->task_id}}" value="Start" disabled="disabled"></form></td>
                        <td><form method="post" action="{{url("employees/task/pause")}}?userid={{$data->user_id}}&taskid={{$val->task_id}}&timelineid={{$val->user_task_timeline_id}}">{{csrf_field()}}<input type="submit"  name="pause" class="pauseTimer {{$val->task_id}}" value="Pause" ></form></td>
                        <td><form method="post" action="{{url("employees/task/stop")}}?userid={{$data->user_id}}&taskid={{$val->task_id}}&timelineid={{$val->user_task_timeline_id}}">{{csrf_field()}}<input type="submit" name="stop" class="stopTimer {{$val->task_id}}" value="Stop" ></form></td>
                    @elseif($val->status_by_user == 'Pause')
                        <td><form method="post" action="{{url("employees/task/start")}}?userid={{$data->user_id}}&taskid={{$val->task_id}}&timelineid={{$val->user_task_timeline_id}}">{{csrf_field()}}<input type="submit" name="start" class="startTimer {{$val->task_id}}" value="Start" ></form></td>
                        <td><form method="post" action="{{url("employees/task/pause")}}?userid={{$data->user_id}}&taskid={{$val->task_id}}&timelineid={{$val->user_task_timeline_id}}">{{csrf_field()}}<input type="submit"  name="pause" class="pauseTimer {{$val->task_id}}" value="Pause" disabled="disabled"></form></td>
                        <td><form method="post" action="{{url("employees/task/stop")}}?userid={{$data->user_id}}&taskid={{$val->task_id}}&timelineid={{$val->user_task_timeline_id}}">{{csrf_field()}}<input type="submit" name="stop" class="stopTimer {{$val->task_id}}" value="Stop"></form></td>
                    @elseif($val->status_by_user == 'Stop')
                        <td><form method="post" action="{{url("employees/task/start")}}?userid={{$data->user_id}}&taskid={{$val->task_id}}&timelineid={{$val->user_task_timeline_id}}">{{csrf_field()}}<input type="submit" name="start" class="startTimer {{$val->task_id}}" value="Start" disabled="disabled"></form></td>
                        <td><form method="post" action="{{url("employees/task/pause")}}?userid={{$data->user_id}}&taskid={{$val->task_id}}&timelineid={{$val->user_task_timeline_id}}">{{csrf_field()}}<input type="submit"  name="pause" class="pauseTimer {{$val->task_id}}" value="Pause" disabled="disabled"></form></td>
                        <td><form method="post" action="{{url("employees/task/stop")}}?userid={{$data->user_id}}&taskid={{$val->task_id}}&timelineid={{$val->user_task_timeline_id}}">{{csrf_field()}}<input type="submit" name="stop" class="stopTimer {{$val->task_id}}" value="Stop" disabled="disabled"></form></td>
                    @else
                        <td><form method="post" action="{{url("employees/task/start")}}?userid={{$data->user_id}}&taskid={{$val->task_id}}&timelineid={{$val->user_task_timeline_id}}">{{csrf_field()}}<input type="submit" name="start" class="startTimer {{$val->task_id}}" value="Start" ></form></td>
                        <td><form method="post" action="{{url("employees/task/pause")}}?userid={{$data->user_id}}&taskid={{$val->task_id}}&timelineid={{$val->user_task_timeline_id}}">{{csrf_field()}}<input type="submit"  name="pause" class="pauseTimer {{$val->task_id}}" value="Pause" disabled="disabled"></form></td>
                        <td><form method="post" action="{{url("employees/task/stop")}}?userid={{$data->user_id}}&taskid={{$val->task_id}}&timelineid={{$val->user_task_timeline_id}}">{{csrf_field()}}<input type="submit" name="stop" class="stopTimer {{$val->task_id}}" value="Stop" disabled="disabled"></form></td>
                    @endif
                        
                @elseif($val->status_by_admin == 'Complete')
                    <td></td>
                    <td></td>
                    <td></td>
                @else
                @if($val->status_by_user == 'Start')
                        <td><form method="post" action="{{url("employees/task/start")}}?userid={{$data->user_id}}&taskid={{$val->task_id}}&timelineid={{$val->user_task_timeline_id}}">{{csrf_field()}}<input type="submit" name="start" class="startTimer {{$val->task_id}}" value="Start" disabled="disabled"></form></td>
                        <td><form method="post" action="{{url("employees/task/pause")}}?userid={{$data->user_id}}&taskid={{$val->task_id}}&timelineid={{$val->user_task_timeline_id}}">{{csrf_field()}}<input type="submit"  name="pause" class="pauseTimer {{$val->task_id}}" value="Pause" ></form></td>
                        <td><form method="post" action="{{url("employees/task/stop")}}?userid={{$data->user_id}}&taskid={{$val->task_id}}">{{csrf_field()}}<input type="submit" name="stop" class="stopTimer {{$val->task_id}}" value="Stop" ></form></td>
                    @elseif($val->status_by_user == 'Pause')
                        <td><form method="post" action="{{url("employees/task/start")}}?userid={{$data->user_id}}&taskid={{$val->task_id}}&timelineid={{$val->user_task_timeline_id}}">{{csrf_field()}}<input type="submit" name="start" class="startTimer {{$val->task_id}}" value="Start" ></form></td>
                        <td><form method="post" action="{{url("employees/task/pause")}}?userid={{$data->user_id}}&taskid={{$val->task_id}}">{{csrf_field()}}<input type="submit"  name="pause" class="pauseTimer {{$val->task_id}}" value="Pause" disabled="disabled"></form></td>
                        <td><form method="post" action="{{url("employees/task/stop")}}?userid={{$data->user_id}}&taskid={{$val->task_id}}">{{csrf_field()}}<input type="submit" name="stop" class="stopTimer {{$val->task_id}}" value="Stop"></form></td>
                    @elseif($val->status_by_user == 'Stop')
                        <td><form method="post" action="{{url("employees/task/start")}}?userid={{$data->user_id}}&taskid={{$val->task_id}}&timelineid={{$val->user_task_timeline_id}}">{{csrf_field()}}<input type="submit" name="start" class="startTimer {{$val->task_id}}" value="Start" disabled="disabled"></form></td>
                        <td><form method="post" action="{{url("employees/task/pause")}}?userid={{$data->user_id}}&taskid={{$val->task_id}}&timelineid={{$val->user_task_timeline_id}}">{{csrf_field()}}<input type="submit"  name="pause" class="pauseTimer {{$val->task_id}}" value="Pause" disabled="disabled"></form></td>
                        <td><form method="post" action="{{url("employees/task/stop")}}?userid={{$data->user_id}}&taskid={{$val->task_id}}">{{csrf_field()}}<input type="submit" name="stop" class="stopTimer {{$val->task_id}}" value="Stop" disabled="disabled"></form></td>
                    @else
                        <td><form method="post" action="{{url("employees/task/start")}}?userid={{$data->user_id}}&taskid={{$val->task_id}}&timelineid={{$val->user_task_timeline_id}}">{{csrf_field()}}<input type="submit" name="start" class="startTimer {{$val->task_id}}" value="Start" ></form></td>
                        <td><form method="post" action="{{url("employees/task/pause")}}?userid={{$data->user_id}}&taskid={{$val->task_id}}&timelineid={{$val->user_task_timeline_id}}">{{csrf_field()}}<input type="submit"  name="pause" class="pauseTimer {{$val->task_id}}" value="Pause" disabled="disabled"></form></td>
                        <td><form method="post" action="{{url("employees/task/stop")}}?userid={{$data->user_id}}&taskid={{$val->task_id}}&timelineid={{$val->user_task_timeline_id}}">{{csrf_field()}}<input type="submit" name="stop" class="stopTimer {{$val->task_id}}" value="Stop" disabled="disabled"></form></td>
                    @endif
                @endif       
                <!--end of action buttons-->
                </td>
                <td>{{$val->status_by_admin or "-"}}</td>   
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
