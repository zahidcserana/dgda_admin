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
Route::get('/orders', 'OrderController@index')->name('orders');
Route::get('/orders/list', 'OrderController@orderList')->name('order_list');
Route::get('/orders/{id}', 'OrderController@view')->name('order_view');
Route::get('/orders/{id}/details', 'OrderController@details')->name('order_details');
Route::post('/orders/{id}', 'OrderController@edit')->name('order_edit');
Route::get('/orders/{id}/delete', 'OrderController@delete')->name('order_delete');


/* Users */
Route::get('/users/{id?}', 'UsersController@index')->name('users');
Route::post('/users/{id}', 'UsersController@edit')->name('user_edit');
Route::get('/user-delete/{id}', 'UsersController@delete')->name('user-delete');

