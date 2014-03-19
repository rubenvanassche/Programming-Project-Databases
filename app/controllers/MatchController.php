<?php

class MatchController extends BaseController {
	
	function index($matchID){
		$data['match'] = Match::get($matchID);
		print_r($data['match']);
		
		return View::make('match.match',$data)->with('title', 'Match');
	}
}

?>