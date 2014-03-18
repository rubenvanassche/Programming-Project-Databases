<?php

class TeamController extends BaseController {

	public function showPage()
	{
		$teamID = htmlspecialchars($_GET["id"]);
		$teamObj = Team::getTeamByID($teamID)[0];
		$teamText = Team::getTeamText($teamObj->name);
		$teamImageURL = Team::getTeamImageURL($teamObj->name);
		
		return View::make('team', compact('teamObj', 'teamText', 'teamImageURL'))->with('title', $teamObj->name);
	}
}

?>
