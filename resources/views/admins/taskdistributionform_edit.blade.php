@extends('adminlte::page')

@section('title', 'Tasks')

@section('content_header')
    
    @stop

@section('content')
    
    <br>
    <div class="panel">
        <div class="panel-heading">
        </div>
        <div class="panel-body">
            <h2>Assign Task to User</h2>
            
            <form action="{{url("tasks/edit-task")}}" id="taskform" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="task_id" value="{{$taskdata->task_id}}">
                <table id="usertask" class="table tab-content table-responsive">
                    
                    <tr>
                        <td>Choose User :</td>
                        <td>
                            <pre>{{$taskdata->user_first_name}} {{$taskdata->user_last_name}}</pre>
                        </td>
                    </tr>
                    <tr>
                        <td>Task Title :</td>
                        <td>
                            <input class="form-control" type="text" name="taskTitle" value="{{$taskdata->task_title}}" required/>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Give task here :
                        </td>
                        <td>
                            <textarea name="task" rows="4" cols="20" class="form-control" id="task">{{$taskdata->task_description}}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <button type="submit" class="btn btn-primary" name="assigntask">Edit</button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>

    
@stop
<script>
    
</script>