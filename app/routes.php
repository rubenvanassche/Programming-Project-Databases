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

Route::get('/', function()
{
	// return with view
	//return View::make('home')->with('view', 'ruben')->with('title', 'Home');
	// return with parameter content given in blade file
	 return View::make('home')->with('title', 'Home');
});

Route::get('widemap', function()
{
	 return View::make('widemap');
});

Route::get('team', function()
{
	 return View::make('team');
});

Route::get('player', function()
{
	 return View::make('player');
});

// AUTH
Route::match(array('GET', 'POST'), 'user/login', 'UserController@login');
Route::match(array('GET', 'POST'), 'user/register', 'UserController@register');
Route::get('user/activate/{username}/{registrationcode}', 'UserController@activate');
Route::get('user/logout', 'UserController@logout');
Route::match(array('GET', 'POST'),'user/passwordforgot', 'UserController@passwordforgot');

