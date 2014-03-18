<?php

class Match {
	public static function getRecentMatches(){
		// What condition are we going to use here?
		$test = 1;
		$results = DB::select('SELECT * FROM `match` WHERE id = ?', array(1));
		return $results;
	}
	
	public static function getFutureMatches(){
		// What condition are we going to use here?
		$results = DB::select('SELECT * FROM `match` WHERE id = ?', array(0));
		return $results;
	}
}

?>
