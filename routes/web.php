<?php

/*
|--------------------------------------------------------------------------
|
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

//Auth::routes();
/* Authentication Routes Start*/
//Route::get('/', 'HomeController@index')->name('home')->middleware(['UserAuth']);
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');
/* Authentication Routes End */

Route::get('/', 'HomeController@index')->name('admin');
Route::get('/home', 'HomeController@index')->name('home');

/** Orders */
Route::get('/orders', 'OrderController@index')->name('orders')->middleware('auth');
Route::get('/orders/list', 'OrderController@orderList')->name('order_list');   // ajax
Route::get('/orders/items', 'OrderController@orderItems')->name('order_items')->middleware('auth');
Route::get('/orders/item-list', 'OrderController@itemList')->name('item_list'); // ajax
Route::get('/orders/{id}', 'OrderController@view')->name('order_view')->middleware('auth');
Route::get('/orders/{id}/details', 'OrderController@details')->name('order_details')->middleware('auth');
Route::post('/orders/{id}', 'OrderController@edit')->name('order_edit')->middleware('auth');
Route::get('/orders/{id}/delete', 'OrderController@delete')->name('order_delete')->middleware('auth');

/** Company */
Route::get('/company/list', 'OrderController@companyList');   // ajax
Route::get('/company/lists', 'OrderController@companyView')->name('company_list')->middleware('auth');

/** Medicine */
Route::get('/medicine/list', 'OrderController@medicineList');   // ajax
Route::get('/medicine', 'OrderController@medicineView')->name('medicine')->middleware('auth');

/** Pharmacy */
Route::get('/pharmacies', 'PharmacyController@index')->name('pharmacies')->middleware('auth');
Route::get('/pharmacies/list', 'PharmacyController@pharmacyList')->name('pharmacy_list')->middleware('auth');

/* Users */
Route::get('/users/{id?}', 'UsersController@index')->name('users');
Route::post('/users/{id}', 'UsersController@edit')->name('user_edit');
Route::get('/user-delete/{id}', 'UsersController@delete')->name('user-delete');

