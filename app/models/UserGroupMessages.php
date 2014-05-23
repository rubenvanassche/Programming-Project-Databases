<?php
class UserGroupMessages {
	function getAll($usergroup_id){
		$result = DB::select("SELECT created, id, title, (SELECT username FROM user WHERE id = UserGroupMessages.user_id) as username, (SELECT COUNT(id) as count FROM UserGroupMessagesContent WHERE message_id = UserGroupMessages.id) as count FROM UserGroupMessages WHERE usergroup_id = ? ORDER BY created DESC", array($usergroup_id));
		
		return $result;
	}
	
	function getDiscussionHeader($discussion_id){
		$result = DB::select("SELECT created, title, (SELECT username FROM user WHERE id = UserGroupMessages.user_id) as username FROM UserGroupMessages WHERE id = ?", array($discussion_id));
		$result = $result[0];
		return $result;
	}
	
	function getDiscussionContent($discussion_id){
		$result = DB::select("SELECT created, content,(SELECT username FROM user WHERE id = UserGroupMessagesContent.user_id) as username, user_id FROM UserGroupMessagesContent WHERE message_id = ? ORDER BY created ASC", array($discussion_id));
		return $result;
	}
	
	function addDiscussion($title, $content, $usergroup_id){
		$user = new User;
		$userID = $user->ID();
		$date = date('Y-m-d h:i:s');
		
		DB::insert("INSERT INTO UserGroupMessages (usergroup_id, user_id, title, created) VALUES (?,?,?,?)", array($usergroup_id, $userID, $title, $date));
		
		// get the id of this message
		$result = DB::select("SELECT id FROM UserGroupMessages WHERE usergroup_id = ? AND user_id = ? AND title = ? AND created = ?", array($usergroup_id, $userID, $title, $date));
		$discussion_id = $result[0]->id;
		
		DB::insert('INSERT INTO UserGroupMessagesContent (user_id, message_id, content, created) VALUES (?,?,?,?)', array($userID, $discussion_id, $content, $date));
		
		return $discussion_id;
	}
	
	function addMessage($content, $usergroup_id, $discussion_id){
		$user = new User;
		$userID = $user->ID();
		$date = date('Y-m-d h:i:s');
		
		DB::insert('INSERT INTO UserGroupMessagesContent (user_id, message_id, content, created) VALUES (?,?,?,?)', array($userID, $discussion_id, $content, $date));
	}
}
