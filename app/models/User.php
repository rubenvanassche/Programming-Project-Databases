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

			// Check if someone has already this username
			$username = $this->getFacebookUsername($username);

			DB::insert('INSERT INTO user (firstname, lastname, facebookid, email, username, country_id) VALUES (?,?,?,?,?,\'20\')', array($firstname, $lastname, $id, $email, $username));

			$result = DB::select('SELECT id FROM user WHERE facebookid = ?', array($id));
			Session::put('userID', $result[0]->id);
			Session::put('userEntrance', time());
		}else{
			$result = DB::select('SELECT id FROM user WHERE facebookid = ?', array($id));
			Session::put('userID', $result[0]->id);
			Session::put('userEntrance', time());
		}
	}

	// Checks in the database if there is already auser with this username, if so: return another one
	function getFacebookUsername($username){
		$result = DB::select("SELECT COUNT(id) as count FROM user WHERE username = ?", array($username));
		if($result[0]->count == 0){
			// This username is not in the DB so continue
			return $username;
		}else{
			// Generate another username
			$counter = 1;
			while(true){
				$newusername = $username.$counter;
				$result = DB::select("SELECT COUNT(id) as count FROM user WHERE username = ?", array($newusername));
				if($result[0]->count == 0){
					return $newusername;
				}else{
					$counter++;
					continue;
				}
			}
		}
	}

	function facebookOnlyUser($id){
		$result = DB::select("SELECT facebookid, password FROM user WHERE id = ?", array($id));
		if($result[0]->password == '' and !$result[0]->facebookid == ''){
			return true;
		}else{
			return false;
		}
	}

	function postToFacebook($title, $message, $link = '', $pictureUrl = ''){
		if($this->facebookOnlyUser($this->ID())){
			// Make connection with Facebook
			$application = array(
		   	 'appId' => '611155238979722',
		   	 'secret' => 'b9415e5f5a111335ab36f14ff1d6f92e'
			);

			FacebookConnect::getFacebook($application);
			$permissions = 'publish_stream,email';
			$url_app = 'http://localhost:8000/user/facebooklogin';
			$getUser = FacebookConnect::getUser($permissions, $url_app);

			if($link == ''){
				$link = 'http://www.coachcenter.net';
			}

			if($pictureUrl == ''){
				$pictureUrl = 'http://coachcenter.net/favicon.ico';
			}

			$messageX = array(
			    'link'    => $link,
			    'message' => $message,
			    'picture'   => $pictureUrl,
			    'name'    => $title,
			    'description' => 'Coachcenter',
			    'access_token' => $getUser['access_token'] // form FacebookConnect::getUser();
			    );

		    // and ... post
			FacebookConnect::postToFacebook($messageX, 'feed');

			return true;
		}else{
			return false;
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

		$result = DB::insert("INSERT INTO user (username, firstname, lastname, email, password, country_id, registrationcode) VALUES (?, ?, ?, ?, ?, ?, ?)",
		array($data['username'],
			$data['firstname'],
			$data['lastname'],
			$data['email'],
			$data['password'],
			$data['country_id'],
			$data['registrationcode']));

		//Send email
		$message = new stdClass();
		$user_email = $data['email'];
		$username = $data['username'];
		Mail::send('mails.register', $data, function($message) use ($user_email, $username){
    	$message->to($user_email, $username)->subject("Welcome to Coach Center: email address validation");
		});

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

		// generate the new password
		$newPasswordHashed = Hash::make($newPassword);

		DB::Update("UPDATE user SET password = ? WHERE id = ?", array($newPasswordHashed, $results[0]->id));

		return true;
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

	function getAllUsers() {
		$results = DB::select('SELECT * FROM user');
		return $results;
	}

	function changePassword($userID, $password) {
		$password = Hash::make($password);
		$results = DB::update("UPDATE user SET password = ? WHERE id = ?", array($password, $userID) );
		return $results;
	}

	function change($userID, $values){
		$results = DB::update("UPDATE user SET firstname = ?, lastname = ?, email = ?, 
								               country_id = ?, about = ?, age = ? WHERE id = ?", 
								array($values['firstname'], $values['lastname'], $values['email'], 
									  $values['country_id'], $values['about'], $values['age'], $userID) );

		return $results;
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
			$result = UserGroup::addUserGroupInvite($invitee_id, $group_id, $this->ID());
			Notifications::saveNotification($group_id, $invitee_id, $this->ID(), Notifications::INVITE_USER_GROUP);
			return true; // Everything went as expected
		}
		else {
			return false; // Something went wrong

		}
	}

	public static function getID($username) {
		$results = DB::select("SELECT id FROM user WHERE username = ?", array($username));
		if (count($results) == 0) {
			return -1;
		}
		else {
			return $results[0]->id;
		}
	}
	
	public static function getNameFromEmail($email) {
		$results = DB::select("SELECT username FROM user WHERE email = ?", array($email));
		if (empty($results))
			return "";
		return $results[0]->username;
	}

	public static function changeProfilePicture($id, $url){
		DB::update("UPDATE user SET picture = ? WHERE id = ?",array($url, $id));
	}

	public function getPicture($id){
		if($this->facebookOnlyUser($id) == false){
			$result = DB::select("SELECT picture FROM user WHERE id = ?", array($id));
			return $result[0]->picture;
		}else{
			$result = DB::select("SELECT facebookid FROM user WHERE id = ?", array($id));
			$facebookid = $result[0]->facebookid;

			return 'https://graph.facebook.com/'.$facebookid.'/picture?type=large';
		}
	}

	public static function getEmailUsers() {
		// Returns all users who want to be emailed.
		$result = DB::select("SELECT * FROM user WHERE `recieve_email` = 1");
		return $result;
	}

}
