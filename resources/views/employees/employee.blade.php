@extends('adminlte::page')

@section('title', 'Employees')

@section('content_header')
  <div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-9">
        <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#newEmployeeModal">Add new Employee</button>
    </div>
  </div>
@stop
@section('content')

    <br>
    <div class="panel">
        <?php $count = 1; ?>
        <div class="panel-body">
            <h2>Employees</h2>
            <table class="table text-center table-bordered table-hover">
                <thead>
                    <th>NO.</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Contact NO.</th>
                    <th>Address</th>
                    <th>User Type</th>
                    <th>Actions</th>
                </thead>
                <tbody>
                    @foreach($userdata as $val)
                    <tr>
                        <td>{{$count++}}</td>
                        <td>{{ucfirst($val->user_first_name)}} {{ucfirst($val->user_last_name)}}</td>
                        <td>{{$val->user_email or '-'}}</td>
                        <td>{{$val->user_contact_no or '-'}}</td>
                        <td>{{$val->user_address or '-'}}</td>
                        <td>{{$val->type->user_type or '-'}}</td>
                        <td>
                          <div class="dropdown">
                            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                              Action
                              <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                              <li><button class="btn btn-link" data-toggle="modal" data-target="#deleteAdminModal_{{ $val->user_id }}">Delete</button></li>
                              <li><button class="btn btn-link" data-toggle="modal" data-target="#updateAdminModal_{{ $val->user_id }}">Update</button></li>
                              <li><button class="btn btn-link" data-toggle="modal" data-target="#viewAdminModal_{{ $val->user_id }}">View Details</button></li>
                              <li role="separator" class="divider"></li>
                              <li>
                                <form action="{{url('employees/sendmail')}}" method="post">
                                  {{ csrf_field() }}
                                  <input type="hidden" name="userid" value="{{$val->user_id}}">
                                  <input type="submit" class="btn btn-link" value="Send password">
                                </form>
                              </li>
                            </ul>
                          </div>
                        </td>
                    </tr>
                     @include('employees.employee_modal')
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div id="newEmployeeModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                <form method="post" action="{{url("employees/store")}}" autocomplete="off">
                    {{ csrf_field() }}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Add new Employee</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="user_name">User name</label>
                                <input type="text" name="user_name" id="user_name" class="form-control" placeholder="User name" required>
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
                                <input type="text" name="user_contact_no" id="user_contact_no" class="form-control" placeholder="Contact no">
                            </div>
                            <div class="col-md-4">
                                <label for="user_password">Password</label>
                                <input type="password" name="user_password" id="user_password" class="form-control" placeholder="Password" required>
                            </div>

                        </div>
                        <div class="row" style="margin-top: 2%;">
                            <div class="col-md-4">
                                <label for="user_address">Address</label>
                                <input name="user_address" class="form-control"  id="user_address" placeholder="Address">
                            </div>
                            <div class="col-md-4">
                              <label for="user_address">Date of joining</label>
                              <input type="date" name="joining_date" class="form-control" id="joining_date" placeholder="Date of Joining">
                            </div>
                            <div class="col-md-4">
                              <label for="user_address">Date of birth</label>
                              <input type="date" name="user_dob" class="form-control"  id="user_dob" placeholder="Date of birth">
                            </div>
                        </div>
                        <div class="row" style="margin-top: 2%;">
                            <div class="col-md-4">
                                <label for="user_leave">Number of Leaves</label>
                                <input name="user_leave" class="form-control" value="{{ $val->user_leave }}" id="user_leave" placeholder="Number of Leaves">
                          </div>
                          <div class="col-md-4">
                            <label for="user_address">Emergency Contact</label>
                            <input name="user_emergency_name" class="form-control"  id="user_emergency_name" placeholder="Emergency Contact">
                          </div>
                          <div class="col-md-4">
                            <label for="user_address">Emergency Contact number</label>
                            <input name="user_emergency_contact" class="form-control"  id="user_emergency_contact" placeholder="Emergency Contact Number">
                          </div>
                        </div>
                       <div class="row" style="margin-top: 2%;">
                         <div class="col-md-12">
                           <label for="user_address">Hobbies</label>
                           <input name="user_hobbies" class="form-control"  id="user_hobbies" placeholder="Hobbies">
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
