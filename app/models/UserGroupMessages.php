<?php
class UserGroupMessages {
	function getAll($usergroup_id){
		$result = DB::select("SELECT created, id, title, (SELECT username FROM user WHERE id = UserGroupMessages.user_id) as username FROM UserGroupMessages WHERE usergroup_id = ? SORT BY created ASC", array($usergroup_id));
		
		return $result;
	}
	
	function getMessageHeader($message_id){
		$result = DB::select("SELECT created, title, (SELECT username FROM user WHERE id = UserGroupMessages.user_id) as username FROM UserGroupMessages WHERE id = ?", array($message_id));
		$result = $result[0];
		return $result;
	}
	
	function getMessageContent($message_id){
		$result = DB::select("SELECT created, content,(SELECT username FROM user WHERE id = UserGroupMessagesContent.user_id) as username FROM UserGroupMessagesContent WHERE message_id = ? SORT BY created ASC", array($message_id));
		return $result;
	}
}
