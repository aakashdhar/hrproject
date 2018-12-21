@extends('admin_diamond._layout.layout_sidebar')

@push('head_links')
    <link type="text/css" rel="stylesheet" href="{{ URL::asset('assets/global/plugins/select2/css/select2.min.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ URL::asset('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ URL::asset('assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css') }}">
    <link type="text/css" rel="stylesheet" href="{{ URL::asset('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}" />
    <link type="text/css" rel="stylesheet" href="{{ URL::asset('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css') }}" />
    <link type="text/css" rel="stylesheet" href="{{ URL::asset('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" />
    <link type="text/css" rel="stylesheet" href="{{ URL::asset('assets/apps/css/quote.css') }}" />
    <link rel="stylesheet" href="{{URL::asset('assets\layouts\global\css\responsive_inventory.css')}}">
    <style type="text/css">
        .or-label{margin-top: 18px;}
        .company-sel{margin-top: 4px;}
        .table-condensed-stats th, .table-condensed-stats td {
            font-size: 9.4pt;
        }
    </style>
    <style type="text/css">
        .tg  {border-collapse:collapse;border-spacing:0;}
        .tg td{font-family:Arial, sans-serif;font-size:14px;border-style:solid;border-width:1px;overflow:hidden;border-color:black;vertical-align: middle;width: 20% !important;padding: 10px 20px;}
        .tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;border-style:solid;border-width:1px;overflow:hidden;border-color:black;vertical-align: middle;}
        .tg .tg-88nc{font-weight:bold;border-color:inherit;text-align:center}
        .tg .tg-8m2u{font-weight:bold;border-color:inherit}
        .tg .tg-l711{border-color:inherit}
        .tg .tg-us36{border-color:inherit;vertical-align:top}
        .attendance th td tr {
            border: 1px solid #0A1214;
        }

    </style>
@endpush

@push('body_scripts')
    <script type="text/javascript" src="{{ URL::asset('assets/global/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/global/plugins/select2/js/select2.full.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/global/plugins/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}"></script>

    <script type="text/javascript" src="{{ URL::asset('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>

    <script type="text/javascript" src="{{ noc_asset('js/admin-diamond-leaves-list.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            // SalesList.initCustomDateRange( $("#from_date"), $("#to_date") );
        });
        $('.undo').click(function() {
          if (confirm('Are you sure?')) {
            var frm = $('#frm_undo');
            var user_id = $(this).data('user-id');
            var attendance_id = $(this).data('attendance-id');
            $('#undo_user_id').val(user_id);
            $('#undo_attendance_id').val(attendance_id);
            frm.submit();
          }
        });
    </script>
@endpush

@section('content-breadcrumb')
    <ul class="page-breadcrumb">
        <li>Attandance Management<i class="fa fa-angle-double-right"></i></li>
        <li><span>Mark Attendance</span></li>

    </ul>
@endsection

@section('content-header')
    <div class="row">
        {{ Form::open(['id' => 'frm_attendance_fill', 'name' => 'frm_attendance_fill', 'class' => 'form-horizontal','url' => url()->current(), 'method' => 'GET']) }}
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <h3 class="page-title">Attendance <small> Form</small></h3>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="form-group page_search margin-top-5">
                <div class="row search-margines">
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <div class="input-group input-group-sm margin-top-10">
                  <span class="input-group-addon">
                      <i class="fa fa-bank"></i>
                  </span>
                            {!! Form::select('month_id', $month,$month , ['class'=>'form-control selectpicker input-sm', 'data-size'=>"6", 'data-live-search'=>"true", 'data-live-search-style'=>"startsWith", 'id'=>'Customer_name','placeholder' => 'Pick a month...','required'=>'required']) !!}
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <div class="input-group input-group-sm margin-top-10">
                  <span class="input-group-addon">
                      <i class="fa fa-building"></i>
                  </span>
                            {!! Form::select('year',$year,'',['class'=>'form-control selectpicker input-sm', 'data-size'=>"6", 'data-live-search'=>"true", 'data-live-search-style'=>"startsWith", 'id'=>'year','placeholder' => 'Pick a Year...','required'=>'required']) !!}
                        </div>
                    </div>
                </div>
                <div class="row search-margines">
                    <div class="col-md-6 col-sm-6 col-xs-6">
                        <div class="input-group input-group-sm margin-top-10">
                  <span class="input-group-addon">
                      <i class="fa fa-usd"></i>
                  </span>
                            {!! Form::select('office', $office_arr,"", ['class'=>'form-control selectpicker input-sm', 'data-size'=>"6", 'data-live-search'=>"true", 'data-live-search-style'=>"startsWith", 'id'=>'currency_id','placeholder' => 'Pick a office...','required'=>'required']) !!}
                        </div>
                    </div>
                </div>
                <div class="row search-margines">
                    <div class="col-xs-12">
                        <button type="submit" class="btn btn-primary btn-block margin-top-10">Search</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            &nbsp;
        </div>
        {{ Form::close() }}
    </div>
@endsection

@section('content')

    <div class="table-responsive">
    @if(isset($workdays) && isset($user))
    {{ Form::open(['id' => 'frm_attendance_fill', 'name' => 'frm_attendance_fill', 'class' => 'form-horizontal','url' => url()->current(), 'method' => 'POST']) }}

    <div class="row search-margines">
        <div class="col-md-2 pull-right">
            {{Form::submit('submit',['class'=>'btn btn-primary btn-block margin-bottom-10'])}}
        </div>
    </div>
    <?php
    $count_user = count($user);
    ?>
    <table class="table table-bordered" border="0" style="font-size: 8pt" >
        <tr>
            <th  style="background-color:#337ab7;border-color:#2e6da4;color: #ffffff;text-align: center;vertical-align: middle;" rowspan="2">Date</th>
            <th style="background-color:#337ab7;border-color:#2e6da4;color: #ffffff;text-align: center;vertical-align: middle;" rowspan="2">Day</th>
            <th style="background-color:#337ab7;border-color:#2e6da4;color: #ffffff;text-align: center" colspan="{{$count_user}}">Name of Employees</th>
        </tr>
        <tr>
            @foreach($user as $key => $value)
                <th style="background-color:#337ab7;border-color:#2e6da4;color: #ffffff;font-weight: bold;text-align: center;padding-left:32px;padding-right:32px;">{{$value->user_first_name}}</th>
            @endforeach
        </tr>

        @foreach($workdays as $k => $v)
            <tr>

                <td  style="background-color:#337ab7;border-color:#2e6da4;color: #ffffff;font-weight: bold;text-align: center;vertical-align: middle;">{{$v['day_date']}}</td>
                <td  style="background-color:#337ab7;border-color:#2e6da4;color: #ffffff;font-weight: bold;text-align: center;vertical-align: middle;">{{$v['get_name']}}</td>
            @if($v['get_name'] == 'Sunday' || $v['get_name'] == 'Saturday' || $v['holiday'] != "")
                    <td colspan="{{$count_user}}" style="text-align: center;font-weight: bold;background-color: rgb(227, 230, 230)">{{($v['holiday'] != "")? $v['holiday'] : $v['get_name']}}</td>
                @else
                @foreach($user as $key => $value)

                        <?php
                        $date1 = str_replace('/','-',$v['day_date']);
                        $date = date('Y-m-d',strtotime($date1));
                    $user_data = \App\Models\UserAttendance::where('user_id','=',$value->user_id)->where('attendance_date','=',$date)->get();
                    $count = count($user_data);
                    $user_id = $value->user_id;
                            ?>
                        @if($count == 0)

                        <td>
                        {{ Form::radio($v['day_date']."-".$value->user_id, 'Present', false, ['class' => 'icheck','style'=>'margin-left:10px;']) }}Present<br/>
                        {{ Form::radio($v['day_date']."-".$value->user_id, '1/2 Day', false, ['class' => 'icheck','style'=>'margin-left:10px;margin-top:10px;']) }}1/2 Day<br/>
                        {{ Form::radio($v['day_date']."-".$value->user_id, 'Absent', false, ['class' => 'icheck','style'=>'margin-left:10px;margin-bottom:10px;']) }}Absent

                        </td>
                        @else
                            @foreach($user_data as $key => $value)
                                    @php
                                      $undo_key = $v['day_date']."-".$user_id;
                                    @endphp

                                    @if($value->attendance_status == '1/2 Day')
                                        <td  style="vertical-align: middle;font-weight: bold;color: #FF8C00;text-align: center">{{$value->attendance_status}} <br> <a href="javascript:;" data-attendance-id="{{$undo_key}}" data-user-id="{{$user_id}}" class="undo">Undo</a> </td>
                                    @elseif($value->attendance_status == 'Present')
                                        <td style="vertical-align: middle;font-weight: bold;color: #00CC33;text-align: center">{{$value->attendance_status}} <br> <a href="javascript:;" data-attendance-id="{{$undo_key}}" data-user-id="{{$user_id}}" class="undo">Undo</a> </td>
                                    @elseif($value->attendance_status == 'Absent')
                                        <td style="vertical-align: middle;font-weight: bold;color: #ff0000;text-align: center">{{$value->attendance_status}} <br> <a href="javascript:;" data-attendance-id="{{$undo_key}}" data-user-id="{{$user_id}}" class="undo">Undo</a> </td>
                                    @endif
                                @endforeach
                            @endif

                @endforeach

            @endif
            </tr>
        @endforeach

        <tr>
            <td style="vertical-align: middle;text-align: center;font-weight: bold;">Presents:
            </td>
            <td>
                &nbsp;
            </td>

            @foreach($user as $key => $value)
                <?php
                    $count_present = \App\Models\UserAttendance::where('user_id',$value->user_id)->where('attendance_status','Present')->whereMonth('attendance_date','=',$month_code)->count();
                ?>
                <td style="font-weight: bold;text-align: center;">{{$count_present}}</td>
            @endforeach
        </tr>
        <tr>
            <td style="vertical-align: middle;text-align: center;font-weight: bold;">
                Absent :
            </td>
            <td>
                &nbsp;
            </td>
            @foreach($user as $key => $value)
                <?php
                $count_absent = \App\Models\UserAttendance::where('user_id',$value->user_id)->where('attendance_status','Absent')->whereMonth('attendance_date','=',$month_code)->count();
                ?>
                <td style="font-weight: bold;text-align: center;">{{$count_absent}}</td>
            @endforeach
        </tr>
        <tr>
            <td style="vertical-align: middle;text-align: center;font-weight: bold;">
                Half Day :
            </td>
            <td>
                &nbsp;
            </td>
            @foreach($user as $key => $value)
                <?php
                $count_half_day = \App\Models\UserAttendance::where('user_id',$value->user_id)->where('attendance_status','1/2 Day')->whereMonth('attendance_date','=',$month_code)->count();
                ?>
                <td style="font-weight: bold;text-align: center;">{{$count_half_day}}</td>
            @endforeach
        </tr>
    </table>

        {{ Form::close() }}
        {!! Form::open(['route' => 'attendance|undoAttendance', 'method'=>'POST', 'id'=>'frm_undo']) !!}
          {{ Form::hidden('undo_user_id', '', ['id'=>'undo_user_id']) }}
          {{ Form::hidden('undo_attendance_id', '', ['id'=>'undo_attendance_id']) }}
          {{ Form::hidden('undo_attendance_status', 'undo_attendance') }}
        {!! Form::close() !!}

@endif
    </div>
@endsection
