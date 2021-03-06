<?php

class PlayerController extends BaseController {
	
	public function index($id){
		$playerObj = Player::getPlayer($id)[0];
		$playerTeam = Team::getTeambyPlayerID($id)[0];		
		$playerText = Player::getPlayerText($playerObj->name);
		$playerImageURL = Player::getPlayerImageURL($playerObj->name);
		$goals = Player::goals($id);
		$cards = Player::cards($id);
		$matches = Player::matches($id);
		$playerName = $playerObj->name;
		$outcomes = Player::getWinsLossesTies($id);
		$yearlyGoalsCards = Player::getYearlyGoalsCards($id);
			
		return View::make('player.player', compact('playerObj', 'playerTeam', 'playerText', 'playerImageURL', 'goals', 'cards', 'matches', 'outcomes', 'yearlyGoalsCards'))->with('title', $playerName);
	}
}

?>
