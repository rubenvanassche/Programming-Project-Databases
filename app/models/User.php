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
	
	function loginFacebookUser($id, $firstname, $lastname, $email, $username){
		// Does this user exists
		$result = DB::select("SELECT COUNT(id) as count FROM user WHERE facebookid = ?", array($id));
		if($result[0]->count == 0){
			// User doesn't exists
			
			DB::insert('INSERT INTO user (firstname, lastname, facebookid, email, username) VALUES (?,?,?,?,?)', array($firstname, $lastname, $id, $email, $username));
			
			$result = DB::select('SELECT id FROM user WHERE facebookid = ?', array($id));
			Session::put('userID', $result[0]->id);
			Session::put('userEntrance', time());
		}else{
			$result = DB::select('SELECT id FROM user WHERE facebookid = ?', array($id));
			Session::put('userID', $result[0]->id);
			Session::put('userEntrance', time());
		}
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
	
	function newUserGroup($name){
		$result = DB::select("SELECT COUNT(id) AS count FROM userGroup WHERE name = ?", array($name));
		if($result[0]->count == 0){
			DB::insert("INSERT INTO userGroup (name) VALUES (?)", array($name));
			return true;
		}else{
			return false;
		}
	}
	
	function addUserToUserGroup($userGroupID, $userID){
		DB::insert("INSERT INTO userPerUserGroup (user_id, userGroup_id) VALUES (?, ?)", array($userID, $userGroupID));
	}
	
	function getUsersByGroup($userGroupID){
		$result = DB::select("SELECT (SELECT username FROM user WHERE id = userPerUserGroup.user_id) as username FROM userPerUserGroup WHERE userGroup_id = ?", array($userGroupID));
		return $result;
	}
	
	function getUserGroupName($userGroupID){
		$result = DB::select("SELECT name FROM userGroup WHERE id = ?", array($userGroupID));
		return $result[0]->name;
	}
	
	function getUserGroups(){
		$result = DB::select('SELECT * FROM userGroup');
		return $result;
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

	function getNotifications() {
		if ($this->loggedIn()) {
			$id = $this->ID();
			$result = Notifications::getNotifications($id);
			return $result;
		}
		else {
			return array();
		}
	}
	
	function inviteUserToGroup($group_id, $invitee_id) {
		// Check if 'I' am actually allowed to invite another user. Let's just say that you need to be a member of the group right now.
		if (UserGroup::isMember($this->ID(), $group_id)) {
			// All is good, we can proceed to invite our new potential member!
			$result = UserGroup::addUserGroupInvite($this->ID(), $group_id, $invitee_id);
			var_dump($result);
			Notifications::saveNotification($group_id, $invitee_id, $this->ID(), Notifications::INVITE_USER_GROUP);
			return true; // Everything went as expected
		}
		else {
			return false; // Something went wrong
			
		}
	}
	
	public static function getID($username) {
		$results = DB::select("SELECT id FROM user WHERE username = ?", array($username));
		return $results[0]->id;
	}
	
	function getMyGroups() {
		$results = DB::select('
		SELECT * 
		FROM userGroup ug
		INNER JOIN userPerUserGroup upug ON ug.id = upug.userGroup_id
		WHERE upug.user_id = ? ', array($this->ID()));
		
		return $results;
	}
	
	function getMyInvites() {
		$results = DB::select('
		SELECT * 
		FROM userGroup ug
		INNER JOIN userPerUserGroup upug ON ug.id = upug.userGroup_id
		WHERE upug.user_id = ? ', array($this->ID()));
	}
	
}
