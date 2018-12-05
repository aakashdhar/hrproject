<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes();

Route::get('home', 'HomeController@index'); 

Route::get('admin/addUserType', 'Admin\UserTypeController@addUserType');
Route::get('admin/addUserType/assignType', 'Admin\UserTypeController@assignUserType');

Route::get("admin/addUser","Admin\UserRegistrationFormController@showPage");
Route::post("admin/addUser/registerUser","Admin\UserRegistrationFormController@addUser");

Route::get("tasks","Admin\TaskDistributionController@showPage_admin");
Route::post("tasks/assignTask","Admin\TaskDistributionController@assignTask");
Route::post("tasks/statusByAdmin","Admin\TaskDistributionController@taskStatusByAdmin");

Route::get("admin/leave","Employees\LeaveManagementController@showPage_admin");
Route::post("admin/leave/accept","Employees\LeaveManagementController@respond");
Route::post("admin/leave/reject","Employees\LeaveManagementController@respond");


Route::get("employees","Employees\EmployeesController@showPage");

Route::post("employees/sendmail","Admin\MailController@sendmail");

Route::get("employees/task","Admin\TaskDistributionController@showPage_user");
Route::post("employees/task/start","Admin\TaskDistributionController@taskStatus");
Route::post("employees/task/pause","Admin\TaskDistributionController@taskStatus");
Route::post("employees/task/stop","Admin\TaskDistributionController@taskStatus");

Route::get("employees/leave","Employees\LeaveManagementController@showPage_user");
Route::post("employees/leave/apply","Employees\LeaveManagementController@apply");


Route::post("admin/update/{id}","Admin\AdminController@UpdateAdmin");
Route::post("employee/update/{id}","Employees\EmployeesController@updateEmployee");
Route::post("employee/delete/{id}","Employees\EmployeesController@deleteEmployee");

Route::middleware('auth')->group(function() {
    Route::prefix('/')->group(function() {
        require_once ('routes/routes_admin_users.php');
    });
});



Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
