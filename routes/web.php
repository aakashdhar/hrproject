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
Route::post("admin/update/{id}","Admin\AdminController@UpdateAdmin");
Route::get("admin/addUser","Admin\UserRegistrationFormController@showPage");
Route::post("admin/addUser/registerUser","Admin\UserRegistrationFormController@addUser");

Route::post("password/sendemail","PasswordResetController@sendLink");

Route::get("tasks","Admin\TaskDistributionController@showPage_admin");
Route::post("tasks/delete-task","Admin\TaskDistributionController@deleteTask");
Route::get("tasks/edit-task","Admin\TaskDistributionController@editTask");
Route::post("tasks/edit-task","Admin\TaskDistributionController@editTaskDetails");

Route::post("tasks/assignTask","Admin\TaskDistributionController@assignTask");
Route::post("tasks/statusByAdmin","Admin\TaskDistributionController@taskStatusByAdmin");

Route::get("leaves","Employees\LeaveManagementController@showPage_admin");

Route::get('leaves/view', 'Employees\LeaveManagementController@view_leave');

Route::post("admin/leave/accept","Employees\LeaveManagementController@respond");
Route::post("admin/leave/reject","Employees\LeaveManagementController@respond");

Route::get("employees","Employees\EmployeesController@showPage");
Route::post("employees/store","Employees\EmployeesController@store");
Route::post("employees/sendmail","Admin\MailController@sendmail");

Route::get("employees/task","Admin\TaskDistributionController@showPage_user");
Route::post("employees/task/start","Admin\TaskDistributionController@taskStatus");
Route::post("employees/task/pause","Admin\TaskDistributionController@taskStatus");
Route::post("employees/task/stop","Admin\TaskDistributionController@taskStatus");

Route::get("employees/leave","Employees\LeaveManagementController@showPage_user");
Route::get("employees/leave/delete-leave","Employees\LeaveManagementController@deleteLeave");
Route::get("employees/leave/edit-leave","Employees\LeaveManagementController@editLeave");
Route::post("employees/leave/edit-leave","Employees\LeaveManagementController@editLeaveDetails");
Route::post("employees/leave/apply","Employees\LeaveManagementController@apply");

Route::post("employee/update/{id}","Employees\EmployeesController@updateEmployee");
Route::post("employee/delete/{id}","Employees\EmployeesController@deleteEmployee");

Route::middleware('auth')->group(function() {
    Route::prefix('/')->group(function() {
        Route::resource('reminder', 'Reminder\ReminderController');
        require_once ('routes/routes_admin_users.php');
    });
});

Route::resource('attendace','AttendanceController');
Route::post('undo-attendance', 'AttendanceController@undoAttendance')->name('undoAttendance');

Route::get('/home', 'HomeController@index')->name('home');
