@extends('adminlte::page')

@section('title', 'Admins')

@section('content_header')
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-9">
            <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#newAdminModal">Add new</button>
        </div>
    </div>

@stop

@section('content')
    
    <br>
    <div class="panel">
        <div class="panel-heading">
            <a href="{{url("admin/addUser")}}">User Registration</a> >> <a href="{{url("admin/task")}}">Task Distribution</a> >> <a href="{{url("admin/leave")}}">Leave Applications</a>
        </div>
        <div class="panel-body">
            <h2>Applications</h2>
        <div class="panel-body">
                <table id="applications" class="table text-center table-bordered table-hover">
                
                <?php
                                        
                    $data = DB::table('user_holiday')
                    ->join('users', 'user_holiday.user_id', '=', 'users.user_id')
                    ->select('user_holiday.*')
                    ->get();
                    $count = 1; 
                ?>
                <tr>
                    <th>No.</th>
                    <th>User ID</th>
                    <th>start date</th>
                    <th>end date</th>
                    
                    <th>subject</th>
                    <th>reason</th>
                    <th>Status</th>
                    <th></th>
                </tr>
                @if(empty($data))
                   <tr><td>NO Applications yet</td></tr>
                @else  
                @foreach($data as $val)
                <tr>
                    <td>{{$count++}}</td>
                    <td>{{$val->user_id}}</td>
                    <td>{{$val->user_holiday_from}}</td>
                    <td>{{$val->user_holiday_to}}</td>
                    <td>{{$val->user_holiday_subject}}</td>
                    <td>{{$val->user_holiday_reason}}</td>
                    <td>{{$val->user_holiday_approval_status}}</td>
                    <td>
                        <form action="{{url('admin/leave/accept')}}?holidayid={{$val->user_holiday_id}}&id={{$val->user_id}}&start_date={{$val->user_holiday_from}}&end_date={{$val->user_holiday_to}}" method="POST">
                             {{ csrf_field() }}
                             <input type="hidden" name="answer" value="accept">
                             <input type="submit" class="button" value="Accept">
                         </form>
                    </td>
                    <td>
                        <form action="{{url('admin/leave/reject')}}?holidayid={{$val->user_holiday_id}}&id={{$val->user_id}}&start_date={{$val->user_holiday_from}}&end_date={{$val->user_holiday_to}}" method="POST">
                             {{ csrf_field() }}
                             <input type="hidden" name="answer" value="reject">
                             <input type="submit" class="button" class="button" value="Reject">
                         </form>
                    </td>
                </tr>
                @endforeach
                @endif
            </table>
            </div>

        </div>
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