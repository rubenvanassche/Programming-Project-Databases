<?php

class Match {
	public static function getRecentMatches(){
		$results = DB::select('SELECT * FROM match WHERE id = ?', array(0));
		return $results;
	}
	
	function getFutureMatches(){
		$results = DB::select('SELECT * FROM match WHERE id = ?', array(0));
		return $results;
	}
}
