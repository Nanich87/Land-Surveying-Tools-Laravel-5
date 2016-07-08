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

Route::get('/', 'AffineTransformationController@index');
Route::get('/affine', 'AffineTransformationController@index');
Route::post('/affine', 'AffineTransformationController@result');
Route::get('home', 'HomeController@index');
Route::get('/helmert', 'AffineTransformationController@index');
Route::get('/conversion', 'ConversionController@index');
Route::post('/conversion', 'ConversionController@result');
Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
