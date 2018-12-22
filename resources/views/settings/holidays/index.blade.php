@extends('adminlte::page')

@section('title', 'Holidays')
@section('content')
<div class="panel panel-default">
  <div class="panel-body">
    <h2>Holidays</h2>
    <div class="row">
      <div class="col-md-6">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title">Added Holidays</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body no-padding">
            <table class="table table-striped">
              <tr>
                <th style="width: 10px">#</th>
                <th>Holiday Name</th>
                <th>Holiday Date</th>
                <th>Action</th>
              </tr>
              @if (!empty($holiday))
                @php
                  $i = 1;
                @endphp
                @foreach ($holiday as $key => $value)
                  <tr>
                    <td>{{$i++}}</td>
                    <td>{{$value->holiday_name}}</td>
                    <td>{{date('d-m-Y',strtotime($value->holiday_date))}}</td>
                    <td>
                      <div class="dropdown">
                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                          Action
                          <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                          <li>
                            <form action="{{ route('holidays.edit', $value->holiday_id) }}" method="GET">
                                @csrf
                                <button class="btn btn-link">Update Holiday</button>
                            </form>
                          </li>
                          <li>
                            <form action="{{ route('holidays.destroy', $value->holiday_id) }}" method="POST">
                                @method('DELETE')
                                @csrf
                                <button class="btn btn-link">Delete Holiday</button>
                            </form>
                          </li>
                        </ul>
                      </div>
                    </td>
                  </tr>
                @endforeach
              @endif
            </table>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <div class="col-md-6">
        <div class="box box-success">
          <div class="box-header">
            <h3 class="box-title">Add Holiday</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body no-padding">
            @if (!empty($holidayEdit))
                <form class="" action="{{route('holidays.update',$holidayEdit->holiday_id)}}" method="POST">
                  @method('PUT')
                  @csrf
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="">Holiday Name</label>
                      <input type="text" name="holiday_name" class="form-control" value="{{$holidayEdit->holiday_name}}" id="" placeholder="Holiday name">
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="">Holiday Date</label>
                      <input type="date" name="holiday_date" class="form-control" value="{{$holidayEdit->holiday_date}}" id="" placeholder="holiday date">
                    </div>
                  </div>
                  <input type="submit" class="btn btn-primary btn-sm pull-right" name="submit" value="Update Holiday">
                </form>
              @else
                <form class="" action="{{route('holidays.store')}}" method="POST">
                  @csrf
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="">Holiday Name</label>
                      <input type="text" name="holiday_name" class="form-control" id="" placeholder="Holiday name">
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="">Holiday Date</label>
                      <input type="date" name="holiday_date" class="form-control" id="" placeholder="holiday date">
                    </div>
                  </div>
                  <input type="submit" class="btn btn-primary btn-flat btn-sm pull-right" name="submit" value="Create Holiday">
                </form>
            @endif
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
    </div>
  </div>
</div>
@endsection
