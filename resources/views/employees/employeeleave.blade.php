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
            <h2>Leave Application Form</h2>
            
            <form enctype="multipart/form-data"  class="form" method="post" action="{{url("employees/leave/apply")}}">
                {{ csrf_field() }}
                <table>
                    
                    <tr>
                        <td>
                            Start Date :
                        </td>
                        <td>
                            <input id="startdate" type="date" name="start_date" required/>
                            @if ($errors->has('email'))

                            @endif
                            <p class="startdate"></p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            End Date :
                        </td>
                        <td>
                            <input type="date" id="enddate"  name="end_date" required/>
                            <p class="enddate"></p>
                        </td>
                    </tr>
                    
                    <tr>
                        <td>
                            Upload Medical Certificate :
                        </td>
                        <td>
                            <input type="file" name="file" id="doc"/>
                            <p class="doc"></p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Subject :
                        </td>
                        <td>
                            <input title="Only alphabates and ." id="subject" type="text" name="subject" required/>
                            <p class="subject"></p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Reason :
                        </td>
                        <td>
                            <textarea id="reason"  title="Only alphabates and .,@%&" type="text" name="reason" cols="40" rows="5" placeholder="Type application here..." required></textarea>
                            <p class="reason"></p>
                        </td>
                    </tr>
                    <tr>

                        <td colspan="2" align="center">
                            <input class="button" type="submit" value="Apply" />
                        </td>
                    </tr>
                </table>
            </form>
            <hr />
            <div>
                <?php
                    $user = Auth::user();
                    $data = DB::select('select * from user_holiday where user_id ='.$user->user_id);
                    //dd($data);
                    ?>
                <table class="table table-bordered table-active">
                    <thead>
                        <th>Holiday ID</th>
                        <th>Subject</th>
                        <th>Reason</th>
                        <th>From Date</th>
                        <th>To Date</th>
                        <th>Status</th>
                    </thead>
                    <tbody>
                        @foreach($data as $val)
                        <tr>
                            <td>{{$val->user_holiday_id}}</td>
                            <td>{{$val->user_holiday_subject}}</td>
                            <td>{{$val->user_holiday_reason}}</td>
                            <td>{{$val->user_holiday_from}}</td>
                            <td>{{$val->user_holiday_to}}</td>
                            <td>{{$val->user_holiday_approval_status}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
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