<?php

class Player {
	public static function getPlayer($playerName){
		$result = DB::select('SELECT * FROM player WHERE name = ?', array($playerName));
		return $result;
	}
	
	public static function goals($playerID){
		//$result = DB::select("SELECT goal.time as time, match.hometeam.id as hometeamID  FROM goal, match, team WHERE match.id = goal.match_id AND goal.player_id = ?", array($playerID));
		//return $result;
	}
	
	public static function getPlayerText($playerName){
		$jsonurl = "http://en.wikipedia.org/w/api.php?action=query&prop=extracts&format=json&exsentences=5&exlimit=10&exintro=&exsectionformat=plain&titles=" . urlencode($playerName);
		$json = file_get_contents($jsonurl);
		$decodedJSON = json_decode($json, true, JSON_UNESCAPED_UNICODE);
		
		foreach ($decodedJSON['query']['pages'] as $key => $value) {
			$pagenr = $key;
		}		
		
		$text = $decodedJSON['query']['pages'][$pagenr]['extract'];
		return $text;
	}
	
	public static function getPlayerImageURL($playerName) {
		$jsonurl = "http://en.wikipedia.org/w/api.php?action=query&titles=" . urlencode($playerName) . "&prop=pageimages&format=json&pithumbsize=300";
		$json = file_get_contents($jsonurl);
		$decodedJSON = json_decode($json, true, JSON_UNESCAPED_UNICODE);
		
		foreach ($decodedJSON['query']['pages'] as $key => $value) {
			$pagenr = $key;
		}
		
		$url = $decodedJSON['query']['pages'][$pagenr]['thumbnail']['source'];
		
		return $url;
	}
}
