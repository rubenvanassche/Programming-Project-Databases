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
}

?>
