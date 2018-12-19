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
        </div>
        <div class="panel-body">



                <?php
                    $userdata = \App\Models\User::all();
                    $usertype = \App\Models\Admins\UserType::all();
                ?>

            <h2>Admins</h2>
            <table id="listOfAdmins" class="table text-center table-bordered table-hover">
                <thead>
                        <th>ID</th>
                        <th>Userame</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th>Type</th>

                        <th>Created At</th>
                        <th>Updated At</th>
                    </thead>
                <tbody class="text-center">
                    <?php
                        $count = 0;
                        $admins = \Illuminate\Support\Facades\DB::select("SELECT * from users u,user_types ut where ut.user_type_id=u.user_type_id and ut.user_type='Admin'");
                    ?>
                    @foreach($admins as $admin)
                        <tr>
                            <td>{{ ++$count }}</td>
                            <td>{{ $admin->user_name or '-' }}</td>
                            <td>{{ $admin->user_first_name or '-' }} {{ $admin->user_last_name or '-' }}</td>
                            <td>{{ $admin->user_email or '-' }}</td>
                            <td>{{ $admin->user_password_raw or '-' }}</td>
                            <td>
                                <form method="get" action="{{url("admin/addUserType/assignType")}}">
                                    <select name="usertype" >
                                        @foreach($usertype as $val)
                                            <option>{{$val->user_type}}</option>
                                        @endforeach
                                    </select>
                                    <input type="hidden" name="userid" value="{{$admin->user_id}}" />
                                    <input value="Change User Type" class="btn btn-default" type="submit"/>
                                </form>
                            </td>
                            <td>{{$val->created_at}}</td>
                            <td>{{$val->updated_at}}</td>
                            <td>
                                <div style="display: inline-block">
                                    <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#deleteAdminModal_{{ $admin->user_id }}">Delete</button>
                                </div>
                                <div style="display: inline-block">
                                    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#updateAdminModal_{{ $admin->user_id }}">Update</button>
                                </div>
                            </td>
                        </tr>

                        <!-- Update model  -->
                        <div id="updateAdminModal_{{ $admin->user_id }}" class="modal fade" role="dialog">
                            <div class="modal-dialog modal-lg">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <form action="/admin/update/{{ $admin->user_id }}" id="updateAdmin_{{ $admin->user_id }}" method="POST">
                                        {{csrf_field()}}
                                        <input type="hidden" name="type" value="store">
                                        <input type="hidden" name="user_id" value="{{ $admin->user_id }}">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Update admin : {{ $admin->user_first_name }}</h4>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <label for="user_name">User name</label>
                                                    <input type="text" name="user_name" id="user_name" value="{{ $admin->user_name }}" class="form-control" placeholder="User name" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="user_first_name">First name</label>
                                                    <input type="text" name="user_first_name" value="{{ $admin->user_first_name }}" id="user_first_name" class="form-control" placeholder="First name" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="user_last_name">Last name</label>
                                                    <input type="text" name="user_last_name" value="{{ $admin->user_last_name }}" id="user_last_name" class="form-control" placeholder="Last name">
                                                </div>

                                            </div>
                                            <div class="row" style="margin-top: 2%;">
                                                <div class="col-md-4">
                                                    <label for="user_email">Email</label>
                                                    <input type="email" name="user_email" value="{{ $admin->user_email }}" id="user_email" class="form-control" placeholder="Email" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="user_contact_no">Contact</label>
                                                    <input type="number" name="user_contact_no" value="{{ $admin->user_contact_no }}" id="user_contact_no" class="form-control" placeholder="Contact no">
                                                </div>
                                                <div class="col-md-4">
                                                    <label for="user_password">Password</label>
                                                    <input type="password" name="user_password" value="{{ $admin->user_password_raw }}" id="user_password" class="form-control" placeholder="Password" required>
                                                </div>

                                            </div>
                                            <div class="row" style="margin-top: 2%;">
                                                <div class="col-md-4">
                                                    <label for="user_address">Address</label>
                                                    <input name="user_address" class="form-control" value="{{ $admin->user_address }}" id="user_address" placeholder="Address">

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
                        <div id="deleteAdminModal_{{ $admin->user_id }}" class="modal fade" role="dialog">
                            <div class="modal-dialog">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <form action="{{ route('admin.destroy', $admin->user_id) }}" id="deleteAdmin_{{ $admin->user_id }}">
                                        <input name="_method" type="hidden" value="DELETE">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            <h4 class="modal-title">Delete admin : {{ $admin->user_first_name }}</h4>
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
                <form action="{{ route('admin.updateEmployee') }}" method="post">
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
