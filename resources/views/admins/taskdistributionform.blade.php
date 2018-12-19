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
                {{ csrf_field() }}
                <table id="usertask" class="table tab-content table-responsive">
                    <tr>
                        <td>Choose User :</td>
                        <td>
                            <select name="userwithid" class="form-control">
                                <option disabled selected>Select user...</option>
                                 @foreach($users as $val)
                                <option value="{{$val->user_id}}">
                                     {{ucwords($val->user_first_name)}} {{ucwords($val->user_last_name)}} [{{ $val->user_name }}]
                                 </option>
                                 @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Task Title :</td>
                        <td>
                            <input type="text" name="taskTitle" class="form-control" required/>
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
                            <button type="submit" class="btn btn-primary pull-right" name="assigntask">Assign</button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>

        <div class="panel-body">
            <h2>List of Users with Tasks</h2>
                <table class="table tab-content table-responsive">
                    <th class="text-center">Name</th>
                    <th class="text-center">Task</th>
                    <th class="text-center">Start Date & Time</th>
                    <th class="text-center">Pause/Stop Date & Time</th>
                    <th class="text-center">Status By User</th>
                    <th class="text-center" colspan="2">Status By Admin</th>
                    <th class="text-center" colspan="2">Actions</th>
                    </thead>
                    <tbody>
                    @foreach($tasks as $val)
                    <tr>
                        <td class="text-center">{{$val->assignedTo->full_name or '-'}}</td>
                        <td class="text-center">{{$val->task_title or '-'}}</td>
                        <td class="text-center">{{$val->start_datetime or '-'}}</td>
                        <td class="text-center">{{$val->end_datetime or '-'}}</td>
                        <td class="text-center">{{$val->status_by_user or '-'}}</td>
                        <td>
                            <form method="post" action="tasks/statusByAdmin?taskid={{$val->task_id}}&userid={{$val->user_id}}">
                                {{csrf_field()}}
                                <input type="hidden" name="status" value="reassign" />
                                <input type="submit" name="adminanswer" value="Reassign"  class="btn button"/>
                            </form>
                        </td>
                        <td class="text-center">
                            <form method="post" action="tasks/statusByAdmin?taskid={{$val->task_id}}&userid={{$val->user_id}}">
                                {{csrf_field()}}
                                <input type="hidden" name="status" value="done" />
                                <input type="submit" name="adminanswer" value="Complete"  class="btn btn-primary"/>
                            </form>
                        </td>
                        <td class="text-center">
                            <form method="post" action="tasks/delete-task">
                                    {{csrf_field()}}
                                    <input type="hidden" name="taskid" value="{{ $val->task_id }}" />
                                    <button type="submit" name="adminanswer" class="btn"><i class="fa fa-trash"></i></button>

                            </form>
                        </td>
                        <td class="text-center">
                            <form method="post" action="tasks/edit-task">
                                    {{csrf_field()}}
                                    <input type="hidden" name="taskid" value="{{ $val->task_id }}" />
                                    <button type="submit" name="adminanswer" class="btn"><i class="fa fa-edit"></i></button>

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