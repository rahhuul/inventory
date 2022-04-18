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
Route::get('/','Admin\Login_Controller@index');
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
    Route::resource('admin/rent', Admin\RentController::class);
    Route::resource('admin/received', Admin\ReceivedController::class);
    Route::resource('admin/pending', Admin\PendingController::class);
    Route::resource('admin/deposit', Admin\DepositControlle::class);
    Route::resource('admin/bill', Admin\BillController::class);
    Route::resource('admin/account', Admin\AccountController::class);
    Route::resource('admin/customaterial', Admin\CustomaterialController::class);


    Route::get('rent/addreceive/{id}','Admin\RentController@addreceive' );
    Route::get('user/adddeposit/{id}','Admin\UserController@adddeposit' );
    Route::post('customers', 'Admin\UserController@allCustomers' )->name('customers');
    Route::post('categories', 'Admin\CategoryController@allCategories' )->name('categories');
    Route::post('materials', 'Admin\MaterialController@allMaterials' )->name('materials');
    Route::post('rents', 'Admin\RentController@allRents' )->name('rents');
    Route::post('pendingmaterial', 'Admin\PendingController@allpenmaterials' )->name('pendingmaterial');

    Route::post('customermaterial', 'Admin\CustomaterialController@allcustmaterials' )->name('customermaterial');
    Route::post('billcustomermaterial', 'Admin\BillController@allcustmaterials' )->name('billcustomermaterial');

    Route::post('receivs', 'Admin\ReceivedController@allReceive' )->name('receivs');

    Route::post('accountstatus', 'Admin\AccountController@getaccountdetail' )->name('accountstatus');


    Route::post('rent-materials', 'Admin\RentController@getMaterials' )->name('rent-materials');
    Route::post('receive-materials', 'Admin\ReceivedController@getMaterials' )->name('receive-materials');

    Route::get('generatepdf/{id}', 'Admin\BillController@generatePDF');

    //Route::post('rent-materials', 'Admin\RentController@getMaterials' )->name('rent-materials');

    /* Route::get('admin/user','Admin\UserController@index');
    Route::get('admin/user/delete/{id}','Admin\UserController@destroy');
    Route::get('admin/user/edit/{id}','Admin\UserController@edit');
    Route::post('admin/user/update/{id}','Admin\UserController@update');
    Route::get('admin/user/create','Admin\UserController@create');
    Route::post('admin/user/store','Admin\UserController@store'); */
    //Route::get('admin/event','Admin\UserController@index');
    //Route::get('admin/event/getdata','Admin\UserController@getdata');
});

Route::get('/clear-cache', function() {
    //Artisan::call('route:cache');
    Artisan::call('route:clear');
    Artisan::call('cache:clear');
    Artisan::call('view:clear');
    Artisan::call('config:clear');
    return "Cache is cleared";
});