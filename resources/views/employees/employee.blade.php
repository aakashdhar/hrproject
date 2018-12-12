@extends('adminlte::page')

@section('title', 'Employees')

@section('content_header')
    
@stop
@section('content')
    
    <br>
    <div class="panel">
        <div class="panel-heading">
        <br/>          
        </div>
        <?php 
        $count = 1;
        $userdata = \Illuminate\Support\Facades\DB::select("SELECT * from users u,user_types ut where ut.user_type_id=u.user_type_id and ut.user_type!='Admin'") 
        ?>
        <div class="panel-body">
            <h2>Employees</h2>
            <table class="table text-center table-bordered table-hover">
                <thead>
                    <th>NO.</th>
                    <th>Username</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Contact NO.</th>
                    <th>Address</th>
                    <th>Password</th>
                    <th>User Type</th>
                    <th></th>
                </thead>
                <tbody>
                    @foreach($userdata as $val)
                    <tr>
                        <td>{{$count++}}</td>
                        <td>{{$val->user_name or '-'}}</td>
                        <td>{{$val->user_first_name or '-'}} {{$val->user_last_name or '-'}}</td>
                        <td>{{$val->user_email or '-'}}</td>
                        <td>{{$val->user_contact_no or '-'}}</td>
                        <td>{{$val->user_address or '-'}}</td>
                        <td>{{$val->user_password_raw or '-'}}</td>
                        <td>{{$val->user_type or '-'}}</td>
                        <td>
                            <form action="{{url('employees/sendmail')}}" method="post">
                                {{ csrf_field() }}
                                <input type="hidden" name="userid" value="{{$val->user_id}}">
                                <input type="submit" class="btn" value="Send password">
                            </form>
                        </td>
                        <td>
                                <div style="display: inline-block">
                                    <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteAdminModal_{{ $val->user_id }}">Delete</button>
                                </div>
                                <div style="display: inline-block">
                                    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#updateAdminModal_{{ $val->user_id }}">Update</button>
                                </div>
                        </td>
                    </tr>
                    
                    
            <!-- Update model  -->
                        <div id="updateAdminModal_{{ $val->user_id }}" class="modal fade" role="dialog">
                            <div class="modal-dialog modal-lg">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <form action="/employee/update/{{ $val->user_id }}" id="updateAdmin_{{ $val->user_id }}" method="POST">
                                        {{csrf_field()}}
                                        <input type="hidden" name="type" value="store">
                                        <input type="hidden" name="user_id" value="{{ $val->user_id }}">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Update admin : {{ $val->user_first_name }}</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="user_name">User name</label>
                                                    <input type="text" name="user_name" id="user_name" value="{{ $val->user_name }}" class="form-control" placeholder="First name" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="user_first_name">First name</label>
                                                    <input type="text" name="user_first_name" value="{{ $val->user_first_name }}" id="user_first_name" class="form-control" placeholder="First name" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="user_last_name">Last name</label>
                                                    <input type="text" name="user_last_name" value="{{ $val->user_last_name }}" id="user_last_name" class="form-control" placeholder="Last name">
                                                </div>

                                            </div>
                                            <div class="row" style="margin-top: 2%;">
                                                <div class="col-md-4">
                                                    <label for="user_email">Email</label>
                                                    <input type="email" name="user_email" value="{{ $val->user_email }}" id="user_email" class="form-control" placeholder="Email" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="user_contact_no">Contact</label>
                                                    <input type="number" name="user_contact_no" value="{{ $val->user_contact_no }}" id="user_contact_no" class="form-control" placeholder="Contact no">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="user_password">Password</label>
                                                    <input type="password" name="user_password" value="{{ $val->user_password_raw }}" id="user_password" class="form-control" placeholder="Password" required>
                                                </div>

                                            </div>
                                            <div class="row" style="margin-top: 2%;">
                                                <div class="col-md-4">
                                                    <label for="user_address">Address</label>
                                                    <input name="user_address" class="form-control" value="{{ $val->user_address }}" id="user_address" placeholder="Address">

                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>

                        <!-- Delete model  -->
                        <div id="deleteAdminModal_{{ $val->user_id }}" class="modal fade" role="dialog">
                            <div class="modal-dialog">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <form action="/employee/delete/{{ $val->user_id }}" method="post" id="deleteAdmin_{{ $val->user_id }}">
                                        {{ csrf_field() }}
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Delete admin : {{ $val->user_first_name }}</h4>
                                        </div>
                                        <div class="modal-body">
                                            <p class="lead">Are you sure?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                @endforeach
                </tbody>
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