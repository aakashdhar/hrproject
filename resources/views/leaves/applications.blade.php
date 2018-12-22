@extends('adminlte::page')

@section('title', 'Leaves')
@push('head_links')
<link type="text/css" rel="stylesheet" href="{{ URL::asset('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css') }}" />
<link type="text/css" rel="stylesheet" href="{{ URL::asset('assets/global/plugins/jquery-ui/jquery-ui.min.css') }}" />
<style type="text/css">
    .or-label{margin-top: 18px;}
    .company-sel{margin-top: 4px;}
    .table-condensed-stats th, .table-condensed-stats td {
        font-size: 9.4pt;
    }

</style>
@endpush

@push('body_scripts')
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/bootstrap-tabdrop/js/bootstrap-tabdrop.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/select2/js/select2.full.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/jquery-ui/jquery-ui.min.js') }}"></script>

<script type="text/javascript">
$(document).ready(function () {

   // SalesList.initCustomDateRange( $("#from_date"), $("#to_date") );

});

var delete_url = "{{ URL::to('admin/diamond/leaves/delete-bulk') }}";
var approve_url = "{{ URL::to('admin/diamond/leaves/approve-bulk') }}";
</script>
<script type="text/javascript" src="{{ URL::asset('js/admin-diamond-leaves-application.js') }}"></script>
<script type="text/javascript">
    var fnToggle = function(id,bt) {
        $("."+bt).toggleClass('fa-chevron-right').toggleClass('fa-chevron-down');
        $("."+id).toggle();
    };
</script>

@endpush

@section('content-breadcrumb')
<ul class="page-breadcrumb">
   <li>Leave Management<i class="fa fa-angle-double-right"></i></li>
   <li><span>Listing</span></li>
</ul>
@endsection

@section('content-header')
<div class="row">
   {{ Form::open(['id' => 'frm_sales_sel', 'name' => 'frm_sales_sel', 'class' => 'form-horizontal','url' => url()->current(), 'method' => 'GET']) }}
   <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
      <h3 class="page-title">Leave Applications <small>Listing</small></h3>
   </div>
   <div class="col-lg-4 col-md-4 col-sm-8 col-xs-12">
      @include('leaves.incl_search')
   </div>
   <div class="col-lg-4 col-md-4 col-sm-8 col-xs-12 margin-top-10">
    <div class="pull-right">
        <a class="btn blue-soft" href="{{ URL::to("leaves/list") }}">
            My Leaves
        </a>
    </div>
   </div>
   <div class="clearfix"></div>
   {{ Form::close() }}
</div>
@endsection

@section('content-bar')
{{--  --}}
@endsection

@section('content')
<ul class="page-breadcrumb">
    <li>Leave Management<i class="fa fa-angle-double-right"></i></li>
    <li><span>Listing</span></li>
 </ul>
 <div class="row">
    {{ Form::open(['id' => 'frm_sales_sel', 'name' => 'frm_sales_sel', 'class' => 'form-horizontal','url' => url()->current(), 'method' => 'GET']) }}
    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
       <h3 class="page-title">Leave Applications <small>Listing</small></h3>
    </div>
    <div class="col-lg-4 col-md-4 col-sm-8 col-xs-12">
       @include('leaves.incl_search')
    </div>
    <div class="col-lg-4 col-md-4 col-sm-8 col-xs-12 margin-top-10">
     <div class="pull-right">
         <a class="btn blue-soft" href="{{ URL::to("leaves/list") }}">
             My Leaves
         </a>
     </div>
    </div>
    <div class="clearfix"></div>
    {{ Form::close() }}
 </div>

<?php
$icons = array('Active' => 'success', 'Inactive' => 'default');
?>
<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="tabbable">
            <ul class="nav nav-tabs bar_tabs">
                <li class="active">
                   <a href="#leave_tab_pending" data-toggle="tab"> Leave Applications ({{ $leave_applications->count() }})</a>
                </li>
                <li class="">
                   <a href="#leave_tab_history" data-toggle="tab"> Leave History ({{ $leave_history->count() }})</a>
                </li>
                <li class="">
                    <a href="#attendance_tab_history" data-toggle="tab"> Attendance History </a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active fade in" id="leave_tab_pending">

                    <div class="pull-right">
                        <button class="btn btn-danger" id="delete_leaves">
                            <i class="fa fa-trash"></i> Delete
                        </button>
                    </div>
                    <div class="pull-right">
                        <button class="btn btn-primary" id="approve_leaves">
                            <i class="fa fa-check"></i> Approve
                        </button>
                    </div>

                    <div class="clearfix"></div>

                    <div class="table-responsive scrollable" id="order_table">
                          @if($leave_applications->count())
                           <table class="table table-condensed table-condensed-stats" border="0">
                              <thead>
                                 <tr>
                                    <th class="nowrap"><input type="checkbox" name="select_all" id="select_all" value="1"></th>
                                    <th class="nowrap" width="5%">#</th>
                                    <th class="nowrap">Applicant</th>
                                    {{--<th class="nowrap">Approver</th>--}}
                                    <th class="nowrap">From Date</th>
                                    <th class="nowrap">To date</th>
                                    <th class="nowrap">Total Days</th>
                                    <th class="nowrap">Applied On</th>
                                    <th class="nowrap">status</th>
                                    <th class="nowrap">Reason</th>
                                    <th class="nowrap">Approval Comment</th>
                                    <th class="nowrap">Reject Reason</th>
                                    <th class="nowrap">Action</th>
                                 </tr>
                              </thead>
                              <tbody>

                                @php
                                $i = 0;
                                @endphp
                                @foreach($leave_applications as $application)
                                  <tr>
                                    <td class="nowrap"><input type="checkbox" class="leave-chk" name="leave_ids[]" id="leave_ids_{{ $application->leave_id }}" value="{{ $application->leave_id }}"></td>
                                    <td class="nowrap"><strong>{{ ++$i }}</strong></td>
                                    <td class="nowrap applicant-name">{{ $application->applicant->user_first_name }}</td>
                                    {{--<td class="nowrap">{{ $application->approver->user_first_name }}</td>--}}
                                    <td class="nowrap from-date">{{ $application->from_date }}</td>
                                    <td class="nowrap to-date">{{ $application->to_date }}</td>
                                    <td class="nowrap total-days">{{ $application->total_days }}</td>
                                    <td class="nowrap">{{ $application->created_at }}</td>
                                    <td class="nowrap">{{ $application->status }}</td>
                                    <td class="nowrap">{{ $application->reason }}</td>
                                    <td class="nowrap">{{ $application->approval_comment }}</td>
                                    <td class="nowrap">{{ $application->cancel_reason }}</td>
                                    <td class="nowrap">
                                      @if($application->status == "Pending")
                                      <a href="{{ URL::to("admin/diamond/leaves/$application->leave_id/approve") }}" class="btn btn-info btn-xs approve-link" target="_blank"><span class="fa fa-check" aria-hidden="true" title="Approve Leave"></span></a>

                                      <a href="{{ URL::to("admin/diamond/leaves/$application->leave_id/reject") }}" class="btn btn-danger btn-xs reject-link" target="_blank"><span class="fa fa-remove" aria-hidden="true" title="Reject Leave"></span></a>
                                      @else
                                      {{ $application->status }}
                                      @endif
                                    </td>
                                  </tr>
                                @endforeach
                              </tbody>
                           </table>
                          @else
                            <h2 class="text-center">No Result found</h2>
                            <h3 class="text-center">Please try different filters</h3>
                          @endif

                          <div id="delete_confirm" class="modal fade in" id="basic" tabindex="-1" role="basic" aria-hidden="true" style="padding-right: 15px;">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                            <h3 class="modal-title">Please Confirm !!!</h3>
                                        </div>
                                        <div class="modal-body"> Are you sure you want to Delete Records ? </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn green" id="confirm_delete">Confirm</button>
                                            <button type="button" class="btn dark btn-outline" data-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>

                              <div id="approve_confirm" class="modal fade in" id="basic" tabindex="-1" role="basic" aria-hidden="true" style="padding-right: 15px;">
                                  <div class="modal-dialog">
                                      <div class="modal-content">
                                          <div class="modal-header">
                                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                              <h3 class="modal-title">Please Confirm !!!</h3>
                                          </div>
                                          <div class="modal-body"> Are you sure you want to Approve Records ? </div>
                                          <div class="modal-footer">
                                              <button type="button" class="btn green" id="approve_confirm">Confirm</button>
                                              <button type="button" class="btn dark btn-outline" data-dismiss="modal">Cancel</button>
                                          </div>
                                      </div>
                                      <!-- /.modal-content -->
                                  </div>
                                  <!-- /.modal-dialog -->
                              </div>
                              {{--Attendance History Modal--}}

                              <div id="attendance_history" class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true" style="padding-right: 15px;">
                                  <div class="modal-dialog">
                                      <div class="modal-content">
                                          <div class="modal-header">
                                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                              <h3 class="modal-title">Attendance Summery</h3>
                                          </div>
                                          <div class="modal-body">
                                              <table class="table table-bordered table-striped table-hover">
                                                  <thead id ="modal_head">
                                                  </thead>
                                                  <tbody id="modal_tbody">

                                                  </tbody>
                                              </table>
                                          </div>
                                      </div>
                                      <!-- /.modal-content -->
                                  </div>
                                  <!-- /.modal-dialog -->
                              </div>


                          <div id="approve_modal" class="modal fade modal-md" role="dialog">
                           <div class="modal-dialog">

                             <!-- Modal content-->
                             <div class="modal-content">
                               <div class="modal-header">
                                 <button type="button" class="btn btn-link pull-right" style='color: lightgray;' data-dismiss="modal"><i class="fa fa-times"></i></button>
                                 <h4 class="modal-title"> <strong id="modal_title">Approve Leave</strong> for <small id="applicant">#applicant#</small>
                                 </h4>
                               </div>
                               <div class="modal-body">

                                 <div class="row">
                                   <div class="col-md-12">

                                   {!! Form::open(['url'=>"", 'method' => 'POST', 'files' => true, 'class'=>'form-horizontal', 'id'=>'approve_form']) !!}
                                   <div class="form-group">
                                     {!!
                                      Form::label('from_date', 'From Date', [

                                        'class'=>'control-label col-md-3 col-sm-3 col-xs-12 nowrap'
                                      ])
                                    !!}
                                    <div class="col-md-9 col-sm-9 col-xs-12 nowrap">
                                      {!! Form::text('from_date',null,['class'=>'form-control', "disabled" => true, "id" => 'modal_from_date']) !!}
                                    </div>
                                   </div>

                                   <div class="form-group">
                                     {!!
                                      Form::label('to_date', 'To Date', [

                                        'class'=>'control-label col-md-3 col-sm-3 col-xs-12 nowrap'
                                      ])
                                    !!}
                                    <div class="col-md-9 col-sm-9 col-xs-12 nowrap">
                                      {!! Form::text('to_date',null,['class'=>'form-control', "disabled" => true, "id" => 'modal_to_date']) !!}
                                    </div>
                                   </div>

                                   <div class="form-group">
                                     {!!
                                      Form::label('total_days', 'Total Days', [

                                        'class'=>'control-label col-md-3 col-sm-3 col-xs-12 nowrap'
                                      ])
                                    !!}
                                    <div class="col-md-9 col-sm-9 col-xs-12 nowrap">
                                      {!! Form::text('total_days',null,['class'=>'form-control', "disabled" => true, "id" => 'total_days']) !!}
                                    </div>
                                   </div>

                                   <div class="form-group" id="approve_reason_block" style="display: none">
                                     {!!
                                      Form::label('approval_comment', 'Approval Comment', [

                                        'class'=>'control-label col-md-3 col-sm-3 col-xs-12 nowrap'
                                      ])
                                    !!}
                                    <div class="col-md-9 col-sm-9 col-xs-12 nowrap">
                                      {!! Form::textarea('approval_comment',null,['class'=>'form-control','rows' => 2, 'cols' => 40, "placeholder" => "Approval Comment."]) !!}
                                    </div>
                                   </div>
                                   <div class="form-group" id="reject_reason_block" style="display: none">
                                     {!!
                                      Form::label('cancel_reason', 'Reject Reason', [

                                        'class'=>'control-label col-md-3 col-sm-3 col-xs-12 nowrap'
                                      ])
                                    !!}
                                    <div class="col-md-9 col-sm-9 col-xs-12 nowrap">
                                      {!! Form::textarea('cancel_reason',null,['class'=>'form-control','rows' => 2, 'cols' => 40, "placeholder" => "Cancel Reason."]) !!}
                                    </div>
                                   </div>

                                   <div class="clearfix"></div>

                                   <div class="form-actions">
                                    <div class="row margin-top-10">
                                      <div class="col-md-12 text-center">
                                        {!! Form::submit("Approve Leave",['class'=> 'btn green', "id" => "submit_btn"]) !!}
                                      </div>
                                    </div>
                                   </div>


                                   {!! Form::close() !!}
                                   </div>

                                 </div>
                                </div>

                            </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade in table-responsive scrollable" id="leave_tab_history">
                    @if($leave_history->count())
                    <table class="table table-condensed table-condensed-stats" border="0" style="font-size: 8pt">
                        <thead>
                            <tr>
                                <th class="nowrap" width="5%">#</th>
                                <th class="nowrap">Applicant</th>
                                <th class="nowrap">Approver</th>
                                <th class="nowrap">From Date</th>
                                <th class="nowrap">To date</th>
                                <th class="nowrap">Total Days</th>
                                <th class="nowrap">Applied On</th>
                                <th class="nowrap">status</th>
                                <th class="nowrap">Reason</th>
                                <th class="nowrap">Approval Comment</th>
                                <th class="nowrap">Reject Reason</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php
                            $i = 0;
                            @endphp

                            @foreach($leave_history as $application)
                              <tr>
                                <td class="nowrap"><strong>{{ ++$i }}</strong></td>
                                <td class="nowrap applicant-name">{{ $application->applicant->user_first_name }}</td>
                                <td class="nowrap">{{ $application->approver->user_first_name }}</td>
                                <td class="nowrap from-date">{{ $application->from_date }}</td>
                                <td class="nowrap to-date">{{ $application->to_date }}</td>
                                <td class="nowrap total-days">{{ $application->total_days }}</td>
                                <td class="nowrap">{{ $application->created_at }}</td>
                                <td class="nowrap">{{ $application->status }}</td>
                                <td class="nowrap">{{ $application->reason }}</td>
                                <td class="nowrap">{{ $application->approval_comment }}</td>
                                <td class="nowrap">{{ $application->cancel_reason }}</td>
                              </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                        <h2 class="text-center">No Result found</h2>
                    @endif
                </div>

                <div class="tab-pane fade in table-responsive scrollable" id="attendance_tab_history">
                    <table class="table table-condensed table-condensed-stats" border="0" style="font-size: 8pt">
                        <thead>
                        <tr>

                            <th class="nowrap" width="5%">#</th>
                            <th class="nowrap">No</th>
                            <th class="nowrap">User</th>
                            <th class="nowrap">Year</th>

                        </tr>
                        </thead>

                        <tbody>
                        @php
                            $i = 0;
                        @endphp

                        @if($attendace_detail)
                            @foreach($attendace_detail as $attendances)
                                @foreach($attendances as $attendance)
                                    <?php
                                    $user_name = \App\Models\User::select('user_first_name')->where('user_id',$attendance['user_id'])->first();
                                    ?>
                                    <tr>
                                        <td class="nowrap">
                                            <div class="btn-group btn-group-solid btn-group-xs">
                                                <a class="btn btn-circle blue-soft" href="javascript:fnToggle('ld-{{ $attendance['user_id']."-".$attendance['year'] }}','bt-{{$user_name->user_first_name}}');">
                                                    <i class="fa fa-chevron-right bt-{{$user_name->user_first_name}}" ></i>
                                                </a>
                                            </div>
                                        </td>
                                        <td class="nowrap"><strong>{{ ++$i }}</strong></td>
                                        <td class="nowrap">{{$user_name->user_first_name}}</td>
                                        <td class="nowrap applicant-name">{{ $attendance['year'] }}</td>
                                        {{--<td class="nowrap"><a href="javascript:LoginLogs.getAttendanceDetail('{{$attendance['user_id']}}','{{$attendance['year']}}')">View History</a></td>--}}
                                    <?php
                                            $att_det = \App\Http\Controllers\Diamond\Leaves\LeavesController::getAttendance($attendance['user_id'],$attendance['year']);

                                    ?>
                                    <tr>
<?php
                                        $month = array(1 => 'January', 2 => 'February', 3 => 'March', 4 => 'April', 5 => 'May', 6 => 'June', 7 => 'July', 8 => 'August', 9 => 'September', 10 => 'October', 11 => 'November', 12 => 'December');

?>
                                    </tr>
                                    <tr  class='ld-{{ $attendance['user_id']."-".$attendance['year'] }}' style="display: none;">
                                        <td><strong>Month</strong></td>
                                    @foreach($att_det as $key => $value)
                                            <td><strong> {{ucfirst($key)}} </strong></td>
                                        @endforeach
                                    </tr>
                                    @foreach($month as $m)
                                        <tr  class='ld-{{ $attendance['user_id']."-".$attendance['year'] }}' style="display: none;">
                                            <td>{{$m}}</td>

                                    @foreach($att_det as $key => $value)
                                        @foreach($value as $k => $v)
                                            @if($month[$v['month']] == $m)
                                               <td>{{$v['count']}}</td>
                                                @endif

                                                @endforeach
                                        @endforeach
                                    @endforeach
                                        </tr>

                                @endforeach
                            @endforeach
                        @else
                            <tr>
                                <td colspan="11" class="text-center">
                                    <h3>No Attendance Hisotry</h3>
                                </td>
                            </tr>
                        @endif

                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
