
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
</script>
@endpush

@section('content-breadcrumb')
<ul class="page-breadcrumb">
   <li>Leave Management<i class="fa fa-angle-double-right"></i></li>
   <li><span>Statistics</span></li>

</ul>
@endsection

@section('content-header')
<div class="row">
   {{ Form::open(['id' => 'frm_sales_sel', 'name' => 'frm_sales_sel', 'class' => 'form-horizontal','url' => url()->current(), 'method' => 'GET']) }}
      {{ Form::hidden('date_start', '', ['id'=>'date-start']) }}
      {{ Form::hidden('date_end', '', ['id'=>'date-end']) }}
   <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
      <h3 class="page-title">Leave <small>Statistics</small></h3>
   </div>
   <div class="col-lg-4 col-md-4 col-sm-8 col-xs-12">
      @include('admin_diamond.leaves.incl_statistics')
   </div>
   <div class="col-lg-4 col-md-4 col-sm-8 col-xs-12">
    <div class="pull-right">
        @if($user->isSuperAdmin())
            <a class="btn blue-soft" href="{{ URL::to("admin/diamond/leaves/applications") }}">
                Pending Applications
                <span class="badge badge-success">{{ $total_pending_leaves }}</span>
            </a>
        @endif

        <a class="btn blue-soft" href="{{ URL::to("admin/diamond/leaves/apply") }}">
            Apply For Leave
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

<div class="clearfix"></div>
<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="tabbable">
            <ul class="nav nav-tabs bar_tabs">
                <li class="active">
                   <a href="#leave_tab_pending" data-toggle="tab"> Pending Leaves ({{ $pending_applications->count() }})</a>
                </li>
                <li class="">
                   <a href="#leave_tab_history" data-toggle="tab"> Leave Transactions ({{ $leave_history->count() }})</a>
                </li>

            </ul>
            <div class="tab-content">
                <div class="tab-pane active fade in table-responsive" id="leave_tab_pending">
                    <table class="table table-condensed table-condensed-stats">
                        <thead>
                            <tr>
                                <th class="nowrap" width="5%">#</th>
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

                            @if($pending_applications->count())
                                @foreach($pending_applications as $application)
                                    <tr>
                                        <td class="nowrap"><strong>{{ ++$i }}</strong></td>
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
                                          <a href="{{ URL::to("admin/diamond/leaves/$application->leave_id/cancel") }}" class="btn btn-danger btn-xs cancel-link" target="_blank"><span class="fa fa-remove" aria-hidden="true" title="Cancel Leave"></span></a>
                                          @else
                                          {{ $application->status }}
                                          @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="12" class="text-center">
                                        <h3>No Pending Applications</h3>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                    <div id="cancel_modal" class="modal fade modal-md" role="dialog">
                       <div class="modal-dialog">

                         <!-- Modal content-->
                         <div class="modal-content">
                           <div class="modal-header">
                             <button type="button" class="btn btn-link pull-right" style='color: lightgray;' data-dismiss="modal"><i class="fa fa-times"></i></button>
                             <h4 class="modal-title"> <strong id="modal_title">Cancel Leave</strong>
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
                                  {!! Form::text('from_date',null,['class'=>'form-control', "disabled" => true, "id" => 'from_date']) !!}
                                </div>
                               </div>

                               <div class="form-group">
                                 {!!
                                  Form::label('to_date', 'To Date', [

                                    'class'=>'control-label col-md-3 col-sm-3 col-xs-12 nowrap'
                                  ])
                                !!}
                                <div class="col-md-9 col-sm-9 col-xs-12 nowrap">
                                  {!! Form::text('to_date',null,['class'=>'form-control', "disabled" => true, "id" => 'to_date']) !!}
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

                               <div class="form-group">
                                 {!!
                                  Form::label('cancel_reason', 'Cancel Reason', [

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
                                    {!! Form::submit("Cancel Leave",['class'=> 'btn green', "id" => "submit_btn"]) !!}
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

                <div class="tab-pane fade in table-responsive" id="leave_tab_history">
                    <table class="table table-condensed table-condensed-stats">
                        <thead>
                            <tr>
                                <th class="nowrap" width="5%">#</th>
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

                            @if($leave_history->count())
                                @foreach($leave_history as $application)
                                    <tr>
                                        <td class="nowrap"><strong>{{ ++$i }}</strong></td>
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
                            @else
                                <tr>
                                    <td colspan="11" class="text-center">
                                        <h3>No Leave Transactions Found</h3>
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
</div>

@endsection