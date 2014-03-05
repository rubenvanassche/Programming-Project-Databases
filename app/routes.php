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

Route::get('users', function()
{
    return '				<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel">Login</h4>
				</div>
				<div class="modal-body">
					<form>
					  <div class="form-group">
					    <label>Username</label>
					    <input type="text" class="form-control">
					  </div>
					  <div class="form-group">
					    <label>Password</label>
					    <input type="password" class="form-control">
					  </div>
					</form>		
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-warning">Register</button>
					<button type="button" class="btn btn-success">Login</button>
				</div>
				</div>';
});

Route::get('user/{id}', function($id)
{
    return 'User    ddd '.$id;
});