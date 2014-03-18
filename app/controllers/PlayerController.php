<?php

class PlayerController extends BaseController {

	public function showPage()
	{
		
	
		$playerName = htmlspecialchars($_GET["name"]);
		$playerObj = Player::getPlayer($playerName)[0];
		$playerTeam = Team::getTeambyPlayerID($playerObj->id)[0];		
		$playerText = Player::getPlayerText($playerName);
		$playerImageURL = Player::getPlayerImageURL($playerName);
		
		return View::make('player', compact('playerObj', 'playerTeam', 'playerText', 'playerImageURL'))->with('title', $playerName);
	}
}

?>
