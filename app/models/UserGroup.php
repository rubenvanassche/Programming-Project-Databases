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
	
	public static function invite($user_id, $userGroup_id, $invitedBy_id) {
		$query = "INSERT INTO `userGroupInvites` (userId, usergroupId, invitedById) VALUES (?, ?, ?)";
        $values = array($user_id, $userGroup_id, $invitedBy_id);
        DB::insert( $query, $values );
   }

   function addGroup($name, $privateSettings = 0){
		$result = DB::select("SELECT COUNT(id) AS count FROM userGroup WHERE name = ?", array($name));
		if($result[0]->count == 0){
			DB::insert("INSERT INTO userGroup (name, private) VALUES (?, ?)", array($name, $privateSettings));
			return true;
		}else{
			return false;
		}
	}
	
	function addUser($userGroupID, $userID){
		DB::insert("INSERT INTO userPerUserGroup (user_id, userGroup_id) VALUES (?, ?)", array($userID, $userGroupID));
	}

	function getUsers($userGroupID){
		$result = DB::select("SELECT (SELECT username FROM user WHERE id = userPerUserGroup.user_id) as username, (SELECT id FROM user WHERE id = userPerUserGroup.user_id) as id  FROM userPerUserGroup WHERE userGroup_id = ?", array($userGroupID));
		return $result;
	}

	function getName($userGroupID){
		$result = DB::select("SELECT name FROM userGroup WHERE id = ?", array($userGroupID));
		return $result[0]->name;
	}

	function getGroups(){
		$result = DB::select('SELECT * FROM userGroup');
		$user = new User();
		
		foreach ($result as $r) {
			$v = $this->isMember($user->ID(), $r->id);
			if (count($v) > 0) {
				$r->ismember = true;
			}
			else {
				$r->ismember = false;
			}
		}

		return $result;
	}
	
	function getMyInvites() {
		$user = new User();
	
		$results = DB::select("
		SELECT ug.name, inviter.username, notif.created_date, notif.id AS notif_id, ug.id AS ug_id
		FROM notifications notif
		INNER JOIN userGroup ug ON notif.object_id = ug.id
		INNER JOIN user inviter ON notif.actor_id = inviter.id
		WHERE notif.subject_id = ?
		AND notif.status = 'unseen'", array($user->ID()));

		return $results;
	}

	public static function acceptInvite($notif_id, $ug_id) {
		// Mark notification as seen.
		DB::update("UPDATE notifications notif SET status = 'accepted' WHERE notif.id = ?", array($notif_id));

		// Add the user to the group.
		$this->addUser($ug_id, $user->ID());

	}

	public static function declineInvite($notif_id) {
		// Mark notification as seen.
		DB::update("UPDATE notifications notif SET status = 'declined' WHERE notif.id = ?", array($notif_id));
	}
	
	function getGroupsByUser($id) {
		$results = DB::select('
		SELECT *
		FROM userGroup ug
		INNER JOIN userPerUserGroup upug ON ug.id = upug.userGroup_id
		WHERE upug.user_id = ? ', array($id));

		$user = new User();

		foreach ($results as $r) {
			$v = UserGroup::isMember($id, $r->id);
			if (count($v) > 0) {
				$r->ismember = true;
			}
			else {
				$r->ismember = false;
			}
		}

		return $results;
	}

	function leave($user_id, $userGroup_id){
		DB::delete("DELETE FROM userPerUserGroup WHERE user_id = ? AND userGroup_id = ?", array($user_id, $userGroup_id));
	}
}
