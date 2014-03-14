<?php

class Team {
	public static function getTeam($askedID){
		$result = DB::select('SELECT * FROM team WHERE id = ?', array($askedID));
		return $result;
	}
}
