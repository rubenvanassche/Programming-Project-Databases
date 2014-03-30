<?php

/**
 * @class Team
 * @brief The core data model of Team entity.
 */
class Team {

    /**
     * @var TABLE_TEAM
     * @brief the team table.
     */
    const TABLE_TEAM            = "team";

    /**
     * @var TABLE_PLAYER_PER_TEAM
     * @brief Table where each player is linked to a team.
     */
    const TABLE_PLAYER_PER_TEAM = "playerPerTeam";

    /**
     * @brief Get the IDs of the team by inputting the name only.
     *
     * @return Results after the query.
     */
    public static function getIDsByName( $name ) {
        $query = "SELECT id FROM `".self::TABLE_TEAM."` WHERE name = (?)";
        $values = array( $name );
        return DB::select( $query, $values );
    }

    /**
     * @brief add a team into the data model.
     *
     * @return The IDs of the team just added.
     */
    public static function add( $name, $country_id, $coach_id, $points) {
        $query = ( empty( $coach_id ) ) ? "INSERT INTO `".self::TABLE_TEAM."` (name, country_id, fifapoints) VALUES ( ?, ?, ?)" : "INSERT INTO `".self::TABLE_TEAM."` (name, country_id, coach_id, fifapoints) VALUES ( ?, ?, ?, ?)";
        $values = ( empty( $coach_id ) ) ? array( $name, $country_id, $points ) : array( $name, $country_id, $coach_id, $points );

        DB::insert( $query, $values );

        return self::getIDsByName( $name );
    }

    /**
     * @brief link a player to a team.
     *
     * @return True if new link created, False otherwise.
     */
    public static function linkPlayer( $player_id, $team_id ) {
        $query = "SELECT * FROM `".self::TABLE_PLAYER_PER_TEAM."` WHERE player_id = ? AND team_id = ?";
        $values = array( $player_id, $team_id );
        if ( !empty( DB::select( $query, $values ) ) ) return False;

        $query = 'INSERT INTO `'.self::TABLE_PLAYER_PER_TEAM.'` (player_id, team_id) VALUES (?, ?)';
        DB::insert( $query, $values );
        return True;
    }

    // TODO DOCUMENTIZE
	public static function getTeambyID($askedID){
		$result = DB::select('SELECT * FROM team WHERE id = ?', array($askedID));
		return $result;
	}
	
	public static function getAll(){
		$result = DB::select('SELECT * FROM team');
		return $result;
	}
	
	public static function getTeambyPlayerID($playerID) {
		$teamID = DB::select('SELECT team_id FROM playerPerTeam WHERE player_id = ?', array($playerID));
		$result = Team::getTeambyID($teamID[0]->team_id);
		return $result;
	}
	
	public static function getPlayers($teamID) {
		$playerIDs = DB::select('SELECT player_id FROM playerPerTeam WHERE team_id = ?', array($teamID));
		$players = array();
		foreach ($playerIDs as $playerID) {
			$player = DB::select('SELECT * FROM player WHERE id = ?', array($playerID->player_id));
			array_push($players, $player);
		}
		
		return $players;
	}

	public static function getFIFAPoints() {
			$results = DB::select('SELECT name FROM country');
			$points = array();
			foreach ($results as $country) {
				$fifaPoints = DB::select('SELECT fifapoints FROM team WHERE name = ?', array($country->name));
				if (!empty($fifaPoints)) {
					$thesePoints = array("name" => $country->name, "points" => $fifaPoints[0]->fifapoints);
					array_push($points, $thesePoints);
				}
			}
			return $points;
	}
	
	public static function getTopTeams($limit = ''){
		if($limit != '' and is_numeric($limit)){
			$limit = " LIMIT ". $limit;
		}
		
		$results = DB::select("SELECT team.id, team.name, team.fifapoints, country.abbreviation FROM team, country WHERE country.id = team.country_id ORDER BY team.fifapoints desc".$limit);
		return $results;
	}
	
	public static function getMatches($teamID){
		$results = DB::select("SELECT `match`.date,
							  `match`.id as match_id,
							  (SELECT name FROM team WHERE team.id = `match`.hometeam_id) as hometeam,
							  (SELECT name FROM team WHERE team.id = `match`.awayteam_id) as awayteam
							  FROM `match` WHERE hometeam_id = ? OR awayteam_id = ?", array($teamID, $teamID));
		return $results;
	}
	
	public static function getTeamText($teamName){
		$jsonurl = "http://en.wikipedia.org/w/api.php?action=query&prop=extracts&format=json&exsentences=5&exlimit=10&exintro=&exsectionformat=plain&titles=" . urlencode($teamName);
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
	
	public static function getTeamImageURL($teamName) {
		$jsonurl = "http://en.wikipedia.org/w/api.php?action=query&titles=" . urlencode($teamName) . "&prop=pageimages&format=json&pithumbsize=300";
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
