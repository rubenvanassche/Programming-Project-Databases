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
			
			$data['title'] = 'Bets';
			$data['pastBets'] = $pastBets;
			$data['futureBets'] = $futureBets;
			$data['pastBetsMatches'] = $pastBetsMatches;
			$data['futureBetsMatches'] = $futureBetsMatches;
			
			return View::make('layouts.simple', $data)->nest('content', 'user.betoverview', $data);
		}
		

	}
}
