<?php 

class Notifications {

	const INVITE_USER_GROUP = 1; 

	public function saveNotification($object_id, $subject_id, $actor_id, $type_id){
		$created_date = date("Y-m-d H:i:s");
		$query = "INSERT INTO `notifications` (actor_id, subject_id, object_id, type_id, status, count, created_date, update_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $values = array( $actor_id, $subject_id, $object_id, $type_id, 'unseen', 1, $created_date, '');
        DB::insert( $query, $values );
	}

	
	public function getNotifications($subjectID, $page = 1){
		$query = "SELECT nf.*, actor.name AS actor_name, subject.name AS subject_name
                FROM notifications nf
                INNER JOIN users actor ON nf.actor_id = actor.id
                INNER JOIN users SUBJECT ON nf.subject_id = SUBJECT.id
                WHERE subject_id = $subjectId
                AND status = 'unseen'
                LIMIT $offset, 5");
				
		$result = return DB::select( $query, $values );
				
        $rows = array();
		
        while($row = $result->fetch_assoc()){
            $row['object'] = $this->getObjectRow($row['type_id'], $row['object_id']);
            $rows[] = $row;
        }
		
		$notifications = array();
		
		foreach($rows as $row){
            $notification = array(
                'message' => $this->getNotificationMessage($row),
                'actor_id' => $row['actor_id'],
                'subject_id' => $row['subject_id'],
                'object' => $row['object_id'],
            );
            $notifications[] = $notification;
        }
         
        return $notifications;
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

?> 