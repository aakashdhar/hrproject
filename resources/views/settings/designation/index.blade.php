@extends('adminlte::page')

@section('title', 'Designation')
@section('content')
<div class="panel panel-default">
  <div class="panel-body">
    <h2>Designation</h2>
    <div class="row">
      <div class="col-md-6">
        <div class="box box-success">
          <div class="box-header">
            <h3 class="box-title">Added Designation</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body no-padding">
            <table class="table table-striped">
              <tr>
                <th style="width: 10px">#</th>
                <th>Designation</th>
                <th>Action</th>
              </tr>
              @php
                $i = 1;
              @endphp
              @if (!empty($designation))
                @foreach ($designation as $key => $value)
                  <tr>
                    <td>{{$i++}}</td>
                    <td>{{$value->user_designation_title}}</td>
                    <td>
                      <div class="dropdown">
                        <button class="btn btn-primary btn-sm dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                          Action
                          <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                          <li>
                            <form action="{{ route('designation.edit', $value->user_designation_id) }}" method="GET">
                                @csrf
                                <button class="btn btn-link">Update Designation</button>
                            </form>
                          </li>
                          <li>
                            <form action="{{ route('designation.destroy', $value->user_designation_id) }}" method="POST">
                                @method('DELETE')
                                @csrf
                                <button class="btn btn-link">Delete Designation</button>
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
            <h3 class="box-title">Add Designation</h3>
          </div>
          <!-- /.box-header -->
          <div class="box-body no-padding">
            @if (!empty($designationEdit))
                <form class="" action="{{route('designation.update',$designationEdit->user_designation_id)}}" method="POST">
                  @method('PUT')
                  @csrf
                  <div class="form-group">
                    <label for="">Designation</label>
                    <input type="text" name="user_designation_title" value="{{$designationEdit->user_designation_title}}" class="form-control" id="" placeholder="Enter User Designation">
                  </div>
                  <input type="submit" class="btn btn-primary btn-sm pull-right" name="submit" value="Update Designation">
                </form>
              @else
                <form class="" action="{{route('designation.store')}}" method="POST">
                  @csrf
                  <div class="form-group">
                    <label for="">Designation</label>
                    <input type="text" name="user_designation_title" class="form-control" id="" placeholder="Enter User Designation">
                  </div>
                  <input type="submit" class="btn btn-primary btn-sm pull-right" name="submit" value="Create Designation">
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
