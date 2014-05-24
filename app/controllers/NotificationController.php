<?php

class NotificationController extends BaseController {

  function redirect($id) {
    $notification = Notifications::get($id);

    switch($notification->type_id){
        case Notifications::INVITE_USER_GROUP:
          return UserController::profile();

        case Notifications::REMIND_USER_BETS:
          DB::update("UPDATE notifications notif SET status = 'seen' WHERE notif.id = ?", array($id));
          return MatchController::betMatches();

        case Notifications::NEW_DISCUSSION:
        case Notifications::NEW_MESSAGE:
          DB::update("UPDATE notifications notif SET status = 'seen' WHERE notif.id = ?", array($id));
          $result = DB::select("SELECT ugm.id, ugm.usergroup_id FROM userGroupMessages as ugm WHERE ugm.id =
            (SELECT object_id FROM notifications WHERE id = ?)", array($id))[0];
          $usergroup_id = $result->usergroup_id;
          $discussion_id = $result->id;
          return Redirect::to('usergroup/'.$usergroup_id.'/discussion/'.$discussion_id);
      }
  }
}

?>
