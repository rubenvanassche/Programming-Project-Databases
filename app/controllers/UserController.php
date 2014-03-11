<?php

class UserController extends BaseController {

	function login(){
		if(Request::isMethod('post')){
			// Work On the Form
			$rules = array(
			        'username' => array('required'),
			        'password' => array('required')
			);
			
			$validation = Validator::make(Input::all(), $rules);
			
			if($validation->fails()) {
				// Problem so show the user error messages
				return Redirect::to('user/login')->withInput()->withErrors($validation);
			}else{
				// Start working on this data
				$username = Input::get('username');
				$password = Input::get('password');
				$results = DB::select('SELECT password, registrationcode, id FROM user WHERE username = ?', array($username));
				
				if(empty($results)){
					// Username not found
					echo 'Username doesn\'t exsist!';
					return;
				}
				
				if(!Hash::check($password, $results[0]->password)){
					echo 'The Password isn\'t correct!';
					return;
				}
				
				if(strlen($results[0]->registrationcode) != 0){
					echo 'Your email adress isn\'t validated!';
					return;
				}
				
				// Login was succesfull;
				Session::put('userID', $results[0]->id);
				Session::put('userEntrance', time());
				
				return View::make('team');
			}
    	}else{
	    	// Show the form
	    	return View::make('user/login');
    	}
	}
	
	function register(){
		
	}

}