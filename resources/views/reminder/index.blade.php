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
      <table class="table tab-content table-responsive table-hover">
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
              <td>{{ucfirst($value->user_reminder_status)}}</td>
              <td>
                <div class="dropdown">
                  <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    Action
                    <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                    <li><button type="button" class="btn btn-link" data-toggle="modal" data-target="#updatereminderModal_{{$value->user_reminder_id}}">Add new</button></li>
                    <li>
                      <form action="{{ route('reminder.destroy', $value->user_reminder_id) }}" method="POST">
                          @method('DELETE')
                          @csrf
                          <button class="btn btn-link">Delete Reminder</button>
                      </form>
                    </li>
                    <li>
                      <form action="{{ route('reminder.edit', $value->user_reminder_id) }}" method="GET">
                          @csrf
                          <button class="btn btn-link">Mark Complete</button>
                      </form>
                    </li>
                    @if (isset($value->user->type) && $value->user->type->user_type != 'Admin' && $value->user_reminder_status != 'converted')
                      <li>
                        {!! Form::open(['route'=>'convertToTask', 'method'=>'POST']) !!}
                          {{ Form::hidden('user_reminder_id', $value->user_reminder_id) }}
                          <button class="btn btn-link">Convert to task</button>
                        {!! Form::close() !!}
                      </li>
                    @endif
                  </ul>
                </div>
              </td>
            </tr>
            @include('reminder.updateReminder_modal')
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
  @include('reminder.reminder_modal')
@endsection
