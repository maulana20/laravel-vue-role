<?php
use Illuminate\Http\Request;

Route::prefix('auth')->group(function () {
	Route::post('register', 'UserController@register');
	Route::post('login', 'AuthController@login');
	Route::get('refresh', 'AuthController@refresh');
	Route::group(['middleware' => 'auth:api'], function () {
		Route::get('user', 'AuthController@user');
		Route::get('logout', 'AuthController@logout');
	});
});

Route::group(['middleware' => 'auth:api'], function () {
	Route::prefix('user')->group(function () {
		Route::get('page', 'UserController@page');
		Route::get('edit/{id}','UserController@edit');
		Route::post('add', 'UserController@add');
		Route::post('update/{id}','UserController@update');
		Route::post('delete/{id}','UserController@delete');
	});
	// Route::resource('roles','RoleController');
	Route::prefix('roles')->group(function () {
		Route::get('page','RoleController@page');
		Route::get('pluck','RoleController@pluck');
		Route::get('permission','RoleController@permission');
		Route::get('edit/{id}','RoleController@edit');
		Route::post('add','RoleController@add');
		Route::post('update/{id}','RoleController@update');
		Route::post('delete/{id}','RoleController@delete');
	});
});
