<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/','Auth\LoginController@showLoginForm');
Route::get('/login','Auth\LoginController@showLoginForm')->name('login');
Route::post('/login','Auth\LoginController@login')->name('login');
Route::post('/logout','Auth\LoginController@logout')->name('logout');

Route::get('/dashboard','DashboardController@index')->name('dashboard')->middleware('auth');

//Backend
Route::group(['middleware' => 'auth'], function () {
	//Body
	Route::resource('department', 'DepartmentController');
	Route::resource('company', 'CompanyController');
	Route::resource('employee', 'EmployeeController');
	Route::post('get-employee', 'EmployeeController@employeesByCSV')->name('get-employee');
});