<?php


//Should this be merged into UserController?

class BetController extends BaseController {

	public function index(){
		$user = new User;
		if ($user->loggedIn()) {
			$pastBets = Bet::getPastBetsByUserID($user->ID());
			$futureBets = Bet::getFutureBetsByUserID($user->ID());
			$pastBetsMatches = array();
			$futureBetsMatches = array();
			foreach ($pastBets as $bet) {
				array_push($pastBetsMatches, Match::get($bet->match_id));
			}
			foreach ($futureBets as $bet) {
				array_push($futureBetsMatches, Match::get($bet->match_id));
			}
			return View::make('user.betoverview', compact('pastBets', 'futureBets', 'pastBetsMatches', 'futureBetsMatches'))->with('title', "Bets overview");
		}
		

	}
}
