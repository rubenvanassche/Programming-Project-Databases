<?php

class UserController extends BaseController {

	function index(){
		return;
	}

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
				if($user->login($username, $password)){
					// Logged in
					return Redirect::to('home');
				}else{
					return Redirect::to('user/login')->withInput();
				}
			}
    	}else{
	    	// Show the form
	    	$data['title'] = 'Login';
	    	return View::make('layouts.simple', $data)->nest('content', 'user.login');
    	}
	}
	
	function loginmodal(){
		$data['title'] = 'Login';
		return View::make('layouts.modal', $data)->nest('content', 'user.login');
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
					
					$data['content'] = 'Welcome to coachcenter! We have sent you an email to activate your account.';
					$data['title'] = 'Welcome!';
					return View::make('layouts.simple', $data);
				}else{
					// Something went wrong
					return Redirect::to('user/register')->withInput();
				}
			}
    	}else{
	    	// Show the form
	    	$data['title'] = 'Register';
	    	return View::make('layouts.simple', $data)->nest('content', 'user.register');
    	}		
	}
	
	function activate($username, $registrationcode){
		$user = new User;
		if($user->activate($username, $registrationcode)){
			$data['title'] = 'Account Activated!';
			$data['content'] = 'You are now a full member of coachcenter, login to start!';
			return View::make('layouts.simple', $data);
		}else{
			$data['title'] = 'Activation Error';
			$data['content'] = Notification::showAll();
			return View::make('layouts.simple', $data);
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
					
					Notification::success('We have sent you an email with your new password');
					return;
					$data['title'] = 'Password Recovery';
					$data['content'] = 'Your password was resetted, we have sent an email with your new password.';
					return View::make('layouts.simple', $data);
				}else{
					return Redirect::to('user/passwordforgot')->withInput();
				}
			}
    	}else{
	    	// Show the form
	    	$data['title'] = 'Recover Password';
	    	return View::make('layouts.simple', $data)->nest('content', 'user.passwordforgot');
    	}		
	}
	
	function account(){
		if(Request::isMethod('post')){
			// Work On the Form
			$rules = array(
			        'firstname' => array('required'),
			        'lastname' => array('required'),
			        'country' => array('required'),
			        'email' => array('required', 'email'),
			        'password' => array('required'),
			        'passwordagain' => array('required', 'same:password')
			);
			
			$validation = Validator::make(Input::all(), $rules);
			
			$user = new User;
			
			if($validation->fails()) {
				// Problem so show the user error messages
				return Redirect::to('user/account')->withInput()->withErrors($validation);
			}else{
				// Start working on this data
				$data['firstname'] = Input::get('firstname');
				$data['lastname'] = Input::get('lastname');
				$data['country'] = Input::get('country');
				$data['email'] = Input::get('email');
				
				// Check if email is unique
				if(!$user->unique($data['email'], 'email', $user->ID())){
					// Nope
					return Redirect::to('user/account')->withInput();
				}
				
				foreach($data as $field => $value){
					if(!$user->change($userID, $field, $value)){
						Notification::error("Couldn't change ". $field);
					}
				}
				
				Redirect::to('user/account')->withInput();
			}
    	}else{
	    	// Show the form
	    	$data['title'] = 'Account';
	    	return View::make('layouts.simple', $data)->nest('content', 'user.account');
    	}			
	}
	
	function changepassword(){
		echo 'hallo';
		/*$user = new User;
		$userID = Session::get('userID');
		if($user->unique('id', '48')){
			echo 'true';
		}else{
			echo 'false';
		}
		*/
		$user = new User;
		$user->change('48','firstname', 'jos');
	}
	
	function logout(){
		$user = new User;
		$user->logout();
		
		$data['title'] = 'Logged Out!';
		$data['content'] = 'Enjoy the rest of the world wide web.';
		return View::make('layouts.simple', $data);
	}

}
