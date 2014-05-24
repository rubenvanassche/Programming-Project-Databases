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
				$input = Input::all();//Get all the old input.
				$input['autoOpenLoginModal'] = 'true';//Add the auto open indicator flag as an input.
				return Redirect::back()
					->withErrors($validation)
					->withInput($input);//Passing the old input and the flag.
			}else{
				// Start working on this data
				$username = Input::get('username');
				$password = Input::get('password');

				$user = new User;
				if($user->login($username, $password)){
					// Logged in
					return Redirect::back();
				}else{
				$input = Input::all();//Get all the old input.
				$input['autoOpenLoginModal'] = 'true';//Add the auto open indicator flag as an input.
				return Redirect::back()
					->withErrors($validation)
					->withInput($input);//Passing the old input and the flag.
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
		$url_app = url('user/facebooklogin');

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


					$data['content'] = 'Welcome to coachcenter! We have sent you an email to activate your account (check your spambox!).';
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
					//Send email
					$message = new stdClass();
					$username = User::getNameFromEmail($email);
					$data['username'] = $username;
					$data['password'] = $newPassword;
					Mail::send('mails.reset', $data, function($message) use ($email, $username){
					$message->to($email, $username)->subject("Coach Center: password reset");
					});
					$data['title'] = 'Password Recovery';
					$data['content'] = 'Your password was reset, we have sent an email with your new password.';
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
		$user = new User;
		if (!$user->loggedIn()) {
	    	$data['title'] = 'Not logged in';
	        return View::make('layouts.simple', $data)->nest('content', 'user.nologin', $data);
		}
		if(Request::isMethod('post')){
			// Work On the Form
			$rules = array(
			        'firstname' => array('required'),
			        'lastname' => array('required'),
			        'country' => array('required'),
			        'email' => array('required', 'email'),
			        'age' => array('numeric', 'between:1,120'),
			        'about' => array('digits_between:0,1024'),
			);

			$validation = Validator::make(Input::all(), $rules);

			if($validation->fails()) {
				// Problem so show the user error messages
				return Redirect::to('user/account')->withInput()->withErrors($validation);
			}else{
				// Start working on this data
				$data['firstname'] = Input::get('firstname');
				$data['lastname'] = Input::get('lastname');
				$data['country_id'] = Input::get('country');
				$data['email'] = Input::get('email');
				$data['about'] = Input::get('about');
				$data['age'] = Input::get('age');


				// Check if email is unique
				$onlyOneEmail = $user->onlyOneEmail($data['email']);
				if($onlyOneEmail != true){
					if($onlyOneEmail != $user->ID()){
						Notification::error("This email adress is already in our system, choose another one ");
						return Redirect::to('user/account')->withInput();
					}
				}

				$user->change($user->ID(), $data);

				return Redirect::to('user/account')->withInput();
			}
    	}else{
	    	// Show the form
	    	$data['title'] = 'Account';
	    	$data['countries'] = Country::getCountryNames();
	    	$data['user'] = $user->get($user->ID());
	    	return View::make('layouts.simple', $data)->nest('content', 'user.account', $data);
    	}
	}

	function changepassword(){
		$user = new User;
		if (!$user->loggedIn()) {
	    	$data['title'] = 'Not logged in';
	        return View::make('layouts.simple', $data)->nest('content', 'user.nologin', $data);
		}

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

				if($user->changePassword($user->ID(), $data['password'])){
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
		if (!$user->loggedIn()) {
	    	$data['title'] = 'Not logged in';
	        return View::make('layouts.simple', $data)->nest('content', 'user.nologin', $data);
		}

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

		//return Redirect::back()->withInput(array("loggedOut" => true));
		return Redirect::to('/')->withInput(array("loggedOut" => true));
	}

	public static function profile($id='') {
		$user = new User;

		$usergroup = new UserGroup;
		if($id == '' || $id == $user->ID()){
			$data['groups'] = $usergroup->getGroupsByUser($user->ID());
			$data['user'] = $user->get($user->ID());
			$data['profilepicture'] = $user->getPicture($user->ID());
			$data['personal'] = true;
			$data['notifications'] = $user->getNotifications($user->ID());
			$data['invites'] = $usergroup->getUsersInvites($user->ID());
		}else{
			$data['groups'] = $usergroup->getGroupsByUser($id);
			$data['user'] = $user->get($id);
			$data['profilepicture'] = $user->getPicture($id);
			$data['personal'] = false;
		}
		return View::make('user.profile', $data)->with('title', $data['user']->username);
	}

	function userOverview() {
		$user = new User;
		$data['users'] = $user->getAllUsers();
		return View::make('user.userOverview', $data)->with('title', 'users');
	}

public static function acceptInvite($notif_id, $ug_id) {
		$user = new User;
		$result1 = DB::select("SELECT subject_id, status FROM `notifications` WHERE id = ?", array($notif_id))[0];
		if ($result1->subject_id == $user->ID() && $result1->status == 'unseen') {
			UserGroup::acceptInvite($notif_id, $ug_id);
			UserGroup::addUser($ug_id, $user->ID());
		}
		return UsergroupController::usergroup($ug_id);
	}

	public static function declineInvite($notif_id) {
		UserGroup::declineInvite($notif_id);
		return UserController::profile();
	}
}
