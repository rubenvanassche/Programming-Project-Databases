<?php

class TeamController extends BaseController {

	public function index($teamID){
		$teamObj = Team::getTeamByID($teamID)[0];
		$teamText = Team::getTeamText($teamObj->name);
		$teamImageURL = Team::getTeamImageURL($teamObj->name);
		
		return View::make('team', compact('teamObj', 'teamText', 'teamImageURL'))->with('title', $teamObj->name);
	}
	
	function all(){
		return View::make('teams')->with('title', 'Teams');
	}
	
	public function players($teamID){
		$team = Team::getTeamByID($teamID)[0];
		$playerBase = Team::getPlayers($teamID);
		$teamImageURL = Team::getTeamImageURL($team->name);
		
		return View::make('players', compact('team', 'playerBase', 'teamImageURL'))->with('title', $team->name);
	}
	
	
}

?>
