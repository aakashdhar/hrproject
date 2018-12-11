@extends('adminlte::page')

@section('title', 'Tasks')



@section('content')
    
    <br>
    <div class="panel">
        <div class="panel-heading">
        </div>
        <div class="panel-body">
            <h2>Assign Task to User</h2>
            <form action="{{url("tasks/assignTask")}}" method="post">
                <?php
                $data = \Illuminate\Support\Facades\DB::table("users")->where("user_type","!=","Admin")->join("user_types","user_types.user_type_id","users.user_type_id")->select("users.user_id","users.user_first_name","users.user_last_name")->get();
                
                ?>
                {{ csrf_field() }}
                <table id="usertask" class="table tab-content table-responsive">
                    
                    <tr>
                        <td>Choose User :</td>
                        <td>
                            <select name="userwithid" class="form-control">
                                 @foreach($data as $val)
                                 <option>
                                     {{$val->user_id}},{{$val->user_first_name}} {{$val->user_last_name}}
                                 </option>
                                 @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Give task here :
                        </td>
                        <td>
                            <textarea name="task" rows="4" cols="20" class="form-control" name="taskname" required></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <input type="submit" class="btn btn-primary" value="Assign" name="assigntask">
                        </td>
                    </tr>
                </table>
            </form>
        </div>
        
        <div class="panel-body">
            <h2>List of Users with Tasks</h2>
            <?php
                $data = Illuminate\Support\Facades\DB::table("user_tasks")
                        ->where("users.user_type_id","!=",1)
                        ->join("users","users.user_id","user_tasks.user_id")
                        ->select("user_tasks.*","users.user_id","users.user_first_name","users.user_last_name")
                        ->get();
                $user = \Auth::user();
                
                    ?>
            
                <table class="table tab-content table-responsive">
                    <thead><th>User ID</th>
                    <th>Name</th>
                    <th>Task</th>
                    <th>Start Date & Time</th>
                    <th>End Date & Time</th>
                    <th>Status By User</th>
                    <th colspan="2">Status By Admin</th>
                    </thead>
                    <tbody>
                    @foreach($data as $val)
                    <tr>
                        
                        <td>{{$val->user_id}}</td>
                        <td>{{$val->user_first_name}} {{$val->user_last_name}}</td>
                        <td>{{$val->task}}</td>
                        <td>{{$val->start_date}} {{$val->start_time}}</td>
                        <td>{{$val->end_date}} {{$val->end_time}}</td>
                        <td>{{$val->status_user}}</td>
                        <td>
                            <form method="post" action="tasks/statusByAdmin?taskid={{$val->task_id}}&userid={{$val->user_id}}">
                                {{csrf_field()}}
                                <input type="hidden" name="status" value="reassign" />
                                <input type="submit" name="adminanswer" value="Reassign"  class="btn button"/>
                            </form>
                        </td>
                        <td>
                            <form method="post" action="tasks/statusByAdmin?taskid={{$val->task_id}}&userid={{$val->user_id}}">
                                {{csrf_field()}}                                
                                <input type="hidden" name="status" value="done" />
                                <input type="submit" name="adminanswer" value="Complete"  class="btn btn-primary"/>
                            </form>
                        </td>
                        
                    </tr>
                    </tbody>
                    @endforeach
                </table>
            
        </div>
    </div>

    <div id="newAdminModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <form action="{{ route('admin.store') }}" method="post">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Add new admin</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="user_name">User name</label>
                                <input type="text" name="user_name" id="user_name" class="form-control" placeholder="First name" required>
                            </div>
                            <div class="col-md-4">
                                <label for="user_first_name">First name</label>
                                <input type="text" name="user_first_name" id="user_first_name" class="form-control" placeholder="First name" required>
                            </div>
                            <div class="col-md-4">
                                <label for="user_last_name">Last name</label>
                                <input type="text" name="user_last_name" id="user_last_name" class="form-control" placeholder="Last name">
                            </div>

                        </div>
                        <div class="row" style="margin-top: 2%;">
                            <div class="col-md-4">
                                <label for="user_email">Email</label>
                                <input type="email" name="user_email" id="user_email" class="form-control" placeholder="Email" required>
                            </div>
                            <div class="col-md-4">
                                <label for="user_contact_no">Contact</label>
                                <input type="number" name="user_contact_no" id="user_contact_no" class="form-control" placeholder="Contact no">
                            </div>
                            <div class="col-md-4">
                                <label for="user_password">Password</label>
                                <input type="password" name="user_password" id="user_password" class="form-control" placeholder="Password" required>
                            </div>

                        </div>
                        <div class="row" style="margin-top: 2%;">
                            <div class="col-md-4">
                                <label for="user_address">Address</label>
                                <textarea name="user_address" class="form-control" id="user_address" placeholder="Address"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>

        </div>
    </div>
@stop
<script>
    
</script>