<?php

class PlayersController extends BaseController {

	public function showPage()
	{
		$teamID = htmlspecialchars($_GET["id"]);
		$team = Team::getTeamByID($teamID)[0];
		$playerBase = Team::getPlayers($teamID);
		$teamImageURL = Team::getTeamImageURL($team->name);
		
		return View::make('players', compact('team', 'playerBase', 'teamImageURL'))->with('title', $team->name);
	}
}

?>
