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
}

?>
