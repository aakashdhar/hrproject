<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::get('/admin/dashboard', 'HomeController@index')->name('home');


Route::middleware('auth')->group(function() {
    Route::prefix('/admin')->group(function() {
        require_once ('routes/routes_admin_users.php');
    });
});


