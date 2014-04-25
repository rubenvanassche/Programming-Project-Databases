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


Route::get('/', array('as' => 'home', 'uses' => 'HomeController@index'));
Route::get('news', array('as' => 'news', 'uses' => 'HomeController@news'));
Route::match(array('GET', 'POST'), 'search', array('as' => 'search', 'uses' => 'SearchController@search'));
Route::match(array('GET', 'POST'), 'search/{input}', array('uses' => 'SearchController@search'));


Route::get('teams', array('as' => 'teams', 'uses' =>'TeamController@all'));
Route::get('team/{id}', array('as' => 'team', 'uses' => 'TeamController@index'));
Route::get('team/{id}/players', array('as' => 'team.players', 'uses' => 'TeamController@players'));
Route::get('team/{id}/information', array('as' => 'team.information', 'uses' => 'TeamController@information'));
Route::get('team/{id}/matches', array('as' => 'team.matches', 'uses' => 'TeamController@matches'));

Route::get('player/{name}', array('as' => 'player', 'uses' =>'PlayerController@index'));

Route::get('match/{id}', array('as' => 'match', 'uses' =>'MatchController@index'));

Route::get('user/bets', array('as' => 'bets', 'uses' => 'BetController@index'));



// ------------
// USER
// ------------
Route::match(array('GET', 'POST'), 'user/login', 'UserController@login');
// For simple box on website
Route::get('user/loginmodal', 'UserController@loginmodal');
Route::get('user', 'UserController@index');
Route::match(array('GET', 'POST'), 'user/register', 'UserController@register');
Route::get('user/activate/{username}/{registrationcode}', 'UserController@activate');
Route::get('user/logout', 'UserController@logout');
Route::match(array('GET', 'POST'),'user/passwordforgot', 'UserController@passwordforgot');
Route::match(array('GET', 'POST'),'user/account', 'UserController@account');
Route::match(array('GET', 'POST'),'user/changepassword', 'UserController@changepassword');

Route::get('usergroups', 'UserController@usergroups');
Route::match(array('GET', 'POST'), 'usergroups/new', 'UserController@newusergroup');
Route::match(array('GET', 'POST'), 'user/bet', 'UserController@bet');


Route::get('inserts', function() {
	return View::make('inserts');
});

Route::get('schema', function() {
        return View::make('schema');
});

