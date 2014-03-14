<?php

class Goal {
	public static function getHomeGoals($match){
		$result = DB::select('SELECT * FROM goal WHERE match_id = ? AND team_id = ?', array($match->id, $match->hometeam_id));
		return $result;
	}
	
	public static function getAwayGoals($match){
		$result = DB::select('SELECT * FROM goal WHERE match_id = ? AND team_id = ?', array($match->id, $match->awayteam_id));
		return $result;
	}
}