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

<?php
        $loggeduser = Auth::user();

        $usertypes = Illuminate\Support\Facades\DB::select("select user_type_id from user_types where user_type!='Admin'");

        ?>
<!--changing adminlte.php for users to restrict them-->
@foreach($usertypes as $usertype)
    @if($usertype->user_type_id == $loggeduser->user_type_id)

        {{
            Illuminate\Support\Facades\Config::set([
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
@endforeach



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
    <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
    @stack('js')
    @yield('js')
@stop
