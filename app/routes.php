<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

// Route::get('/', function()
// {
// 	return View::make('hello');
// });
Route::controller('course', 'CourseController');
Route::controller('dashboard', 'dashboardController');
Route::controller('membership', 'MembershipController');
Route::controller('/', 'MainController');

// Route::get('/', 'MainController@showWelcome');
// Route::post('/', 'MainController@postLogin');