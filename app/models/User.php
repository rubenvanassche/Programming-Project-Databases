<?php

class User {

	function loggedIn(){
		if(!Session::has('userEntrance')){
			// No user logged in
			return false;
		}
	
		$userEntrance = Session::get('userEntrance');
		
		if(time() > $userEntrance+7200){
			// User session is over
			Session::forget('userID');
			Session::forget('userEntrance');
			return false;
		}else{
			Session::push('userEntrance', time());
			return true;
		}
	}
	
	function login($username, $password){
		$results = DB::select('SELECT password, registrationcode, id FROM user WHERE username = ?', array($username));
				
		if(empty($results)){
			// Username not found
			Notification::error('This user doesn\'t exists!');
			return false;
		}
		
		if(!Hash::check($password, $results[0]->password)){
			Notification::error('The Password isn\'t correct!');
			return false;
		}
		
		if(strlen($results[0]->registrationcode) != 0){
			Notification::error('Your email adress hasn\'t been validated!');
			return false;
		}
		
		// Login was succesfull;
		Session::put('userID', $results[0]->id);
		Session::put('userEntrance', time());
		
		return true;
	}
	
	function register($data){
		$results = DB::select('SELECT id FROM user WHERE username = ?', array($data['username']));
		if(!empty($results)){
			// Username  found
			Notification::error('Username already exists exsists!');
			return false;
		}
		
		$results = DB::select('SELECT id FROM user WHERE email = ?', array($data['email']));
		if(!empty($results)){
			// email found
			Notification::error('Email Adress already exists exsists!');
			return false;
		}
		
		// Seems like we're ready to add this new user
		$data['registrationcode'] = str_random(24);
		$data['password'] = Hash::make($data['password']);
		
		$result = DB::insert("INSERT INTO user (username, firstname, lastname, email, password, country, registrationcode) VALUES (?, ?, ?, ?, ?, ?, ?)", 
		array($data['username'],
			$data['firstname'],
			$data['lastname'],
			$data['email'],
			$data['password'],
			$data['country'],
			$data['registrationcode']));
		
		if($result == 1){
			return true;
		}else{
			Notification::error('Something went wrong, please try again');
			return false;
		}
	}
	
	function activate($username, $registrationcode){
		$results = DB::Select("Select id, registrationcode FROM user WHERE username = ? ", array($username));
		
		if(empty($results)){
			Notification::errorInstant('Something went wrong!');
			return false;
		}
		
		if(strlen($results[0]->registrationcode) == 0){
			Notification::errorInstant('Your account is already activated!');
			return false;
		}
		
		if($results[0]->registrationcode != $registrationcode){
			Notification::errorInstant('Your activation code is wrong!');
			return false;
		}
		
		// Okay we're ready to remove the activation code
		$result = DB::Update("UPDATE user SET registrationcode = '' WHERE username = ?", array($username));
		
		if($result == 1){
			return true;
		}else{
			return false;
		}
	}
	
	function passwordforgot($email, $newPassword){
		$results = DB::select('SELECT id, firstname, lastname FROM user WHERE email = ?', array($email));
		
		if(empty($results)){
			// Username not found
			Notification::error('There is no account with this email address!');
			return false;
		}
		
		// generate the enw password
		$newPasswordHashed = Hash::make($newPassword);
		
		DB::Update("UPDATE user SET password = ? WHERE id = ?", array($newPasswordHashed, $results[0]->id));
		
		if($result == 1){
			return true;
		}else{
			return false;
		}
	}
	
	function logout(){
		Session::forget('userID');
		Session::forget('userEntrance');
		
		return true;
	}
}
