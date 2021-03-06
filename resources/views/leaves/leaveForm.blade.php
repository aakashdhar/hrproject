@extends('adminlte::page')

@section('title', 'Leaves')
@push('style')
<link type="text/css" rel="stylesheet" href="{{ URL::asset('assets/global/plugins/jquery-ui/jquery-ui.min.css') }}" />
<link type="text/css" rel="stylesheet" href="{{ URL::asset('assets/global/plugins/select2/css/select2.min.css') }}">
<link type="text/css" rel="stylesheet" href="{{ URL::asset('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}">
<link type="text/css" rel="stylesheet" href="{{ URL::asset('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
@endpush
@push('body_script')
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/select2/js/select2.full.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/jquery-validation/js/jquery.validate.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/jquery-validation/js/additional-methods.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js') }}"></script>
<script type="text/javascript">
	var holidays = {!! $holidays->toJson() !!};
    var leave_balance = {{ $leave_balance or '0' }};
</script>

<script type="text/javascript" src="{{ URL::asset('js/admin-diamond-leave-apply.js') }}"></script>
@endpush

@section('content-header')
<div class="row">
	<div class="col-md-4 col-sm-12 col-xs-12">
		<h3 class="page-title">Leave Application <small>Apply</small></h3>
	</div>
	<div class="col-md-8 col-sm-6 col-xs-12">
	</div>
</div>
@endsection

@section('content-breadcrumb')
<ul class="page-breadcrumb">
	<li>Leaves <i class="fa fa-angle-double-right"></i></li>
	<li><a href="/leaves/list">Leave Application</a> <i class="fa fa-angle-double-right"></i></li>
	<li><span>Apply</span></li>
</ul>
@endsection

@section('content')
	{!! Form::open(['url' => 'leaves/store','method' => 'POST','files' => true,'class'=>'form-horizontal','id'=>'leave_form']) !!}
		<div class="col-md-6 col-sm-6 col-xs-12">
			<div class="form-group">
				{{Form::label('leave_balance', 'Leave Balance', ['class'=>'control-label col-md-5 col-sm-5 col-xs-12 nowrap'])}}
				<div class="col-md-7 col-sm-7 col-xs-12">
					<p class="form-control-static"><strong>{{ $leave_balance }}</strong></p>
				</div>
			</div>

			<div class="form-group">
				{{Form::label('after_apply', 'Balance After This Application', ['class'=>'control-label col-md-5 col-sm-5 col-xs-12 nowrap'])}}
				<div class="col-md-7 col-sm-7 col-xs-12">
					<p class="form-control-static"><strong id="remaining_leaves">{{ $leave_balance }}</strong></p>
				</div>
			</div>

			<div class="form-group">
				{{Form::label('from_date', 'From Date *', ['class'=>'control-label col-md-5 col-sm-5 col-xs-12 nowrap'])}}
				<div class="col-md-7 col-sm-7 col-xs-12">
					<div class="input-group input-group-sm margin-top-10">
						<span class="input-group-addon">
							<i class="fa fa-calendar"></i>
						</span>
						{!!Form::text('from_date', null, ['class'=>'form-control input-sm',"id" => "from_date"])!!}
					</div>
				</div>
			</div>

			<div class="form-group">
				{!!Form::label('to_date', 'To Date *', ['class'=>'control-label col-md-5 col-sm-5 col-xs-12 nowrap'])!!}
				<div class="col-md-7 col-sm-7 col-xs-12">
					<div class="input-group input-group-sm margin-top-10">
						<span class="input-group-addon">
							<i class="fa fa-calendar"></i>
						</span>
						{{Form::text('to_date', null, ['class'=>'form-control input-sm',"id" => "to_date"])}}
					</div>
				</div>
			</div>

			<div class="form-group">
				{{Form::label('total_days', 'Total Days', ['class'=>'control-label col-md-5 col-sm-5 col-xs-12 nowrap'])}}
				<div class="col-md-7 col-sm-7 col-xs-12">
					{{Form::text('total_days', null, ['class'=>'form-control input-sm',"readonly" => true,"id" => "total_days"])}}
				</div>
			</div>

			<div class="form-group">
				{{Form::label('reason', 'Leave Reason *', ['class'=>'control-label col-md-5 col-sm-5 col-xs-12 nowrap'])}}
				<div class="col-md-7 col-sm-7 col-xs-12">
					{{Form::textarea('reason', null, ['class'=>'form-control input-sm',"rows" => 4,"cols" => 8,"id" => "reason"])}}
				</div>
			</div>

			<div class="form-group">
				{{Form::label('approver_id', 'Approver *', ['class'=>'control-label col-md-5 col-sm-5 col-xs-12 nowrap'])}}
				<div class="col-md-7 col-sm-7 col-xs-12">
					{{Form::select('approver_id', $approvers, null, ['class'=>'form-control input-sm selectpicker',"placeholder" => "Select", "id" => "approver_id"])}}
				</div>
			</div>

			<div class="form-actions">
				<div class="row">
					<div class="col-md-7 col-md-offset-5 text-center">
						{{ Form::submit('Submit', ['class'=>'btn btn-primary']) }}
						<a href="{{ URL::to('/leaves/list') }}" class="btn btn-primary">Cancel</a>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6 col-sm-6 col-xs-12">
		</div>
		<div class="clearfix"></div>
		<div class="margin-bottom-10"></div>
		{!! Form::close() !!}

@endsection