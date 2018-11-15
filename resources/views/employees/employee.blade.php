@extends('adminlte::page')

@section('title', 'Admins')

@section('content_header')
    <div class="row">
        <div class="col-md-3"></div>
        
    </div>

@stop

@section('content')
    
    <br>
    <div class="panel">
        <div class="panel-heading">
            <a href="{{url("admin/admin")}}">Dashboard</a> >> <a href="{{url("admin/addUser")}}">User Registration</a> 
        </div>
        <?php 
        $count = 1;
        $userdata = \Illuminate\Support\Facades\DB::select("SELECT * from users u,user_types ut where ut.user_type_id=u.user_type_id and ut.user_type!='Admin'") 
        ?>
        <div class="panel-body">
            <h2>Employess</h2>
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
                                <input type="submit" value="send password">
                            </form>
                        </td>
                        
                    </tr>
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