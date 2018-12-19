@extends('adminlte::master')

@section('adminlte_css')
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/css/auth.css') }}">
    @yield('css')
@stop

@section('body_class', 'register-page')

@section('body')
    <div class="register-box">
        <div class="register-logo">
            <a href="">Siimteq<b>HR</b></a>
        </div>

        <div class="register-box-body">
            <p class="login-box-msg">{{ trans('adminlte::adminlte.register_message') }}</p>
            <form action="{{ url(config('adminlte.register_url', 'register')) }}" method="post">
                {!! csrf_field() !!}

                <div class="form-group has-feedback {{ $errors->has('user_name') ? 'has-error' : '' }}">
                    <input type="text" name="user_name" class="form-control" value="{{ old('user_name') }}"
                           placeholder="User name">
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    @if ($errors->has('user_name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('user_name') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group has-feedback {{ $errors->has('user_first_name') ? 'has-error' : '' }}">
                    <input type="text" name="user_first_name" class="form-control" value="{{ old('user_first_name') }}"
                           placeholder="First name">
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    @if ($errors->has('user_first_name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('user_first_name') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group has-feedback {{ $errors->has('user_last_name') ? 'has-error' : '' }}">
                    <input type="text" name="user_last_name" class="form-control" value="{{ old('user_last_name') }}"
                           placeholder="Last name">
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    @if ($errors->has('user_last_name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('user_last_name') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group has-feedback {{ $errors->has('user_email') ? 'has-error' : '' }}">
                    <input type="email" name="user_email" class="form-control" value="{{ old('user_email') }}"
                           placeholder="{{ trans('adminlte::adminlte.email') }}">
                    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    @if ($errors->has('user_email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('user_email') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group has-feedback {{ $errors->has('user_password') ? 'has-error' : '' }}">
                    <input type="password" name="user_password" class="form-control"
                           placeholder="{{ trans('adminlte::adminlte.password') }}">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    @if ($errors->has('user_password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('user_password') }}</strong>
                        </span>
                    @endif
                </div>
                <button type="submit"
                        class="btn btn-primary btn-block btn-flat"
                >{{ trans('adminlte::adminlte.register') }}</button>
            </form>
            <div class="auth-links">
                <a href="{{ url(config('adminlte.login_url', 'login')) }}"
                   class="text-center">{{ trans('adminlte::adminlte.i_already_have_a_membership') }}</a>
            </div>
        </div>
        <!-- /.form-box -->
    </div><!-- /.register-box -->
@stop

@section('adminlte_js')
    @yield('js')
@stop