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
Route::get('team/{id}/news', array('as' => 'team.news', 'uses' => 'TeamController@news'));
Route::get('team/{id}/twitter', array('as' => 'team.twitter', 'uses' => 'TeamController@twitter'));
Route::get('team/{id}/graphs', array('as' => 'team.graphs', 'uses' => 'TeamController@graphs'));

Route::get('team', array('as' => 'teamNoIndex', 'uses' => 'TeamController@index')); //for GeoCharts

Route::get('player/{id}', array('as' => 'player', 'uses' =>'PlayerController@index'));

Route::get('match/{id}', array('as' => 'match', 'uses' =>'MatchController@index'));
Route::get('upcoming', 'MatchController@betMatches');

Route::get('user/bets', array('as' => 'bets', 'uses' => 'BetController@index'));

Route::get('matches', 'MatchController@matches');

Route::get('notification/{id}', array('as' => 'notification', 'uses' => 'NotificationController@redirect'));

Route::get('optoutin', 'UserController@optoutin');

// ------------
// USER
// ------------
Route::match(array('GET', 'POST'), 'user/login', 'UserController@login');
// For simple box on website
Route::get('user/loginmodal', 'UserController@loginmodal');
Route::get('user', 'UserController@index');
Route::match(array('GET', 'POST'), 'user/register', 'UserController@register');
Route::get('user/activate/{username}/{registrationcode}', array('as' => 'user/activate', 'uses' =>'UserController@activate'));
Route::get('user/logout', 'UserController@logout');
Route::match(array('GET', 'POST'),'user/passwordforgot', 'UserController@passwordforgot');
Route::match(array('GET', 'POST'),'user/resendmail', 'UserController@resendmail');
Route::match(array('GET', 'POST'),'user/account', 'UserController@account');
Route::match(array('GET', 'POST'),'user/changepassword', 'UserController@changepassword');
Route::match(array('GET', 'POST'),'user/changeprofilepicture', 'UserController@changeprofilepicture');

Route::get('competitions', 'CompetitionController@index');
Route::get('competition/{id}', 'CompetitionController@competition');

Route::get('user/facebooklogin', 'UserController@facebookLogin');

Route::get('usergroups', 'UsergroupController@index');
Route::get('usergroup/{id}', 'UsergroupController@usergroup');
Route::get('usergroup/{id}/addMe', 'UsergroupController@addMe');
Route::get('usergroup/{id}/leave', 'UsergroupController@leave');
Route::get('usergroup/{id}/discussion/{message_id}', 'UsergroupMessagesController@discussion');
Route::match(array('GET', 'POST'),'usergroup/{id}/adddiscussion', 'UsergroupMessagesController@addDiscussion');
Route::match(array('GET', 'POST'),'usergroup/{id}/discussion/{message_id}/add', 'UsergroupMessagesController@addMessage');
Route::match(array('GET', 'POST'),'usergroup/{id}/invite', 'UsergroupController@inviteUser');
Route::match(array('GET', 'POST'), 'usergroups/new', 'UsergroupController@add');

Route::match(array('GET', 'POST'), 'user/bet', 'BetController@bet');
Route::get('user/betmodal', 'BetController@betmodal');

Route::get('profile', 'UserController@profile');
Route::get('profile/{id}', 'UserController@profile');
Route::get('myProfile/{notif_id}/{ug_id}/acceptInvite', 'UserController@acceptInvite');
Route::get('myProfile/{notif_id}/declineInvite', 'UserController@declineInvite');
Route::match(array('GET', 'POST'), 'usergroup/{usergroup_id}', 'UserController@inviteUser');

Route::get('users', 'UserController@userOverview');

Route::get('inserts', function() {
	return View::make('inserts');
});

Route::get('schema', function() {
        return View::make('schema');
});
