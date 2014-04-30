<?php

class PlayerController extends BaseController {

	/*public function index($playerName){
		$playerObj = Player::getPlayer($playerName)[0];
		$playerTeam = Team::getTeambyPlayerID($playerObj->id)[0];		
		$playerText = Player::getPlayerText($playerName);
		$playerImageURL = Player::getPlayerImageURL($playerName);
		$goals = Player::goals($playerObj->id);
		$cards = Player::cards($playerObj->id);
			
		return View::make('player.player', compact('playerObj', 'playerTeam', 'playerText', 'playerImageURL', 'goals', 'cards'))->with('title', $playerName);
	}*/
	
	public function index($id){
		$playerObj = Player::getPlayer($id)[0];
		$playerTeam = Team::getTeambyPlayerID($id)[0];		
		$playerText = Player::getPlayerText($playerObj->name);
		$playerImageURL = Player::getPlayerImageURL($playerObj->name);
		$goals = Player::goals($id);
		$cards = Player::cards($id);
		$playerName = $playerObj->name;
			
		return View::make('player.player', compact('playerObj', 'playerTeam', 'playerText', 'playerImageURL', 'goals', 'cards'))->with('title', $playerName);
	}
}

?>
