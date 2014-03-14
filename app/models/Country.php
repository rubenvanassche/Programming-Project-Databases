<?php

class Country {
	public static function getCountry($id){
		$result = DB::select('SELECT * FROM country WHERE id = ?', array($id));
		return $result;
	}
}