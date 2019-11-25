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
	});
	// Route::resource('roles','RoleController');
	Route::prefix('roles')->group(function () {
		Route::get('page','RoleController@page');
		Route::get('permission','RoleController@permission');
		Route::get('edit/{id}','RoleController@edit');
		Route::post('add','RoleController@add');
		Route::post('update/{id}','RoleController@update');
		Route::post('delete/{id}','RoleController@delete');
	});
});
