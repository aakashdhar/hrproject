@extends('adminlte::page')

@section('title', 'Users')

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
            <h2>Registration Form</h2>
            <form method="post" action="{{url("admin/addUser/registerUser")}}">
                {{ csrf_field() }}
                <table  id="registrationForm">

                    <tr>
                        <td>Enter Username :</td>
                        <td><input name="username" id="username" type="text" required/>
                            <p class="username"></p>
                        </td>
                    </tr>
                    <tr>
                        <td>Enter First Name :</td>
                        <td><input name="userfirstname" id="userfirstname" type="text" required/>
                            <p class="userfirstname"></p>
                        </td>
                    </tr>
                    <tr>
                        <td>Enter Last Name :</td>
                        <td><input name="userlastname" id="userlastname" type="text" required/>
                            <p class="userlastname"></p>
                        </td>
                    </tr>
                    <tr>
                        <?php
                            $usertype = \App\Models\Admins\UserType::all()->where("user_type","!=","Admin");
                        ?>
                        <td>Choose Type :</td>
                        <td>
                            <select name="usertype" >
                                        @foreach($usertype as $val)
                                            <option>{{$val->user_type}}</option>
                                        @endforeach
                                    </select>
                            <p class="lastname"></p>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>Enter Contact Number :</td>
                        <td><input id="usercontactno" name="usercontactno" type="text" required/>
                            <p class="usercontactno"></p>
                        </td>
                    </tr>
                    <tr>
                        <td>Enter Residential Address :</td>
                        <td><textarea name="useraddress" cols="20" rows="3" id="useraddress"></textarea>
                            <p class="useraddress"></p>
                        </td>
                    </tr>
                    <tr>
                        <td>Enter Email :</td>
                        <td><input id="useremail" name="useremail" type="email" required/>
                            <p class="email"></p>
                        </td>
                    </tr>
                    <tr>
                        <td>Enter Password :</td>
                        <td><input name="userpassword" type="text" required/>
                            <p></p>
                        </td>
                    </tr>
                    
                    <tr>
                        <td colspan="2"><input type="submit" class="button" id="register" name="add" value="Add" /></td>
                    </tr>
                </table>
            </form>
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