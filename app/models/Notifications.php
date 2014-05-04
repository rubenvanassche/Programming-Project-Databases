<?php 

class Notifications {

	const INVITE_USER_GROUP = 1; 

	public static function saveNotification($object_id, $subject_id, $actor_id, $type_id){
		$created_date = date("Y-m-d H:i:s");
		$query = "INSERT INTO `notifications` (actor_id, subject_id, object_id, type_id, status, created_date, updated_date) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $values = array( $actor_id, $subject_id, $object_id, $type_id, 'unseen', $created_date, '');
        DB::insert( $query, $values );
	}

	
	public static function getNotifications($subjectID, $page = 1){
		$query = "SELECT nf.*, actor.username AS actor_name, subject.username AS subject_name
                FROM notifications nf
                INNER JOIN user actor ON nf.actor_id = actor.id
                INNER JOIN user SUBJECT ON nf.subject_id = SUBJECT.id
                WHERE subject_id = $subjectID
                AND status = 'unseen'
                LIMIT 0, 5";
				
		$result = DB::select($query);
		
		var_dump($result);
				
        $rows = array();
		
       /* while($row = $result->fetch_assoc()){
            $row['object'] = $this->getObjectRow($row['type_id'], $row['object_id']);
            $rows[] = $row;
        }*/
		
		foreach($result as $rs) {
			$row['object'] = Notifications::getObjectRow($rs['type_id'], $rs['object_id']);
		}
		
		/*$notifications = array();
		
		foreach($rows as $row){
            $notification = array(
                'message' => $this->getNotificationMessage($row),
                'actor_id' => $row['actor_id'],
                'subject_id' => $row['subject_id'],
                'object' => $row['object_id'],
            );
            $notifications[] = $notification;
        }
         
        return $notifications;*/
	}
	
	protected function getObjectRow($typeId, $objectId)
    {
        switch($typeId){
            case self::INVITE_USER_GROUP:
                return $this->mysqli->query("SELECT * FROM userGroupInvites WHERE id = $objectId")->fetch_assoc();
        }
    }
	
	    protected function getNotificationMessage($row){
        switch($row['type_id']){
            case self::INVITE_USER_GROUP:
                return "{$row['actor_name']} invited you to join GROUP A";
        }
    }

	public static function test() {
			
		$query = "INSERT INTO `userGroupInvites` (userId, competitionId, invitedById) VALUES (?, ?, ?)";
        $values = array( 6, 3, 5);
        DB::insert( $query, $values );
		
		Notifications::saveNotification(3, 6, 5, self::INVITE_USER_GROUP);
		
		$result = Notifications::getNotifications(6);
	}
	
}