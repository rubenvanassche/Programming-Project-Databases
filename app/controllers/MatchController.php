<?php

class MatchController extends BaseController {
	
	function index($matchID){
		$data['match'] = Match::get($matchID);
		$data['future'] = Match::isInFuture($matchID);
		$data['goalshometeam'] = Match::goals($matchID, $data['match']->hometeam_id);
		$data['cardshometeam'] = Match::cards($matchID, $data['match']->hometeam_id);
		$data['goalsawayteam'] = Match::goals($matchID, $data['match']->awayteam_id);
		$data['cardsawayteam'] = Match::cards($matchID, $data['match']->awayteam_id);
		return View::make('match.match',$data)->with('title', 'Match');
	}
}

?>
