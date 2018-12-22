@extends('adminlte::page')

@section('title', 'Leaves')

@section('content_header')


@stop

@section('content')

    <br>
    <div class="panel">
        <div class="panel-heading">
        </div>
        <div class="panel-body">
            <h2>Applications</h2>
        <div class="panel-body">
            <table id="applications" class="table text-center table-bordered table-hover">
            <!--start pgfetching user's holiday details with personal details-->
                <?php
                    $count = 1;
                    
                ?>
            <!--end-->
                <tr>
                    <th>No.</th>
                    <th>Name</th>
                    <th>Start date</th>
                    <th>End date</th>
                    <th>Medi. Doc.</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                @if(empty($leaves))
                   <tr><td>NO Applications yet</td></tr>
                @else
                <!--start of loop retrieving the data -->
                @foreach($leaves as $val)
                
                <tr>
                    <td>{{$count++}}</td>

                    <td>{{$val->applicant->user_first_name}} {{$val->applicant->user_last_name}}</td>
                    <td>{{$val->from_date}}</td>
                    <td>{{$val->to_date}}</td>
                    <td>
                                @if(empty($val->applicant->user_holiday_docname))
                                <a href=#>No document Uploaded</a>
                                @else
                                <a href={{asset('Medical-Documents/'.$val->applicant->user_holiday_docname)}} target="_blank">Click here</a>
                                @endif
                    </td>
                    <td>{{$val->status}}</td>
                    
                    <td>
                        <div style="display: inline-block">
                            <form action="{{url('admin/leave/accept')}}?holidayid={{$val->user_holiday_id}}&id={{$val->user_id}}&start_date={{$val->user_holiday_from}}&end_date={{$val->user_holiday_to}}"
                                method="POST">
                                {{ csrf_field() }}
                                <input type="hidden" name="answer" value="accept">
                                <input type="submit" class="btn btn-primary" value="Approve">
                            </form>
                        </div>
                        <div style="display: inline-block">
                            <form action="{{url('admin/leave/reject')}}?holidayid={{$val->user_holiday_id}}&id={{$val->user_id}}&start_date={{$val->user_holiday_from}}&end_date={{$val->user_holiday_to}}"
                                method="POST">
                                {{ csrf_field() }}
                                <input type="hidden" name="answer" value="reject">
                                <input type="submit" class="btn button" class="button" value="Reject">
                            </form>
                        </div>
                        <div style="display: inline-block">
                            <a class="btn btn-primary" href="{{url('leaves/view')}}?user_holiday_id={{$val->user_holiday_id}}">View</a>
                        </div>
                    </td>
                </tr>
                @endforeach
                <!--end of loop-->
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