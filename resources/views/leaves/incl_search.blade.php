<div class="form-group page_search margin-top-5 search-margines">

	<div class="row">
		<div class="col-md-12">
            {!! Form::select('user_id', $applicants, $user_id, ['class'=>'form-control selectpicker input-sm company-sel', 'data-size'=>"4", 'data-live-search'=>"true", 'id'=>'user_id','placeholder' => 'Pick a User...']) !!}
         </div>
	</div>

	<div class="row margin-top-10">
		<div class="col-md-12 col-sm-12 col-xs-12">
			<div class="input-group input-group-sm margin-top-10">
				<span class="input-group-addon">
					 <i class="fa fa-ticket"></i>
				</span>
				{!! Form::select('status', ['Pending' => "Pending", 'Approved' => "Approved", 'Rejected' => "Rejected", 'Cancelled' => "Cancelled", "All" => "All"], $status, ['class'=>'form-control selectpicker', 'id' => 'status']) !!}
			</div>
		</div>
	</div>

	<div class="row">
        <div class="col-md-6 col-sm-6 col-xs-6">
            <div class="input-group input-group-sm margin-top-10">
                <span class="input-group-addon">
                   <i class="fa fa-calendar"></i>
                </span>
                <input class="form-control" id="from_date" name="from_date" type="text" value="{{ \Carbon\Carbon::parse($from_date)->format('d-m-Y') }}" placeholder="From Date" readonly>
            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-6">
            <div class="input-group input-group-sm margin-top-10">
                <span class="input-group-addon">
                   <i class="fa fa-calendar"></i>
                </span>
                <input class="form-control" id="to_date" name="to_date" type="text" value="{{ \Carbon\Carbon::parse($to_date)->format('d-m-Y') }}" placeholder="To Date" readonly>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="row">
        <div class="col-md-6 col-sm-6 col-xs-6">
            <div class="input-group input-group-sm margin-top-10 pull-left">
                <button class="applyBtn btn btn-sm green-seagreen" type="submit" id="apply_date_filter">Apply</button>
            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-6">
            <div class="input-group input-group-sm margin-top-10 pull-right">
                <button class="applyBtn btn btn-sm red-sunglo" type="button" id="reset_date_filter">Reset</button>
            </div>
        </div>
    </div>
</div>