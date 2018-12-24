@extends('adminlte::master')

@section('adminlte_css')
    <link rel="stylesheet"
          href="{{ asset('vendor/adminlte/dist/css/skins/skin-' . config('adminlte.skin', 'blue') . '.min.css')}} ">

    @stack('css')
    @yield('css')
@stop

@section('body_class', 'skin-' . config('adminlte.skin', 'blue') . ' sidebar-mini ' . (config('adminlte.layout') ? [
    'boxed' => 'layout-boxed',
    'fixed' => 'fixed',
    'top-nav' => 'layout-top-nav'
][config('adminlte.layout')] : '') . (config('adminlte.collapse_sidebar') ? ' sidebar-collapse ' : ''))

@section('body')
<!--changing adminlte.php for users to restrict them-->
@if(Auth::user()->user_type_id != 1)
    {{
        Illuminate\Support\Facades\Config::set
        ([
          'adminlte.menu' => [
              'GENERAL',
              [
                  'text'        => 'Dashboard',
                  'url'         => 'home',
                  'icon'        => 'home',
              ],
              'LEAVE MANAGEMENT',
              [
                  'text'    => 'Leave Management',
                  'url'    => 'leaves/list',
                  'icon'    => 'share',
              ],
              'TASK',
              [
                  'text'        => 'Task Management',
                  'url'         => 'employees/task',
                  'icon'        => 'tasks',
              ],
              [
                  'text' => 'Task Reminder',
                  'url'  => 'reminder',
                  'icon' => 'calendar',
              ]
          ]
      ])
    }}
@endif

    <div class="wrapper">

        <!-- Main Header -->
        <header class="main-header">
            @if(config('adminlte.layout') == 'top-nav')
            <nav class="navbar navbar-static-top">
                <div class="container">
                    <div class="navbar-header">
                        <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}" class="navbar-brand">
                            {!! config('adminlte.logo', '<b>Admin</b>LTE') !!}
                        </a>
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                            <i class="fa fa-bars"></i>
                        </button>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                        <ul class="nav navbar-nav">

                            @each('adminlte::partials.menu-item-top-nav', $adminlte->menu(), 'item')
                        </ul>
                    </div>
                    <!-- /.navbar-collapse -->
            @else
            <!-- Logo -->
            <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini">{!! config('adminlte.logo_mini', '<b>A</b>LT') !!}</span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg">{!! config('adminlte.logo', '<b>Admin</b>LTE') !!}</span>
            </a>

            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">{{ trans('adminlte::adminlte.toggle_navigation') }}</span>
                </a>
            @endif
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">
                  <?php
                    $currentUserName = Auth::user()->user_first_name ." ".Auth::user()->user_last_name;
                    $currentUserJoiningDate = date('M. y',strtotime(Auth::user()->joining_date));
                    $userDesignation = (!is_null(Auth::user()->user_designation))? Auth::user()->user_designation : 'Admin';

                   ?>
                    <ul class="nav navbar-nav">
                      <li class="dropdown tasks-menu" data-toggle="tooltip" title="Quick Task">
                        <a href="#" class="dropdown-toggle" data-toggle="modal" data-target="#quickTaskModal">
                          <i class="fa fa-plus"></i>
                          <span class="label label-danger"></span>
                        </a>
                      </li>
                      <!-- User Account: style can be found in dropdown.less -->
                      <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                          <img src="{{asset('img/user2-160x160.jpg')}}" class="user-image" alt="User Image">
                          <span class="hidden-xs">{{$currentUserName}}</span>
                        </a>
                        <ul class="dropdown-menu">
                          <!-- User image -->
                          <li class="user-header">
                            <img src="{{asset('img/user2-160x160.jpg')}}" class="img-circle" alt="User Image">

                            <p>
                              {{ucfirst($currentUserName)}} - {{$userDesignation}}
                              <small>Member since {{$currentUserJoiningDate}}</small>
                            </p>
                          </li>
                          <!-- Menu Body -->
                          <li class="user-body">
                            {{-- <div class="row">
                              <div class="col-xs-4 text-center">
                                <a href="#">Followers</a>
                              </div>
                              <div class="col-xs-4 text-center">
                                <a href="#">Sales</a>
                              </div>
                              <div class="col-xs-4 text-center">
                                <a href="#">Friends</a>
                              </div>
                            </div> --}}
                            <!-- /.row -->
                          </li>
                          <!-- Menu Footer-->
                          <li class="user-footer">
                            <div class="pull-left">
                              <a href="#" class="btn btn-default btn-flat">Profile</a>
                            </div>
                            <div class="pull-right">
                              <a href="#" class="btn btn-default btn-flat" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                  {{ trans('adminlte::adminlte.log_out') }}
                              </a>
                              <form id="logout-form" action="{{ url(config('adminlte.logout_url', 'auth/logout')) }}" method="POST" style="display: none;">
                                  @if(config('adminlte.logout_method'))
                                      {{ method_field(config('adminlte.logout_method')) }}
                                  @endif
                                  {{ csrf_field() }}
                              </form>
                            </div>
                          </li>
                        </ul>
                      </li>
                        <li>

                        </li>
                        <li>
                          <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                        </li>
                    </ul>
                </div>
                @if(config('adminlte.layout') == 'top-nav')
                </div>
                @endif
            </nav>
        </header>
        <div class="modal fade" id="quickTaskModal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-body">
                <!-- TO DO List -->
                <div class="box box-primary">
                  <div class="box-header">
                    <i class="ion ion-clipboard"></i>
                    <h3 class="box-title">To Do List</h3>
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body">
                    <!-- See dist/js/pages/dashboard.js to activate the todoList plugin -->
                    <ul class="todo-list">
                      @foreach ($quickTask as $key => $value)
                        <li>
                          <!-- checkbox -->
                          <input type="checkbox" value="">
                          <!-- todo text -->
                          <span class="text">{{$value->user_quicktask_content}}</span>
                          <!-- Emphasis label -->
                          <small class="label label-danger"><i class="fa fa-clock-o"></i> {{date('D M,Y',strtotime($value->created_at))}}</small>
                          <!-- General tools such as edit or delete-->
                          <div class="tools">
                            <i class="fa fa-edit"></i>
                            <i class="fa fa-trash-o"></i>
                          </div>
                        </li>
                      @endforeach
                    </ul>
                  </div>
                  <!-- /.box-body -->
                  <div class="box-footer clearfix no-border">
                    <div class="form-group add-quickTask" style="display:none">
                      <label for="">Add Quick Taks</label>
                      <input type="text" name="user_quicktask_content" class="form-control" id="add-quickTaskText" placeholder="Add Quick Taks">
                    </div>
                      <input type="hidden" id="add-quickTaskUser"  name="user_quicktask_userid" value="{{Auth::user()->user_id}}">
                    <button type="button" id="add-todo" class="btn btn-default pull-right"><i class="fa fa-plus"></i> Add item</button>
                  </div>
                </div>
                <!-- /.box -->
              </div>
            </div>
          </div>
        </div>
        @if(config('adminlte.layout') != 'top-nav')
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">

            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">

                <!-- Sidebar Menu -->
                <ul class="sidebar-menu" data-widget="tree">
                    @each('adminlte::partials.menu-item', $adminlte->menu(), 'item')
                </ul>
                <!-- /.sidebar-menu -->
            </section>
            <!-- /.sidebar -->
        </aside>
        @endif

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @if(config('adminlte.layout') == 'top-nav')
            <div class="container">
            @endif

            <!-- Content Header (Page header) -->
            <section class="content-header">
                @yield('content_header')
            </section>

            <!-- Main content -->
            <section class="content">

                @yield('content')

            </section>
            <!-- /.content -->
            @if(config('adminlte.layout') == 'top-nav')
            </div>
            <!-- /.container -->
            @endif
        </div>
        <!-- /.content-wrapper -->

    </div>
    <!-- ./wrapper -->
@stop

@section('adminlte_js')
    <script src="https://adminlte.io/themes/AdminLTE/bower_components/jquery-ui/jquery-ui.min.js" charset="utf-8"></script>
    <script src="{{ asset('js/TodoList.js') }}" charset="utf-8"></script>
    <script src="{{ asset('vendor/adminlte/dist/js/adminlte.js') }}"></script>
    <script src="{{ asset('js/dashboard.js')}}" charset="utf-8"></script>
    @stack('js')
    @yield('js')
@stop
