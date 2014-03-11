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
				$username = Input::get('username');
				$firstname = Input::get('firstname');
				$lastname = Input::get('lastname');
				$country = Input::get('country');
				$email = Input::get('email');
				$password = Input::get('password');
				
				$results = DB::select('SELECT id FROM user WHERE username = ?', array($username));
				if(!empty($results)){
					// Username  found
					echo 'Username already exists exsist!';
					return;
				}
				
				$results = DB::select('SELECT id FROM user WHERE email = ?', array($email));
				if(!empty($results)){
					// email found
					echo 'Email Adress already exists exsist!';
					return;
				}
				
				// Seems like we're ready to add this new user
				$registrationCode = str_random(24);
				$password = Hash::make($password);
				
				$result = DB::Insert("INSERT INTO user (username, firstname, lastname, email, password, country, registrationcode) VALUES ('$username', '$firstname','$lastname','$email', '$password', '$country', '$registrationCode')");
				
				if($result == 1){
					// Insertion was succesfull, send an email with the activation
					//Mail::send('user/emails/activation', array($username, $registrationCode), function($message){
					//	$message->to($email, $firstname.$lastname)->subject('Welcome to coachCenter, please verify your account!');
					//});
					
					echo 'Welcome to coachcenter! We have sent you an email to activate your account.';
					return;
				}else{
					// Something went wrong
					echo 'There went something wrong, please try again later';
					return;
				}
			}
    	}else{
	    	// Show the form
	    	return View::make('user/register');
    	}		
	}
	
	function activate($username, $registrationcode){
		$results = DB::Select("Select id, registrationcode FROM user WHERE username = ? ", array($username));
		
		if(empty($results)){
			echo 'There went something wrong!';
			return;
		}
		
		if(strlen($results[0]->registrationcode) == 0){
			echo 'You\'re account is already activated!';
			return;
		}
		
		if($results[0]->registrationcode != $registrationcode){
			echo 'You\'re activation code is wrong!';
			return;
		}
		
		// Okay we're ready to remove the activation code
		DB::Update("UPDATE user SET registrationcode = '' WHERE username = ?", array($username));
		echo 'Account activated!';
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
				$results = DB::select('SELECT id, firstname, lastname FROM user WHERE email = ?', array($email));
				
				if(empty($results)){
					// Username not found
					echo 'There is no account with this email adress!';
					return;
				}
				
				// generate the enw password
				$newPassword = str_random(10);
				$newPasswordHashed = Hash::make($newPassword);
				
				DB::Update("UPDATE user SET password = ? WHERE id = ?", array($newPasswordHashed, $results[0]->id));
				
				// Send an email to the user
				//Mail::send('user/emails/passwordforgot', array($newPassword), function($message){
				//	$message->to($result, $results[0]->firstname.$results[0]->lastname)->subject('We have resetted your password!');
				//});
				
				echo 'We have sent you an email with your new password';
				return;
			}
    	}else{
	    	// Show the form
	    	return View::make('user/passwordforgot');
    	}		
	}

}