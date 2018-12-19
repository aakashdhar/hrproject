@extends('adminlte::page')

@section('title', 'Admins')

@section('content_header')
    
    @stop

@section('content')
    
    <br>
    <div class="panel">
        <div class="panel-heading">
        </div>
        <div class="panel-body">
            <h2>Assign Task to User</h2>
            <form action="{{url("tasks/assignTask")}}" id="taskform" method="post">
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
                        <td>Task Title :</td>
                        <td>
                            <input type="text" name="taskTitle" required/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Give task here :
                        </td>
                        <td>
                            <textarea name="task" rows="4" cols="20" class="form-control" id="task"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <button type="submit" class="btn btn-primary" name="assigntask">Assign</button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>

    
@stop
<script>
    
</script>