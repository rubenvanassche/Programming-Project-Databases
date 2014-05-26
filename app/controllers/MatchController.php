<?php

class MatchController extends BaseController {

	function index($matchID){
		/* TODO: Every time a match page is opened, it is checked if it is a played match, and if so if its bets have been processed yet.
				 It is probably better to just check this on a set interval, so this should be changed.
				 This way it does not slow down opening Match pages and opening the page is not necessary to have bets evaluated.
		*/
		$user = new User;
		$data['match'] = Match::get($matchID);
		$data['inFuture'] = Match::isInFuture($matchID, 1);
		$data['bet'] = $data['inFuture'] && $user->loggedIn() && !(Bet::hasBet($user->ID(), $matchID));
		$data['goalshometeam'] = Match::goals($matchID, $data['match']->hometeam_id);
		$data['cardshometeam'] = Match::cards($matchID, $data['match']->hometeam_id);
		$data['transfershometeam'] = Match::transfers($matchID, $data['match']->hometeam_id);
		$data['goalsawayteam'] = Match::goals($matchID, $data['match']->awayteam_id);
		$data['cardsawayteam'] = Match::cards($matchID, $data['match']->awayteam_id);
		$data['transfersawayteam'] = Match::transfers($matchID, $data['match']->awayteam_id);
		$data['phase'] = Match::phase($matchID);
		if ($data['inFuture']) {
			$data['predictedScores'] = Prediction::predictScore($matchID);
			$data['predictedOutcome'] = Prediction::predictOutcome($matchID);
		}
		else {
			$data['predictedScores'] = array(0, 0); //Prevents crash
			$data['predictedOutcome'] = 0;
		}
		return View::make('match.match',$data)->with('title', 'Match');
	}

	function matches() {
		$user = new User;

		$matches = Match::getNextunbetMatches(0, $user->get($user->ID()));
		$data['matches'] = $matches;
		$data['user'] = $user->get($user->ID());

		return View::make('match.matches', $data)->with('title', 'Upcoming Matches');
	}

	public static function betMatches() {
		$user = new User;
		$data['loggedIn'] = $user->loggedIn();
		if ($user->loggedIn()) {
			$matches = Match::getNextMatchesCustom(999, $user->get($user->ID()));
			$data['matches'] = $matches;
			$data['user'] = $user->get($user->ID());
			return View::make('match.matches', $data)->with('title', 'Upcoming Matches');
		}
		else {
			$matches = Match::getNextMatches(999);
			$data['matches'] = $matches;
			return View::make('match.matches', $data)->with('title', 'Upcoming Matches');
		}
	}
}

?>
