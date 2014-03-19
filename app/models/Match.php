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

	public static function getMatchByID($matchID) {
		$results = DB::select('SELECT * FROM `match` WHERE id = ?', array($matchID));
		return $results;
	}

	public static function getMatchByTeams($hometeam_id, $awayteam_id) {
		$results = DB::select('SELECT * FROM `match` WHERE hometeam_id = ? AND awayteam_id = ?', array($hometeam_id, $awayteam_id);
		return $results;
	}

	public static function getMatchByHometeam($hometeam_id) {
		$results = DB::select('SELECT * FROM `match` WHERE hometeam_id = ?', array($hometeam_id));
		return $results;
	}

		public static function getMatchByAwayteam($awayteam_id) {
		$results = DB::select('SELECT * FROM `match` WHERE awayteam_id = ?', array($awayteam_id));
		return $results;
	}
}

?>
