<?php

class Team {
	public static function getTeam($askedID){
		$result = DB::query('SELECT * FROM match WHERE id = '$askedID')');
		return $result;
	}
}
