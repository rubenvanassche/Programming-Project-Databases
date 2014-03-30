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
     * @brief Add a match into the database.
     * @param hometeam_id The ID of the hometeam.
     * @param awayteam_id The ID of the awayteam.
     * @param competition_id The ID of the competition.
     * @param date The date of the match.
     * @return True if new match added, False otherwise.
     */
    public static function add( $hometeam_id, $awayteam_id, $competition_id, $date ) {
        // first check whether the match is already added
        $query = "SELECT * FROM `".self::TABLE_MATCH."` WHERE hometeam_id = ? AND awayteam_id = ? AND competition_id = ? AND date = ?";
        $values = array( $hometeam_id, $awayteam_id, $competition_id, $date );
        if ( !empty( DB::select( $query, $values ) ) ) return False;

        $query = "INSERT INTO `".self::TABLE_MATCH."` (hometeam_id, awayteam_id, competition_id, date) VALUES (?, ?, ?, ?)";
        DB::insert( $query, $values );
        return True;
    }

    // TODO DOCUMENTIZE
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
    
    public static function getScore($matchID){
        $results = DB::select('SELECT 
                                (SELECT COUNT(id) FROM goal WHERE team_id = `match`.hometeam_id) as hometeam_score,
                                (SELECT COUNT(id) FROM goal WHERE team_id = `match`.awayteam_id) as awayteam_score
                                FROM `match` WHERE id = ?', array($matchID));
        return $results[0]->hometeam_score." - ".$results[0]->awayteam_score;
    }
    
    public static function get($matchID){
        $results = DB::select("SELECT date,
                                hometeam_id,
                                awayteam_id,
                                (SELECT name FROM team WHERE id = `match`.hometeam_id) AS hometeam,  
                                (SELECT name FROM team WHERE id = `match`.awayteam_id) AS awayteam,
                                (SELECT COUNT(id) FROM goal WHERE team_id = `match`.hometeam_id) as hometeam_score,
                                (SELECT COUNT(id) FROM goal WHERE team_id = `match`.awayteam_id) as awayteam_score
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
        $results = DB::select('SELECT * FROM `match WHERE hometeam_id = ? AND awayteam_id = ?', array($hometeam_id, $awayteam_id));
        return $results;
    }

    public static function getMatchByHometeam($hometeam_id) {
        $results = DB::select('SELECT * FROM `match WHERE hometeam_id = ?', array($hometeam_id));
        return $results;
    }

    public static function getMatchByAwayteam($awayteam_id) {
        $results = DB::select('SELECT * FROM `match WHERE awayteam_id = ?', array($awayteam_id));
        return $results;
    }
}
