<?php

class UsergroupMessagesController extends BaseController {

	function discussion($usergroup_id, $discussion_id){
		$ugm = new userGroupMessages;
		$header = $ugm->getDiscussionHeader($discussion_id);
		$content = $ugm->getDiscussionContent($discussion_id);
		
    	$data['title'] = $header->title;
    	$data['usergroup_id'] = $usergroup_id;
    	$data['hader'] = $header;
    	$data['content'] = $content;
    	$data['discussion_id'] = $discussion_id;
    	$data['userObj'] = new User;

    	return View::make('usergroup.discussion', $data);
	}
	
	function addDiscussion($usergroup_id){
		if(Request::isMethod('post')){
			// Work On the Form
			$rules = array(
			        'title' => array('required'),
			        'content' => array('required')
			);

			$validation = Validator::make(Input::all(), $rules);

			if($validation->fails()) {
				// Problem so show the user error messages
				return Redirect::to('usergroup/'.$usergroup_id.'/adddiscussion')->withInput()->withErrors($validation);
			}else{
				// Start working on this data
				$title = Input::get('title');
				$content = Input::get('content');
				
				$usergroupmessages = new userGroupMessages;
				$discussion_id = $usergroupmessages->addDiscussion($title, $content, $usergroup_id);
				
				return Redirect::to('usergroup/'.$usergroup_id.'/discussion/'.$discussion_id);
			}
    	}else{
	    	// Show the form
	    	$data['title'] = 'New Discussion';
	    	$data['usergroup_id'] = $usergroup_id;

	    	return View::make('layouts.simple', $data)->nest('content', 'usergroup.adddiscussion', $data);
    	}
	}
	
	function addMessage($usergroup_id, $discussion_id){
		if(Request::isMethod('post')){
			// Work On the Form
			$rules = array(
			        'content' => array('required')
			);

			$validation = Validator::make(Input::all(), $rules);

			if($validation->fails()) {
				// Problem so show the user error messages
				return Redirect::to('usergroup/'.$usergroup_id.'/disucssion/'.$discussion_id.'/add')->withInput()->withErrors($validation);
			}else{
				// Start working on this data
				$content = Input::get('content');
				
				$usergroupmessages = new userGroupMessages;
				$usergroupmessages->addMessage($content, $usergroup_id, $discussion_id);
				
				return Redirect::to('usergroup/'.$usergroup_id.'/discussion/'.$discussion_id);
			}
    	}else{
	    	// Show the form
	    	$data['title'] = 'New Message';
	    	$data['usergroup_id'] = $usergroup_id;
	    	$data['discussion_id'] = $discussion_id;

	    	return View::make('layouts.simple', $data)->nest('content', 'usergroup.addmessage', $data);
    	}		
	}
}
