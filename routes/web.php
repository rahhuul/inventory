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

/*Route::get('/', function () {
    return view('welcome');
});*/

/*login routes*/
Route::get('admin','Admin\Login_Controller@index');
Route::get('admin/login','Admin\Login_Controller@index');
Route::get('admin/logout','Admin\Login_Controller@logout');
Route::post('admin/loginaction','Admin\Login_Controller@loginaction');

Route::group(['middleware' => ['adminlogin']], function() {
 /*dasbhboard routes*/

    Route::get('admin/dashboard','Admin\Dashboard_Controller@index')->name('admin_dashboard.index');

    Route::resource('admin/user', Admin\UserController::class); 
    Route::resource('admin/category', Admin\CategoryController::class); 
    Route::resource('admin/material', Admin\MaterialController::class);

    Route::post('customers', 'Admin\UserController@allCustomers' )->name('customers');

    /* Route::get('admin/user','Admin\UserController@index');
    Route::get('admin/user/delete/{id}','Admin\UserController@destroy');
    Route::get('admin/user/edit/{id}','Admin\UserController@edit');
    Route::post('admin/user/update/{id}','Admin\UserController@update');
    Route::get('admin/user/create','Admin\UserController@create');
    Route::post('admin/user/store','Admin\UserController@store'); */
    //Route::get('admin/event','Admin\UserController@index');
    //Route::get('admin/event/getdata','Admin\UserController@getdata');
});
