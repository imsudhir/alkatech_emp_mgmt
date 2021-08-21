<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmpDataController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmpController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('admin');
});

// Route::get('/updatepassword', [AdminController::class, 'updatepassword']);
Route::get('/registration', [EmpDataController::class, 'emp_registration_form']);
Route::post('/emp_registration_form_process', [EmpDataController::class, 'emp_registration_form_process'])->name('frontend.emp_registration_form_process');

//admin section start here
Route::get('admin', [AdminController::class, 'index']);
Route::get('user', [EmpController::class, 'index']);
Route::post('user_login_process', [EmpController::class, 'user_login_process'])->name('emp.user_login_process');
Route::post('user_signup', [EmpController::class, 'user_signup'])->name('emp.user_signup');
Route::post('admin/auth', [AdminController::class, 'auth'])->name('admin.auth');
Route::get('email_verification/{id}', [EmpController::class, 'email_verification']);
Route::post('forgot_password_process', [EmpController::class, 'forgot_password_process']);
Route::get('forgot_password_process_change/{id}', [EmpController::class, 'forgot_password_process_change']);
Route::post('forgot_password_process_change_update', [EmpController::class, 'forgot_password_process_change_update']);


Route::group(['middleware'=>'admin_auth'], function(){
Route::get('admin/dashboard', [AdminController::class, 'dashboard']);
Route::get('admin/emp', [AdminController::class, 'emp_list']);
Route::get('admin/emp/status/{status}/{id}', [AdminController::class, 'status']);
Route::get('admin/emp/status/{status}/{id}', [AdminController::class, 'status']);

Route::post('admin/search_employee', [AdminController::class, 'search_employee'])->name('admin.search_employee');
Route::get('admin/upload_attendance', [AdminController::class, 'upload_attendance']);
Route::post('admin/upload_attendance_process', [AdminController::class, 'upload_attendance_process'])->name('admin.upload_attendance_process');

Route::get('admin/attendance-reporting', [AdminController::class, 'attendance_reporting']);
Route::post('admin/attendance_reporting_process', [AdminController::class, 'attendance_reporting_process'])->name('admin.attendance_reporting_process');

Route::post('admin/attendance_filter_before_upload_process', [AdminController::class, 'attendance_filter_before_upload_process'])->name('admin.attendance_filter_before_upload_process');

Route::get('admin/logout', function(){
    session()->forget('ADMIN_LOGIN');
    session()->forget('ADMIN_ID');
    session()->flash('error','Logout Successfully');
return redirect('admin');
});
});
Route::group(['middleware'=>'emp_auth'], function(){
    Route::get('user/dashboard', [EmpController::class, 'dashboard']);
    Route::get('user/logout', function(){
        session()->forget('USER_LOGIN');
        session()->forget('USER_ID');
        session()->flash('error','Logout Successfully');
    return redirect('user');
    });
    });