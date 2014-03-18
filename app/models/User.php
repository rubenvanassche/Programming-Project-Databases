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
			Session::put('userEntrance', time());
			return true;
		}
	}
	
	function ID(){
		return Session::get('userID');
	}
	
	
	function login($username, $password){
		$results = DB::select('SELECT password, registrationcode, id FROM user WHERE username = ?', array($username));
				
		if(empty($results)){
			// Username not found
			Notification::error('Username is invalid!');
			return false;
		}
		
		if(!Hash::check($password, $results[0]->password)){
			Notification::error('Password is incorrect!');
			return false;
		}
		
		if(strlen($results[0]->registrationcode) != 0){
			Notification::error('Email address hasn\'t been validated!');
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
			Notification::error('Username already taken!');
			return false;
		}
		
		$results = DB::select('SELECT id FROM user WHERE email = ?', array($data['email']));
		if(!empty($results)){
			// email found
			Notification::error('Email address already tied to an account!');
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
			Notification::error('Something went wrong, please try again later');
			return false;
		}
	}
	
	function activate($username, $registrationcode){
		$results = DB::Select("Select id, registrationcode FROM user WHERE username = ? ", array($username));
		
		if(empty($results)){
			Notification::errorInstant('Something went wrong!');  //Does this occur when the username is invalid? if so, change error accordingly
			return false;
		}
		
		if(strlen($results[0]->registrationcode) == 0){
			Notification::errorInstant('This account has already been activated!');
			return false;
		}
		
		if($results[0]->registrationcode != $registrationcode){
			Notification::errorInstant('Activation code is invalid!');
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
			Notification::error('There is no account tied to this email address!');
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
	
	
	function get($userID){
			$results = DB::select('SELECT * FROM user WHERE id = ?', array($userID));
			return $results[0];
	}
	
	function change($userID, $field, $value){
		if($field == 'password'){
			$value = Hash::make($value);
		}
		
		$field = mysql_real_escape_string($field);
		$results = DB::update("UPDATE user SET $field = ? WHERE id = ?", array($value, $userID) );
		
		if($results == 1){
			return true;
		}else{
			return false;
		}
	}
	
	function onlyOneEmail($email){
		$results = DB::select("SELECT id, COUNT(id) AS count FROM user WHERE email = ?", array($email));
		
		if($results[0]->count > 0){
			// Return the id of the one with this email adress
			if($this->ID() == $results[0]->id){
				return true;
			}else{
				return false;
			}
		}else{
			return true;
		}
	}
}
