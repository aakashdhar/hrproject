
@extends('adminlte::page')

@section('title', 'AdminLTE')
<?php
dd(config('adminlte.menu')[3]["url"],"#")
?>d

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <p>You are logged in!</p>
    <a href="{{url("employees/leave")}}">Leave Application</a>
@stop
