<?php

/**
 * @class Player
 * @brief The Player data model.
 */
class Player {

    /**
     * @var TABLE_PLAYER
     * @brief The table of the players.
     */
    const TABLE_PLAYER   = "player";

    /**
     * @brief Get the player IDs by name.
     *
     * @param name The name of the players.
     *
     * @return The result after the query.
     */
    public static function getIDsByName( $name ) {
        $query = "SELECT id FROM `".self::TABLE_PLAYER."` WHERE name = ?";
        $values = array( $name );
        return DB::select( $query, $values );
    }

    /**
     * @brief Add a player to the data model.
     *
     * @param name The name of the player.
     *
     * @return The ID's named after the players.
     */
    public static function add( $name ) {
        $query = "INSERT INTO `".self::TABLE_PLAYER."` (name) VALUES (?)";
        $values = array( $name );

        DB::insert( $query, $values );

        return self::getIDsByName( $name );
    }


    // TODO documentize
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
