<?php

class UserController extends BaseController {

	function index(){
		$user = new User;
		$user->loggedIn();
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
					return Redirect::to('/');
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

	function facebookLogin(){
		$application = array(
		    'appId' => '611155238979722',
		    'secret' => 'b9415e5f5a111335ab36f14ff1d6f92e'
		    );
		$permissions = 'publish_stream,email';
		$url_app = 'http://localhost:8000/user/facebooklogin';

		// getInstance
		FacebookConnect::getFacebook($application);

		$getUser = FacebookConnect::getUser($permissions, $url_app); // Return facebook User data
		$id = $getUser['user_profile']['id'];
		$firstname = $getUser['user_profile']['first_name'];
		$lastname = $getUser['user_profile']['last_name'];
		$email = $getUser['user_profile']['email'];
		$username = $getUser['user_profile']['username'];


		$user = new User;
		$user->loginFacebookUser($id, $firstname, $lastname, $email, $username);
		return Redirect::to('/');
	}

	function register(){
		if(Request::isMethod('post')){
			// Work On the Form
			$rules = array(
			        'username' => array('required'),
			        'firstname' => array('required'),
			        'lastname' => array('required'),
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
				$data['country_id'] = Input::get('country');
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
			$registerData['countries'] = Country::getCountryNames();
	    	return View::make('layouts.simple', $data)->nest('content', 'user.register', $registerData);
    	}
	}

	//Note that $presetValues if supplied should contain keys presetHome, presetAway and presetDate
	function bet(){
		/*TODO: Laravel probably provides a better way to fetch variables from a Match page after a bet page was pressed there than through $_GET
		They are passed through the URL now, maybe that can be circumvented too.
		If anyone knows how, please tell me (Jakob) or feel free to change it yourselves.
		Also note if one of the three parameters is provided (presetHome/Away/Date), all three should be.
		UPDATE: as this goes through modal now, URL is invisible for user */
		if (isset($_GET["presetHome"]))
			$presetValues = array("presetHome" =>  $_GET["presetHome"], "presetAway" => $_GET["presetAway"], "presetDate" => $_GET["presetDate"]);
		else
			$presetValues = array();

		// Work On the Form
		$rules = array(
		        'hometeam' => array('required'),
		        'awayteam' => array('required'),
		        'date' => array('required'),
		        'hometeamScore' => array('integer', 'between:0,100', 'required'),
		        'awayteamScore' => array('integer', 'between:0,100', 'required'),
		        'firstGoal' => array(),
		        'hometeamYellows' => array('integer', 'between:0,100'),
		        'hometeamReds' => array('integer', 'between:0,100'),
		        'awayteamYellows' => array('integer', 'between:0,100'),
		        'awayteamReds' => array('integer', 'between:0,100')
		);

		$validation = Validator::make(Input::all(), $rules);

		if($validation->fails()) {
			// Problem so show the user error messages
			$input = Input::all();//Get all the old input.
			$input['autoOpenModal'] = 'true';//Add the auto open indicator flag as an input.
			return Redirect::back()
				->withErrors($validation)
				->withInput($input);//Passing the old input and the flag.
			//return Redirect::to('user/bet')->withInput()->withErrors($validation);
		}else{
			// Start working on this data
			$hometeam = Input::get('hometeam');
			$awayteam = Input::get('awayteam');
			$date = Input::get('date');
			$hometeam_score = Input::get('hometeamScore');
			$awayteam_score = Input::get('awayteamScore');
			$firstGoal = Input::get('firstGoal');
			$hometeam_yellows = Input::get('hometeamYellows');
			$hometeam_reds = Input::get('hometeamReds');
			$awayteam_yellows = Input::get('awayteamYellows');
			$awayteam_reds = Input::get('awayteamReds');
			$hometeamIDs = Team::getIDsByName($hometeam);
			$awayteamIDs = Team::getIDsByName($awayteam);
			$hometeamID = $hometeamIDs[0]->id;
			$awayteamID = $awayteamIDs[0]->id;
			if ($firstGoal == "none")
				$firstGoal_id = NULL;
			if ($firstGoal == "home")
				$firstGoal_id = $hometeamID;
			if ($firstGoal == "away")
				$firstGoal_id = $awayteamID;
			//save blank guesses as -1 internally
			if ($hometeam_yellows == "")
				$hometeam_yellows = -1;
			if ($hometeam_reds == "")
				$hometeam_reds = -1;
			if ($awayteam_yellows == "")
				$awayteam_yellows = -1;
			if ($awayteam_reds == "")
				$awayteam_reds = -1;

			$match = Match::getMatchByTeamsAndDate($hometeamID, $awayteamID, $date);
			$user = new User;
			$now = date('y-m-d h:i:s', time());;
			$matchDateTime = new DateTime( $match->date);
			$matchDateTime = $matchDateTime->format("y-m-d h:i:s");
			//Only add if match exists, user is logged in and match is in the future
			//Note that this function should not be called otherwise, this check might be unneeded
			$success = ($match != NULL) && $user->loggedIn() && $now < $matchDateTime;
			if($success == true){
				Bet:: add($match->id, $user->ID(), $hometeam_score, $awayteam_score, $firstGoal_id, $hometeam_yellows, $hometeam_reds, $awayteam_yellows, $awayteam_reds);
				$data['content'] = 'Thank you for filling in your bet.';
				$data['title'] = 'Bet registered!';
				$acceptedInput = array("accepted" => true); //Add the bet accepted indicator flag as an input.
				return Redirect::back()->withInput($acceptedInput);//Go back to match page
			}else{
				// Something went wrong (shouldn't happen)
				return Redirect::to('user/bet')->withInput();
			}
    	}
	}

	function betmodal(){
		$data['title'] = 'Bet';
		//Propagate the presets if given
		if (isset($_GET["presetHome"]))
			$presetValues = array("presetHome" =>  $_GET["presetHome"], "presetAway" => $_GET["presetAway"], "presetDate" => $_GET["presetDate"]);
		else
			$presetValues = array();
		return View::make('layouts.modal', $data)->nest('content', 'user.bet', $presetValues);
	}


	function showBets() {
		return View::make('layouts.simple', $data)->nest('content', 'user.bets');
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
			        'age' => array('numeric', 'between:1,99'),
			);

			$validation = Validator::make(Input::all(), $rules);

			if($validation->fails()) {
				// Problem so show the user error messages
				return Redirect::to('user/account')->withInput()->withErrors($validation);
			}else{
				// Start working on this data
				$data['firstname'] = Input::get('firstname');
				$data['lastname'] = Input::get('lastname');
				$data['country'] = Input::get('country');
				$data['email'] = Input::get('email');
				$data['about'] = Input::get('about');
				$data['age'] = Input::get('age');

				$user = new User;


				// Check if email is unique
				$onlyOneEmail = $user->onlyOneEmail($data['email']);
				if($onlyOneEmail != true){
					if($onlyOneEmail != $user->ID()){
						Notification::error("This email adress is already in our system, choose another one ");
						return Redirect::to('user/account')->withInput();
					}
				}


				foreach($data as $field => $value){
					$user->change($user->ID(), $field, $value);
				}

				return Redirect::to('user/account')->withInput();
			}
    	}else{
	    	// Show the form
	    	$data['title'] = 'Account';
	    	$data['countries'] = Country::getCountryNames();
	    	$user = new User;
	    	$data['user'] = $user->get($user->ID());
	    	return View::make('layouts.simple', $data)->nest('content', 'user.account', $data);
    	}
	}

	function changepassword(){
		if(Request::isMethod('post')){
			// Work On the Form
			$rules = array(
			        'password' => array('required'),
			        'passwordagain' => array('required', 'same:password')
			);

			$validation = Validator::make(Input::all(), $rules);

			if($validation->fails()){
				// Problem so show the user error messages
				return Redirect::to('user/changepassword')->withInput()->withErrors($validation);
			}else{
				// Start working on this data
				$data['password'] = Input::get('password');

				$user = new User;

				if($user->change($user->ID(), 'password', $data['password'])){
					$user->logout();

					$data['content'] = 'Please login again with your new password.';
					$data['title'] = 'Password changed!';
					return View::make('layouts.simple', $data);
				}else{
					// Something went wrong
					return Redirect::to('user/changepassword')->withInput();
				}
			}
    	}else{
	    	// Show the form
	    	$data['title'] = 'Change Password';
	    	return View::make('layouts.simple', $data)->nest('content', 'user.changepassword');
    	}
	}
	
	function changeprofilepicture(){
		$user = new User;
		if($user->facebookOnlyUser($user->ID()) == false){
			if(Request::isMethod('post')){
				$rules = array(
			        'image' => array('required')
			    );

				$validation = Validator::make(Input::all(), $rules);
			
				if ($validation->passes()) {
	
				   // Get the image input
				   $file = Input::file('image');
				
				   $destinationPath    = 'public/profilepictures/';
				   $filename           = $file->getClientOriginalName();
				   $mime_type          = $file->getMimeType(); 
				   $size 			   = $file->getSize();
				   $extension          = $file->getClientOriginalExtension(); 
				   				
				   // This is were you would store the image path in a table
				
				   if($size > 1048576){
				   		Notification::error("The image size is over 1mb.");
					   return Redirect::back()->withErrors($validation);
				   }
				   
				   $type = strtolower($extension);
				   
				   if($type == 'jpg' or $type == 'jpeg' or $type == 'png' or $type == 'gif'){
					   	// Success
					   	$filename = 'user'.$user->ID().'.'.$extension;
					   	
					   	$file->move(base_path().'/'.$destinationPath, $filename);
					   	$url = url('profilepictures/'.$filename);
						$user->changeProfilePicture($user->ID(), $url);
						
						return Redirect::to('profile/'.$user->ID());
				   }else{
				   	   Notification::error("The image size is not the right format(jpg, png, gif).");
					   return Redirect::back()->withErrors($validation);   
				   }
				} else {
				   return Redirect::back()->withErrors($validation)->withInput();
				}
			}else{
				// Show the form
				$data['title'] = 'Change Profile Picture';
				return View::make('layouts.simple', $data)->nest('content', 'user.changeprofilepicture');
			}
		}else{
			$data['title'] = 'Nothing to see over here';
			$data['content'] = 'We are using your Facebook profile picture.';
			return View::make('layouts.simple', $data);	
		}
	}

	function logout(){
		$user = new User;
		$user->logout();

		$data['title'] = 'Logged Out!';
		$data['content'] = 'Enjoy the rest of the world wide web.';
		return View::make('layouts.simple', $data);
	}

	function myProfile() {
		$user = new User;
		$usergroup = new Usergroup;
		$data['groups'] = $usergroup->getGroupsByUser($user->ID());
		$data['user'] = $user->get($user->ID());
		$data['notifications'] = $user->getNotifications($user->ID());
		$data['invites'] = $usergroup->getMyInvites();
		$data['profilepicture'] = $user->getPicture($user->ID());
		$data['text'] = "Hey! Welcome to my awesome profile. I'm not a huge football fan but when if I should take sides... MAUVE-WIT. AAAIGHT.";
		return View::make('user.myProfile', $data)->with('title', $data['user']->username);
	}

	function profile($id) {
		$user = new User;
		$usergroup = new Usergroup;
		$data['groups'] = $usergroup->getGroupsByUser($id);
		$data['user'] = $user->get($id);
		$data['avatar'] = NULL;
		$data['text'] = "This is a public profile yo. Watch out before I start throwing pizzas around.";
		return View::make('user.profile', $data)->with('title', $data['user']->username);
	}

	function userOverview() {
		$user = new User;
		$data['users'] = $user->getAllUsers();
		return View::make('user.userOverview', $data)->with('title', 'users');
	}

	function editProfile(){
			$aboutme = Input::get('aboutme');

			$user = new User;
			DB::update('UPDATE user SET about = ? WHERE id = ?', array($aboutme, $user->ID()));

			$data['content'] = 'Thank you for personalizing your profile.';
			$data['title'] = 'Update profile!';
			$acceptedInput = array("accepted" => true);
			return Redirect::back()->withInput($acceptedInput);//Go back to match page
	}
}
