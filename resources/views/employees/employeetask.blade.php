
@extends('adminlte::page')

@section('title', 'Admins')

@section('content_header')
    <div class="row">
        <div class="col-md-3"></div>
        
    </div>

@stop

@section('content')
    
    <br>
    <div class="panel">
        <div class="panel-heading">
        </div>
        <h2>Tasks</h2>
        <div class="panel-body">
            <table class="table">
                <thead>
                    
                </thead>
                <?php
                $data = \Auth::user();
                $task = Illuminate\Support\Facades\DB::table("user_tasks");
                ?>
            @foreach
            <tr>
                <td>
                    
                </td>
            </tr>
            @endforeach
            </table>
        </div>
        
    </div>

    <div id="newAdminModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content">
                
            </div>

        </div>
    </div>
@stop