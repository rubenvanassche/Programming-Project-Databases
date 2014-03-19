<?php

class Player {
	public static function getPlayer($playerName){
		$result = DB::select('SELECT * FROM player WHERE name = ?', array($playerName));
		return $result;
	}
	
	public static function goals($playerID){
		$result = DB::select("SELECT goal.time,
									goal.match_id,
									 `match`.date,
									 (SELECT name FROM team WHERE team.id = `match`.hometeam_id) as hometeam,
									 (SELECT name FROM team WHERE team.id = `match`.awayteam_id) as awayteam
									 FROM `match`, goal WHERE `match`.id = goal.match_id AND goal.player_id = ?", array($playerID));
		return $result;
	}
	
	public static function countGoals($playerID){
		$result = DB::select("SELECT COUNT(id) as count FROM goal WHERE player_id = ?", array($playerID));
		return $result[0]->count;
	}
	
	public static function cards($playerID){
		$result = DB::select("SELECT cards.time,
							cards.color,
							cards.match_id,
							(SELECT date FROM `match` WHERE  `match`.id = cards.match_id) as date,
							(SELECT name FROM team,`match`  WHERE  team.id = `match`.hometeam_id AND `match`.id = cards.match_id) as hometeam,
							(SELECT name FROM team,`match`  WHERE  team.id = `match`.awayteam_id AND `match`.id = cards.match_id) as awayteam
							FROM cards WHERE player_id = ? ORDER BY date desc, time asc", array($playerID));
		return $result;
	}
	
	public static function getPlayerText($playerName){
		$jsonurl = "http://en.wikipedia.org/w/api.php?action=query&prop=extracts&format=json&exsentences=5&exlimit=10&exintro=&exsectionformat=plain&titles=" . urlencode($playerName);
		$json = file_get_contents($jsonurl);
		$decodedJSON = json_decode($json, true, JSON_UNESCAPED_UNICODE);
		
		
		
		foreach ($decodedJSON['query']['pages'] as $key => $value) {
			$pagenr = $key;
		}		
		
		try {
			$text = $decodedJSON['query']['pages'][$pagenr]['extract'];
		}
		catch (Exception $e) {
			return "No summary available.";
		}
		return $text;
	}
	
	public static function getPlayerImageURL($playerName) {
		$jsonurl = "http://en.wikipedia.org/w/api.php?action=query&titles=" . urlencode($playerName) . "&prop=pageimages&format=json&pithumbsize=300";
		$json = file_get_contents($jsonurl);
		$decodedJSON = json_decode($json, true, JSON_UNESCAPED_UNICODE);
		
		foreach ($decodedJSON['query']['pages'] as $key => $value) {
			$pagenr = $key;
		}
		
		try {
			$url = $decodedJSON['query']['pages'][$pagenr]['thumbnail']['source'];
		}
		catch (Exception $e) {
			return "https://encrypted-tbn1.gstatic.com/images?q=tbn:ANd9GcQDBQGDMwwKrrjyl5frVZhTV1qDP6u3YtPhFW_XM6zjdStHkm0";
		}
		return $url;
	}
}
