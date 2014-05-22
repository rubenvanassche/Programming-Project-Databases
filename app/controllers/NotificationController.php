<?php

class NotificationController extends BaseController {

  function redirect($id) {
    $notification = Notifications::get($id);

    // Mark notification as seen.
    DB::update("UPDATE notifications notif SET status = 'seen' WHERE notif.id = ?", array($id));

    switch($notification->type_id){
        case Notifications::INVITE_USER_GROUP:
          return View::make('myProfile');
        case Notifications::REMIND_USER_BETS:
          $user = new User;
          $matches = Match::getNextMatchesCustom(999, $user->get($user->ID()));
          $data['matches'] = $matches;
          $data['user'] = $user->get($user->ID());
          return View::make('match.matches', $data)->with('title', 'Upcoming Matches');
        }
  }
}

?>
