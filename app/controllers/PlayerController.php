<?php

class PlayerController extends BaseController {

	public function index($playerName){
		$playerObj = Player::getPlayer($playerName)[0];
		$playerTeam = Team::getTeambyPlayerID($playerObj->id)[0];		
		$playerText = Player::getPlayerText($playerName);
		$playerImageURL = Player::getPlayerImageURL($playerName);
		$goals = Player::goals($playerObj->id);
		$cards = Player::cards($playerObj->id);
			
		return View::make('player.player', compact('playerObj', 'playerTeam', 'playerText', 'playerImageURL', 'goals', 'cards'))->with('title', $playerName);
	}
}

?>
