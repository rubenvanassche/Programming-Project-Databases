<?php

/**
 * @class Match
 * @brief Core data model of a match.
 */
class Match {

    /**
     * @var TABLE_MATCH
     * @brief The match table from database.
     */
    const TABLE_MATCH = "match";

    /**
     * @brief Get The ids of a given match.
     * @param hometeam_id The ID of the hometeam.
     * @param awayteam_id The ID of the awayteam.
     * @param competition_id The ID of the competition.
     * @param date The date of the match.
     * @return The query after the results.
     */
    public static function getIDs( $hometeam_id, $awayteam_id, $competition_id, $date ) {
        $query = "SELECT * FROM `".self::TABLE_MATCH."` WHERE hometeam_id = ? AND awayteam_id = ? AND competition_id = ? AND date = ?";
        $values = array( $hometeam_id, $awayteam_id, $competition_id, $date );
        return DB::select( $query, $values );
    }

    /**
     * @brief Add a match into the database.
     * @param hometeam_id The ID of the hometeam.
     * @param awayteam_id The ID of the awayteam.
     * @param competition_id The ID of the competition.
     * @param date The date of the match.
     * @return The IDs of the given match.
     */
    public static function add( $hometeam_id, $awayteam_id, $competition_id, $date ) {
        $query = "INSERT INTO `".self::TABLE_MATCH."` (hometeam_id, awayteam_id, competition_id, date) VALUES (?, ?, ?, ?)";
        $values = array( $hometeam_id, $awayteam_id, $competition_id, $date );
        DB::insert( $query, $values );
        return self::getIDs( $hometeam_id, $awayteam_id, $competition_id, $date );
    }

    // TODO DOCUMENTIZE
    public static function getRecentMatches($amount){
        // Will return a certain amount of last played matches.
        $results = DB::select("SELECT * FROM `match` WHERE date < CURDATE() ORDER BY date DESC LIMIT ?", array($amount));
        return $results;
    }
    
    public static function getFutureMatches($amount){
        // Will return a certain amount of closest future matches.
        $results = DB::select("SELECT * FROM `match` WHERE date > CURDATE() ORDER BY date LIMIT ?", array($amount));
        return $results;
    }
    
    public static function getScore($matchID){
        $results = DB::select('SELECT 
                                (SELECT COUNT(id) FROM goal WHEREge team_id = `match`.hometeam_id AND match_id = `match`.id) as hometeam_score,
                                (SELECT COUNT(id) FROM goal WHERE team_id = `match`.awayteam_id AND match_id = `match`.id) as awayteam_score
                                FROM `match` WHERE id = ?', array($matchID));
        return $results[0]->hometeam_score." - ".$results[0]->awayteam_score;
    }
    
    public static function get($matchID){
        $results = DB::select("SELECT date,
                                hometeam_id,
                                awayteam_id,
                                (SELECT name FROM team WHERE id = `match`.hometeam_id) AS hometeam,  
                                (SELECT name FROM team WHERE id = `match`.awayteam_id) AS awayteam,
                                (SELECT COUNT(id) FROM goal WHERE team_id = `match`.hometeam_id AND match_id = `match`.id) as hometeam_score,
                                (SELECT COUNT(id) FROM goal WHERE team_id = `match`.awayteam_id AND match_id = `match`.id) as awayteam_score
                                FROM `match` WHERE id = ?", array($matchID));
        return $results[0];
    }
    
    public static function goals($matchID, $teamID){
        $results = DB::select("SELECT time, (SELECT name FROM player WHERE id = goal.player_id) as player FROM goal WHERE match_id = ? AND team_id = ?", array($matchID, $teamID));
        return $results;
    }
    
    public static function cards($matchID, $teamID){
        $results = DB::select("SELECT color, time, (SELECT name FROM player WHERE player.id = cards.player_id AND player.id IN (SELECT player_id FROM playerPerTeam WHERE team_id = ?)) as player FROM cards WHERE cards.match_id = ?", array($teamID, $matchID));
        return $results;
    }
    

    public static function getScore2($matchID){
        $results = DB::select('SELECT 
                                (SELECT COUNT(id) FROM goal WHERE team_id = `match`.hometeam_id) as hometeam_score,
                                (SELECT COUNT(id) FROM goal WHERE team_id = `match`.awayteam_id) as awayteam_score
                                FROM `match` WHERE id = ?', array($matchID));
        return array($hometeam_score, $awayteam_score);
    }

    public static function getMatchByID($matchID) {
        $results = DB::select('SELECT * FROM `match` WHERE id = ?', array($matchID));
        return $results;
    }

    public static function getMatchByTeams($hometeam_id, $awayteam_id) {
        $results = DB::select('SELECT * FROM `match` WHERE hometeam_id = ? AND awayteam_id = ?', array($hometeam_id, $awayteam_id));
        return $results;
    }

    public static function getMatchByHometeam($hometeam_id) {
        $results = DB::select('SELECT * FROM `match` WHERE hometeam_id = ?', array($hometeam_id));
        return $results;
    }

    public static function getMatchByAwayteam($awayteam_id) {
        $results = DB::select('SELECT * FROM `match` WHERE awayteam_id = ?', array($awayteam_id));
        return $results;
    }

    public static function getMatchByTeamsAndDate($hometeam_id, $awayteam_id, $date) {
        $results = DB::select('SELECT * FROM `match` WHERE hometeam_id = ? AND awayteam_id = ? AND date = ?', array($hometeam_id, $awayteam_id, $date));
		if (empty($results))
			return NULL;
		else
	        return $results[0];
    }
    
    public static function getInfo($rm) {
    		$recentTeamMatches = array();
    		$matchGoals = array();
    		$countryFlags = array();
    
            $hid = Team::getTeambyID($rm->hometeam_id);
            $aid = Team::getTeambyID($rm->awayteam_id);
            array_push($recentTeamMatches, $hid, $aid);
            
            $hGoals = Match::goals($rm->id, $rm->hometeam_id);
            $aGoals = Match::goals($rm->id, $rm->awayteam_id);

			//echo count($hGoals);
			//echo count($aGoals);
			//echo "----";

            array_push($matchGoals, $hGoals, $aGoals);
            
            $hFlag = Country::getCountry($hid[0]->country_id);
            $aFlag = Country::getCountry($aid[0]->country_id);
//            var_dump($hFlag);
//            var_dump($aFlag);
//            echo "+++++";

            array_push($countryFlags, $hFlag, $aFlag);
            
            $match = Match::get($rm->id);
            
            $info = array();
            array_push($info, $matchGoals, $countryFlags, $recentTeamMatches, $match, $rm->id);
            
            return $info;
    }
}

