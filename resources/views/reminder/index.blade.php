@extends('adminlte::page')

@section('title', 'Reminder')
@section('content_header')
  <div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-9">
        <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#newreminderModal">Add Reminder</button>
    </div>
  </div>
@stop
@section('content')
  <div class="panel">
    <div class="panel-body">
      <h2>Reminders</h2>
      <table class="table tab-content table-responsive">
        <thead>
          <th>#</th>
          <th>Name</th>
          <th width="60%">Task</th>
          <th width="10%">Reminder On</th>
          <th width="10%">Status</th>
          <th>Action</th>
        </thead>
        <tbody>
          @php
            $i = 1;
          @endphp
          @foreach ($reminder as $key => $value)
            <tr>
              <td>{{$i++}}</td>
              <td>{{ucfirst($value->user->user_first_name)}}</td>
              <td>{{$value->user_reminder_details}}</td>
              <td>{{date('d-m-Y',strtotime($value->user_remind_on))}}</td>
              <td>{{$value->user_reminder_status}}</td>
              <td></td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  @include('reminder.reminder_modal')
@endsection
