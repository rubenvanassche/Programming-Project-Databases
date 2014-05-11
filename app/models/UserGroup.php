<?php

class UserGroup {
	public static function isMember($user_id, $userGroup_id) {
		$result = DB::select('SELECT * FROM userPerUserGroup WHERE user_id = ? AND userGroup_id = ?', array($user_id, $userGroup_id));
		return $result;
	}
	
	public static function ID($name) {
		$result = DB::select("SELECT id FROM userGroup WHERE name = ?", array($name));
		return $result[0]->id;
	}
	
	public static function addUserGroupInvite($user_id, $competition_id, $invitedBy_id) {
		$query = "INSERT INTO `userGroupInvites` (userId, competitionId, invitedById) VALUES (?, ?, ?)";
        $values = array($user_id, $competition_id, $invitedBy_id);
        DB::insert( $query, $values );
   } 
}
