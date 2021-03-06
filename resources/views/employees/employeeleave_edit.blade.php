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
            <h2>Leave Application Form : Edit</h2>
            
            <form enctype="multipart/form-data"  class="form" method="post" action="{{url("employees/leave/edit-leave")}}">
                {{ csrf_field() }}
                <table>
                    <input type="hidden" value="{{$leavedata->user_holiday_id}}" name="user_holiday_id">
                    <tr>
                        <td>
                            Start Date :
                        </td>
                        <td>
                            <input id="startdate" type="date" name="start_date" value="{{$leavedata->user_holiday_from}}"/>
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
                            <input type="date" id="enddate"  name="end_date" value="{{$leavedata->user_holiday_to}}" required/>
                            <p class="enddate"></p>
                        </td>
                    </tr>
                    
<!--                    <tr>
                        <td>
                            Upload Medical Certificate :
                        </td>
                        <td>
                            <input type="file" name="file" id="doc" />
                            <p class="doc"></p>
                        </td>
                    </tr>-->
                    <tr>
                        <td>
                            Subject :
                        </td>
                        <td>
                            <input title="Only alphabates and ." id="subject" type="text" name="subject" required value="{{$leavedata->user_holiday_subject}}"/>
                            <p class="subject"></p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Reason :
                        </td>
                        <td>
                            <textarea id="reason" title="Only alphabates and .,@%&" type="text" name="reason" cols="40" rows="5" placeholder="Type application here..." required>{{$leavedata->user_holiday_reason}}</textarea>
                            <p class="reason"></p>
                        </td>
                    </tr>
                    <tr>

                        <td colspan="2" align="center">
                            <input class="button" type="submit" value="Edit" />
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
@stop