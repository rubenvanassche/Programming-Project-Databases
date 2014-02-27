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
	return View::make('hello');
});

Route::get('users', function()
{
    return 'Users!';
});

Route::get('user/{id}', function($id)
{
    return 'User    ddd '.$id;
});

Route::get('register', function()
{
	return View::make('register');
});

Route::post('processRegistration', function()
{
    return View::make('processRegistration');
});

Route::get('login', function()
{
    return View::make('login');
});

Route::post('processLogin', function()
{
    return View::make('processLogin');
});

Route::get('checkLogin', function()
{
    return View::make('checkLogin');
});

Route::get('logout', function()
{
    return View::make('logout');
});

Route::post('register', function()
{
    return View::make('register');
});

Route::post('login', function()
{
    return View::make('login');
});
