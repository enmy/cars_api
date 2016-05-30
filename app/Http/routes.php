<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::group(['prefix' => 'api'], function () {

	// /api/users
	Route::group(['prefix' => 'users'], function () {

		// Crea un usuario nuevo
		Route::post('create','UserController@create');

		// Login
		Route::post('login' ,'UserController@login');

		Route::group(['middleware' => 'auth'], function () {
			
			// Logout
			Route::get('logout','UserController@logout');

			// Datos del usuario
			Route::get('{user}','UserController@user')->where('user', '[0-9]+');

		});

	});

	// /api/cars
	Route::group(['prefix' => 'cars'], function () {
		
		// Se listan todos los carros disponibles
		Route::get( '/','CarController@getAll');
		
		Route::group(['middleware' => 'auth'], function () {

			// Un usuario crea un carro para vender
			Route::post('create','CarController@create');
			
			// Un usuario desea un carro
			Route::post('wish/create', 'WishController@create');
			
			// Se listan los carros deseados por un usuario
			Route::get( 'wish', 'WishController@getWish');

			// Se listan los usuarios que desean el carro del vendedor
			Route::get( 'contact', 'WishController@getContact');
		});
	});


});


Route::get('/', function() {
	return 'En la raiz';
});

Route::get('/hola',function(){
	return 'hola';
});
