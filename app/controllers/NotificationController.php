<?php

class NotificationController extends BaseController {

  function redirect($id) {
    $notification = Notifications::get($id);

    // Mark notification as seen.

    switch($notification->type_id){
        case Notifications::INVITE_USER_GROUP:
          return UserController::profile();
        case Notifications::REMIND_USER_BETS:
          DB::update("UPDATE notifications notif SET status = 'seen' WHERE notif.id = ?", array($id));
          return MatchController::betMatches();
        }
  }
}

?>
