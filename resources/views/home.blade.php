@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

@stop

@section('content')
<div class="row">
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3>{{ $reminder_count }}</h3>
                <p>Reminders</p>
            </div>
            <div class="icon">
                <i class="ion ion-ios-bell-outline"></i>
            </div>
            <a href="/reminder" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
    @if (\Auth::user()->user_type_id == '1')
      <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
              <div class="inner">
                  <h3>{{ $employee_count }}</h3>
                  <p>Employees</p>
              </div>
              <div class="icon">
                  <i class="ion ion-person-stalker"></i>
              </div>
              <a href="/employees" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
      </div>
      <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
              <div class="inner">
                  <h3>{{ $admin_count }}</h3>
                  <p>Admins</p>
              </div>
              <div class="icon">
                  <i class="ion ion-person"></i>
              </div>
              <a href="/admin" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
      </div>
    @endif
    <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
                <h3>{{ $reminder_count }}</h3>
                <p>Leave Applications</p>
            </div>
            <div class="icon">
                <i class="ion ion-ios-email"></i>
            </div>
            <a href="/leave" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>
@stop
