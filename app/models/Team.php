<?php

class Team {
	public static function getTeam($askedID){
		$result = DB::select('SELECT * FROM match WHERE id = '$askedID')');
		return $result;
	}
}
