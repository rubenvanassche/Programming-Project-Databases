<?php

class Match {
	public static function getRecentMatches(){
		$results = DB::query('SELECT * FROM match WHERE date = CURDATE()');
		return $results;
	}
	
	function getFutureMatches(){
		$results = DB::query('SELECT * FROM match WHERE date = CURDATE()');
		return $results;
	}
}
