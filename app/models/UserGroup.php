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
		$query = "INSERT INTO `userGroupInvites` (userId, usergroupId, invitedById, created) VALUES (?, ?, ?, ?)";
        $values = array($user_id, $userGroup_id, $invitedBy_id, date('Y-m-d h:i:s'));
        DB::insert( $query, $values );
   }

   function addGroup($name, $privateSettings = 0){
		$result = DB::select("SELECT COUNT(id) AS count FROM userGroup WHERE name = ?", array($name));
		if($result[0]->count == 0){
			DB::insert("INSERT INTO userGroup (name, private, created) VALUES (?, ?, ?)", array($name, $privateSettings, date('Y-m-d h:i:s')));
			return true;
		}else{
			return false;
		}
	}

	function addUser($userGroupID, $userID){
		$date = date('Y-m-d h:i:s',strtotime(date('Y-m-d H:i:s')) + 2); // plus 2 seoncds for right display in timeline
		DB::insert("INSERT INTO userPerUserGroup (user_id, userGroup_id, created) VALUES (?, ?, ?)", array($userID, $userGroupID, $date));
	}

	function getUsers($userGroupID){
		$result = DB::select("SELECT (SELECT username FROM user WHERE id = userPerUserGroup.user_id) as username, (SELECT id FROM user WHERE id = userPerUserGroup.user_id) as id, created  FROM userPerUserGroup WHERE userGroup_id = ?", array($userGroupID));
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
	
	function getInvites($userGroup_id){
		$result = DB::select("SELECT 
		(SELECT username FROM user WHERE id = userGroupInvites.invitedById) as invitee,
		(SELECT username FROM user WHERE id = userGroupInvites.userId) as inviter,
		 created, invitedById, userId FROM userGroupInvites WHERE usergroupId = ?", array($userGroup_id));
		return $result;		
	}

	function getPastBets($userGroup_id) {
		$result = DB::select("SELECT match_id, betdate, user_id, (SELECT username FROM user WHERE user.id = bet.user_id) AS better FROM bet 
								WHERE EXISTS (SELECT user_id FROM userPerUserGroup 
											   WHERE userPerUserGroup.user_id = bet.user_id 
												 AND userGroup_id = ?)
								  AND EXISTS (SELECT id FROM `match` 
											   WHERE `match`.id = bet.match_id
												 AND `match`.date < NOW())", array($userGroup_id));
		return $result;
	}

	function getFutureBets($userGroup_id) {
		$result = DB::select("SELECT match_id, betdate, user_id, (SELECT username FROM user WHERE user.id = bet.user_id) AS better FROM bet 
								WHERE EXISTS (SELECT user_id FROM userPerUserGroup 
											   WHERE userPerUserGroup.user_id = bet.user_id 
												 AND userGroup_id = ?)
								  AND EXISTS (SELECT id FROM `match` 
											   WHERE `match`.id = bet.match_id
												 AND `match`.date > NOW())", array($userGroup_id));
		return $result;
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

	function array_orderby(){
	    $args = func_get_args();
	    $data = array_shift($args);
	    foreach ($args as $n => $field) {
	        if (is_string($field)) {
	            $tmp = array();
	            foreach ($data as $key => $row)
	                $tmp[$key] = $row[$field];
	            $args[$n] = $tmp;
	            }
	    }
	    $args[] = &$data;
	    call_user_func_array('array_multisort', $args);
	    return array_pop($args);
	}
	
	function timeline($userGroup_id){
		$timeline = array();
		// get the stared date
		$result = DB::select("SELECT created,name FROM userGroup WHERE id = ?", array($userGroup_id));
		
		$name = $result[0]->name;
		$usergroupcreatedate = $result[0]->created;
		
		$timeline_usergroupcreated = array('date'=>$usergroupcreatedate, 'icon'=>'glyphicon-plane', 'color'=>'success', 'title'=>'Group created', 'content'=>'');
		
		array_push($timeline, $timeline_usergroupcreated);
		
		// get the users added to the group
		$users = $this->getUsers($userGroup_id);
		foreach($users as $user){
			$timeline_user = array('date'=>$user->created,
									'icon'=>'glyphicon-user',
									 'color'=>'danger',
									  'title'=>'<a href="'.url('profile').'/'.$user->id.'">'.$user->username.'</a> joined '.$name, 														'content'=>'');
			
			array_push($timeline, $timeline_user);
		}
		
		// get the invitations added to the group
		$invites = $this->getInvites($userGroup_id);
		foreach($invites as $invite){
			$timeline_invite = array('date'=>$invite->created,
									 'icon'=>'glyphicon-envelope', 
									 'color'=>'warning', 
									 'title'=>'<a href="'.url('profile').'/'.$invite->invitedById.'">'.$invite->invitee.'</a> invited by <a href="'.url('profile').'/'.$invite->userId.'">'.$invite->inviter.'</a>', 
									 'content'=>'');
			
			array_push($timeline, $timeline_invite);
		}
		
		// add the bets already passed(so games played)
		$pastBets = $this->getPastBets($userGroup_id);
		foreach($pastBets as $bet){
			$timeline_pastbet = array('date'=>$bet->betdate,
									  'icon'=>'glyphicon-envelope',
									  'color'=>'warning',
									  'title'=>'<a href="'.url('profile').'/'.$bet->user_id.'">'.$bet->better.'</a> bet on <a href="'.url('match').'/'.$bet->match_id.'">this match</a>', 
									 'content'=>'');
			array_push($timeline, $timeline_pastbet);
		}

		// add the bets yet to play
		$futureBets = $this->getFutureBets($userGroup_id);
		foreach($futureBets as $bet){
			$timeline_futurebet = array('date'=>$bet->betdate,
									  'icon'=>'glyphicon-envelope',
									  'color'=>'warning',
									  'title'=>'<a href="'.url('profile').'/'.$bet->user_id.'">'.$bet->better.'</a> bet on <a href="'.url('match').'/'.$bet->match_id.'">this match</a>', 
									 'content'=>'');
			array_push($timeline, $timeline_futurebet);
		}
		
		return $this->array_orderby($timeline, 'date',SORT_DESC);
	}
}
