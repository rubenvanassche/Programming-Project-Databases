<?php

class Match {
	public static function getRecentMatches(){
		// What condition are we going to use here?
		$results = DB::select('SELECT * FROM `match`');
		return $results;
	}
	
	public static function getFutureMatches(){
		// What condition are we going to use here?
		$results = DB::select('SELECT * FROM `match` WHERE id = ?', array(0));
		return $results;
	}
	
	public static function getScore($matchID){
		$results = DB::select('SELECT 
								(SELECT COUNT(id) FROM goal WHERE team_id = `match`.hometeam_id) as hometeam_score,
								(SELECT COUNT(id) FROM goal WHERE team_id = `match`.awayteam_id) as awayteam_score
								FROM `match` WHERE id = ?', array($matchID));
		return $results[0]->hometeam_score." - ".$results[0]->awayteam_score;
	}
	
	public static function get($matchID){
		$results = DB::select("SELECT date,
								hometeam_id,
								awayteam_id,
								(SELECT name FROM team WHERE id = `match`.hometeam_id) AS hometeam,  
								(SELECT name FROM team WHERE id = `match`.awayteam_id) AS awayteam,
								(SELECT COUNT(id) FROM goal WHERE team_id = `match`.hometeam_id) as hometeam_score,
								(SELECT COUNT(id) FROM goal WHERE team_id = `match`.awayteam_id) as awayteam_score
								FROM `match` WHERE id = ?", array($matchID));
		return $results[0];
	}
	
	function goals($matchID, $teamID){
		$results = DB::select("SELECT time, (SELECT name FROM player WHERE id = goal.player_id) as player FROM goal WHERE match_id = ? AND team_id = ?", array($matchID, $teamID));
		return $results;
	}
	
	function cards($matchID, $teamID){
		$results = DB::select("SELECT color, time, (SELECT name FROM player WHERE id = cards.player_id AND team_id = ?) as player FROM cards WHERE id match_id = ?", array($teamID, $matchID));
		return $results;
	}
	

	public static function getScore2($matchID){
		$results = DB::select('SELECT 
								(SELECT COUNT(id) FROM goal WHERE team_id = `match`.hometeam_id) as hometeam_score,
								(SELECT COUNT(id) FROM goal WHERE team_id = `match`.awayteam_id) as awayteam_score
								FROM `match` WHERE id = ?', array($matchID));
		return array($hometeam_score, $awayteam_score);
	}

	public static function getMatchByID($matchID) {
		$results = DB::select('SELECT * FROM `match` WHERE id = ?', array($matchID));
		return $results;
	}

	public static function getMatchByTeams($hometeam_id, $awayteam_id) {
		$results = DB::select('SELECT * FROM `match WHERE hometeam_id = ? AND awayteam_id = ?', array($hometeam_id, $awayteam_id));
		return $results;
	}

	public static function getMatchByHometeam($hometeam_id) {
		$results = DB::select('SELECT * FROM `match WHERE hometeam_id = ?', array($hometeam_id));
		return $results;
	}

	public static function getMatchByAwayteam($awayteam_id) {
		$results = DB::select('SELECT * FROM `match WHERE awayteam_id = ?', array($awayteam_id));
		return $results;
	}
}

?>
