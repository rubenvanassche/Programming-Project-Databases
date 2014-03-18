<?php

class TeamController extends BaseController {

	public function index($teamID){
		$teamObj = Team::getTeamByID($teamID)[0];
		
		$teamImageURL = Team::getTeamImageURL($teamObj->name);
		
		return View::make('team.team', compact('teamObj', 'teamImageURL'))->with('title', $teamObj->name);
	}
	
	function all(){
		return View::make('team.teams')->with('title', 'Teams');
	}
	
	public function players($teamID){
		$team = Team::getTeamByID($teamID)[0];
		$playerBase = Team::getPlayers($teamID);
		$teamImageURL = Team::getTeamImageURL($team->name);
		
		return View::make('team.players', compact('team', 'playerBase', 'teamImageURL'));
	}
	
	public function information($teamID){
		$teamObj = Team::getTeamByID($teamID)[0];
		$teamText = Team::getTeamText($teamObj->name);
		
		return View::make('team.information', compact('teamText'));
	}
	
	
}

?>
