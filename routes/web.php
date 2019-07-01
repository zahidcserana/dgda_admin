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

/*Customers*/
Route::get('/customers', 'CustomersController@index')->name('customers');
Route::get('/orders', 'CustomersController@index')->name('orders');
Route::get('/customers/list', 'CustomersController@customersList')->name('customer_list');
Route::get('/customer-form', 'CustomersController@form')->name('customer_form');
Route::post('/customers', 'CustomersController@add')->name('add_customer');
Route::get('/customers/{id}', 'CustomersController@view')->name('customer_edit');
Route::post('/customers/{id}', 'CustomersController@edit')->name('customer_edit');
Route::post('/customer-image', 'CustomersController@customerImage')->name('customer_image');
Route::get('/customers/{id}/delete', 'CustomersController@delete')->name('customer_delete');

/* Accounts */
Route::get('/accounts', 'AccountsController@index')->name('accounts');
Route::post('/accounts', 'AccountsController@add')->name('add_account');
Route::get('/accounts/list', 'AccountsController@accountsList')->name('account_list');
Route::get('/account-form', 'AccountsController@form')->name('account_form');
Route::get('/accounts/{id}', 'AccountsController@view')->name('account_edit');
Route::post('/accounts/{id}', 'AccountsController@edit')->name('account_edit');
Route::get('/accounts/{id}/delete', 'AccountsController@delete')->name('account_delete');
Route::get('/download-pdf', 'AccountsController@downloadPDF');

/* Users */
Route::get('/users/{id?}', 'UsersController@index')->name('users');
Route::post('/users/{id}', 'UsersController@edit')->name('user_edit');
Route::get('/user-delete/{id}', 'UsersController@delete')->name('user-delete');

