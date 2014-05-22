<?php

class UsergroupController extends BaseController {

	function index(){
		$usergroup = new UserGroup;
		$data['groups'] = $usergroup->getGroups();
		$data['title'] = 'User Groups';

		return View::make('usergroup.all', $data);
	}

	function add(){
		if(Request::isMethod('post')){
			// Work On the Form
			$rules = array(
			        'name' => array('required'),
			);

			$validation = Validator::make(Input::all(), $rules);

			if($validation->fails()) {
				// Problem so show the user error messages
				return Redirect::to('usergroups/new')->withInput()->withErrors($validation);
			}else{
				// Start working on this data
				$name = Input::get('name');

				$user = new User;
				$usergroup = new UserGroup;
				$success = $usergroup->addGroup($name);

				if($success){
					// Add founder of the group to the group instantly.
					$this->addMe(UserGroup::ID($name));

					return Redirect::to('usergroups');
				}else{
					$data['title'] = 'There is already A User Group with this name';
					$data['content'] = 'Please choose another one.';
					return View::make('layouts.simple', $data);
				}
			}
    	}else{
	    	// Show the form
	    	$data['title'] = 'New User Group';
	    	return View::make('layouts.simple', $data)->nest('content', 'usergroup.add');
    	}
	}

	function usergroup($id){
		$usergroup = new UserGroup;
		$data['users'] = $usergroup->getUsers($id);
		$data['title'] = $usergroup->getName($id);
		$data['id'] = $id;


		return View::make('usergroup.usergroup', $data);
	}

	function addMe($id){
		$usergroup = new UserGroup;
		$user = new user;

		if(!$usergroup->isMember($user->ID(), $id)){
			$usergroup->addUser($id, $user->ID());
			return Redirect::to('usergroup/'.$id);
		}else{
			$data['title'] = 'Problem';
			$data['content'] = 'You are not in this group.';
			return View::make('layouts.simple', $data);
		}
	}

	function inviteUser($usergroup_id){
		if(Request::isMethod('post')){
			// Work On the Form
			$rules = array(
			        'invitee_name' => array('required'),
			);

			$validation = Validator::make(Input::all(), $rules);

			if($validation->fails()) {
				// Problem so show the user error messages
				return Redirect::to('usergroups/'.$usergroup_id.'/invite')->withInput()->withErrors($validation);
			}else{
				// Start working on this data
				$invitee_name = Input::get('invitee_name');
				$user = new User;
				$invitee_id = $user->getID($invitee_name);

				if ($invitee_id == -1){
					$data['title'] = 'Problem';
					$data['content'] = 'This user doesn\'t exist.';
					return View::make('layouts.simple', $data);
				}else if ($user->ID() == $invitee_id){
					$data['title'] = 'Problem';
					$data['content'] = 'You are already part of this group.';
					return View::make('layouts.simple', $data);
				}else{
					$usergroup = new UserGroup();
					$usergroup->invite($user->ID(),$usergroup_id, $invitee_id);

					$data['title'] = 'User Invited!';
					$data['content'] = '<a href="'.url('usergroup/'.$usergroup_id).'">Click here</a> to go back to the usergroup.';
					return View::make('layouts.simple', $data);
				}
			}
    	}else{
	    	// Show the form
	    	$usergroup = new UserGroup;

	    	$data['title'] = 'Invite User To '.$usergroup->getName($usergroup_id);
	    	$data['usergroup_id'] = $usergroup_id;

	    	return View::make('layouts.simple', $data)->nest('content', 'usergroup.invite', $data);
    	}
	}

	function leave($id){
		$usergroup = new UserGroup;
		$user = new user;

		if($usergroup->isMember($user->ID(), $id)){
			$usergroup->leave($user->ID(), $id);

			$data['title'] = 'Success';
			$data['content'] = 'You are not in this group anymore.';
			return View::make('layouts.simple', $data);
		}else{
			$data['title'] = 'Problem';
			$data['content'] = 'You are not in this group.';
			return View::make('layouts.simple', $data);
		}
	}

	function acceptInvite($notif_id, $ug_id) {
		Usergroup::acceptInvite($notif_id, $ug_id);
		return Redirect::to('myProfile');
	}

	function declineInvite($notif_id) {
		Usergroup::declineInvite($notif_id);
		return Redirect::to('myProfile');
	}
}
