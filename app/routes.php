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



Route::get('/', 'HomeController@showWelcome');
Route::get('home', 'HomeController@showWelcome');

Route::get('widemap', function()
{
	 return View::make('widemap');
});

Route::get('team', 'TeamController@showPage');

Route::get('player', 'PlayerController@showPage');

Route::get('players', 'PlayersController@showPage');

Route::get('player/history', function() {
	return View::make('player/history');
});

// AUTH
Route::match(array('GET', 'POST'), 'user/login', 'UserController@login');
// For simple box on website
Route::get('user/loginmodal', 'UserController@loginmodal');
Route::match(array('GET', 'POST'), 'user/register', 'UserController@register');
Route::get('user/activate/{username}/{registrationcode}', 'UserController@activate');
Route::get('user/logout', 'UserController@logout');
Route::match(array('GET', 'POST'),'user/passwordforgot', 'UserController@passwordforgot');

