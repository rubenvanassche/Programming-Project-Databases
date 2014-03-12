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
				
				$user = new User;
				$user->login($username, $password);
				
				return View::make('team');
			}
    	}else{
	    	// Show the form
	    	return View::make('user/login');
    	}
	}
	
	function register(){
		if(Request::isMethod('post')){
			// Work On the Form
			$rules = array(
			        'username' => array('required'),
			        'firstname' => array('required'),
			        'lastname' => array('required'),
			        'country' => array('required'),
			        'email' => array('required', 'email'),
			        'password' => array('required'),
			        'passwordagain' => array('required', 'same:password')
			);
			
			$validation = Validator::make(Input::all(), $rules);
			
			if($validation->fails()) {
				// Problem so show the user error messages
				return Redirect::to('user/register')->withInput()->withErrors($validation);
			}else{
				// Start working on this data
				$data['username'] = Input::get('username');
				$data['firstname'] = Input::get('firstname');
				$data['lastname'] = Input::get('lastname');
				$data['country'] = Input::get('country');
				$data['email'] = Input::get('email');
				$data['password'] = Input::get('password');
				
				$user = new User;
				$success = $user->register($data);
				
				if($success == true){
					// Insertion was succesfull, send an email with the activation
					//Mail::send('user/emails/activation', array($username, $registrationCode), function($message){
					//	$message->to($email, $firstname.$lastname)->subject('Welcome to coachCenter, please verify your account!');
					//});
					
					echo 'Welcome to coachcenter! We have sent you an email to activate your account.';
					return;
				}else{
					// Something went wrong
					echo 'Something went wrong, please try again later';
					return;
				}
			}
    	}else{
	    	// Show the form
	    	return View::make('user/register');
    	}		
	}
	
	function activate($username, $registrationcode){
		$user = new User;
		if($user->activate($username, $registrationcode)){
					echo 'Account activated!';
		}
	}
	
	function passwordforgot(){
		if(Request::isMethod('post')){
			// Work On the Form
			$rules = array(
			        'email' => array('required', 'email')
			);
			
			$validation = Validator::make(Input::all(), $rules);
			
			if($validation->fails()) {
				// Problem so show the user error messages
				return Redirect::to('user/passwordforgot')->withInput()->withErrors($validation);
			}else{
				// Start working on this data
				$email = Input::get('email');
				$newPassword = str_random(10);
				
				$user = new User;
				if($user->passwordforgot($email, $newPassword)){		
					// Send an email to the user
					//Mail::send('user/emails/passwordforgot', array($newPassword), function($message){
					//	$message->to($result, $results[0]->firstname.$results[0]->lastname)->subject('We have resetted your password!');
					//});
					
					echo 'We have sent you an email with your new password';
					return;
				}
			}
    	}else{
	    	// Show the form
	    	return View::make('user/passwordforgot');
    	}		
	}
	
	function logout(){
		$user = new User;
		$user->logout();
		
		echo 'You\'re now logged out!';
	}

}
