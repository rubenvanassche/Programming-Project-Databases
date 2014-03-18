<?php

class TeamsController extends BaseController {

	public function showPage()
	{
		/*$teamID = htmlspecialchars($_GET["id"]);
		$teamObj = Team::getTeamByID($teamID)[0];
		$teamText = Team::getTeamText($teamObj->name);
		$teamImageURL = Team::getTeamImageURL($teamObj->name);*/
		
		return View::make('teams')->with('title', 'Teams');
	}
}

?>
