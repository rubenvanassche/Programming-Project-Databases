<?php

class Notifications {

	const INVITE_USER_GROUP = 1;
	const REMIND_USER_BETS = 2;

	public static function saveNotification($object_id, $subject_id, $actor_id, $type_id){
		$created_date = date("Y-m-d H:i:s");
		$query = "INSERT INTO `notifications` (actor_id, subject_id, object_id, type_id, status, created_date, updated_date) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $values = array( $actor_id, $subject_id, $object_id, $type_id, 'unseen', $created_date, '');
        DB::insert( $query, $values );
	}


	public static function getNotifications($subjectID, $type = 0, $page = 1){
		// By default type = 0. This means it will select all notifications.
		// If you just want notifications of 1 type (like only invites for example) then
		// you can just give in the type.

		if ($type == 0) {
			$query = "SELECT nf.*, actor.username AS actor_name, subject.username AS subject_name
					FROM notifications nf
					INNER JOIN user actor ON nf.actor_id = actor.id
					INNER JOIN user subject ON nf.subject_id = subject.id
					WHERE subject_id = $subjectID
					AND status = 'unseen'
					LIMIT 0, 5";
		}
		else {
			$query = "SELECT nf.*, actor.username AS actor_name, subject.username AS subject_name
					FROM notifications nf
					INNER JOIN user actor ON nf.actor_id = actor.id
					INNER JOIN user subject ON nf.subject_id = subject.id
					WHERE subject_id = $subjectID
					AND status = 'unseen'
					AND type_id = $type
					LIMIT 0, 5";
		}

		$result = DB::select($query);

    $rows = array();

		foreach($result as $rs) {
			$row['id'] = $rs->id;
			$row['object_id'] = $rs->object_id;
			$row['actor_id'] = $rs->actor_id;
			$row['subject_id'] = $rs->subject_id;
			$row['type_id'] = $rs->type_id;
			$row['object'] = Notifications::getObjectRow($rs->type_id, $rs->object_id);
			$rows[] = $row;
		}

		$notifications = array();

		foreach($rows as $row){
            $notification = array(
                'message' => Notifications::getNotificationMessage($row),
                'actor_id' => $row['actor_id'],
                'subject_id' => $row['subject_id'],
                'object' => $row['object_id'],
								'id' => $row['id']
            );
            $notifications[] = $notification;
        }

        return $notifications;
	}

	protected static function getObjectRow($typeId, $objectId)
    {
        switch($typeId){
            case self::INVITE_USER_GROUP:
                $query = "SELECT * FROM `userGroupInvites` WHERE `competitionId` = ?";
				$values = array($objectId);
				$result = DB::select($query, $values)[0];
				return $result;
        }
    }

	    protected static function getNotificationMessage($row){
			switch($row['type_id']){
				case self::INVITE_USER_GROUP:
					$group = DB::select("
					SELECT name
							FROM userGroup
							WHERE id = {$row['object']->competitionId}
					");

					$actor = DB::select("
					SELECT username
					FROM user
					WHERE id = {$row['actor_id']}
					");

					return " {$actor[0]->username} invited you to join the group: {$group[0]->name}";

				case self::REMIND_USER_BETS:
					return "Don't forget to bet on these matches!";
        }
    }

	public static function sendMailReminder($user_id, $matches) {
		// Sends an email reminding one user that they still need to bet on a match.

		$user = new User;

		$data['matches'] = $matches;
		$data['user'] = $user->get($user_id);

		$message = new stdClass();
		$user_email = $data['user']->email;
		$username = $data['user']->username;

		Mail::send('mails.reminder', $data, function($message) use ($user_email, $username){
    	$message->to($user_email, $username)->subject("Don't forget to bet on these upcoming matches!");
		});
	}

	public static function betReminder($user_id, $matches) {
		// Sends a notification reminding one user that they still need to bet on a match.
		$user = new User;
		Notifications::saveNotification(NULL, $user->ID(), $user->ID(), Notifications::REMIND_USER_BETS);
	}

	public static function sendReminders($days) {
		// Will send an email + notification reminding the users that they still need to bet on a match.
		// Set $days to the amount of days you want to check for upcoming matches.

		$users = User::getEmailUsers();

		foreach($users as $user) {
				$matches = Match::getNextUnbettedMatches($days, $user);

				if (count($matches) > 0) {
					Notifications::sendMailReminder($user->id, $matches);
					Notifications::betReminder($user->id, $matches);
				}
		}

	}

}
