<?php

/**
 * @class Team
 * @brief The core data model of a team.
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
     * @var name
     * @brief The name of the team.
     */
    public $name;

    /**
     * @var country_id
     * @brief The id of the country this team belongs to.
     */
    public $country_id;

    /**
     * @var coach_id
     * @brief The id of the coach coaching this team.
     */
    public $coach_id;

    /**
     * @var points
     * @brief The FIFA points of this team.
     */
    public $points;

    /**
     * @brief Get the IDs of the team by inputting the name only.
     * @param name The name of the team.
     * @return Results after the query.
     */
    public static function getIDsByName( $name ) {
        $query = "SELECT id FROM `".self::TABLE_TEAM."` WHERE name = (?)";
        $values = array( $name );

        return DB::select( $query, $values );
    }

    /**
     * @brief add a team into the data model.
     * @param team The team object.
     * @return The IDs of the team just added.
     */
    public static function add( $team ) {
        $name = $team->name;
        $coach_id = $team->coach_id;
        $country_id = $team->country_id;
        $points = ( empty( $team->points ) ) ? 0 : $team->points;

        $query = ( empty( $coach_id ) ) ? "INSERT INTO `".self::TABLE_TEAM."` (name, country_id, fifapoints) VALUES ( ?, ?, ?)" : "INSERT INTO `".self::TABLE_TEAM."` (name, country_id, coach_id, fifapoints) VALUES ( ?, ?, ?, ?)";
        $values = ( empty( $coach_id ) ) ? array( $name, $country_id, $points ) : array( $name, $country_id, $coach_id, $points );

        DB::insert( $query, $values );

        return self::getIDsByName( $name );
    }

    /**
     * @brief link a player to a team.
     * @param player_id The player ID.
     * @param team_id The team ID.
     * @return True if new link created, False otherwise.
     */
    public static function linkPlayer( $player_id, $team_id ) {
        // first check whether the link was already created
        $query = "SELECT * FROM `".self::TABLE_PLAYER_PER_TEAM."` WHERE player_id = ? AND team_id = ?";
        $values = array( $player_id, $team_id );
        if ( !empty( DB::select( $query, $values ) ) ) return False;

        $query = 'INSERT INTO `'.self::TABLE_PLAYER_PER_TEAM.'` (player_id, team_id) VALUES (?, ?)';
        DB::insert( $query, $values );
        return True;
    }

    /**
     * @brief Get the team by id.
     * @param id The id of the team.
     * @return Results after the query.
     */
    public static function getTeambyID( $id ){
        $query = "SELECT * FROM `".self::TABLE_TEAM."` WHERE id = ?";
        $values = array( $id );

        return DB::select( $query, $values );
    }

    /**
     * @brief Get all the teams.
     * @return Results after the query.
     */
    public static function getAll(){
        $query = "SELECT * FROM `".self::TABLE_TEAM."`";

        return DB::select( $query );
    }

    /**
     * @brief Get the team of the player (by ID).
     * @param playerID The ID of the player.
     * @return Result after the query.
     */
    public static function getTeambyPlayerID( $playerID ) {
        // query for teamID
        $query = "SELECT team_id FROM `".self::TABLE_PLAYER_PER_TEAM."` WHERE player_id = ?";
        $values = array( $playerID );

        $teamID = DB::select( $query, $values );

        return ( empty( $teamID ) ) ? NULL : Team::getTeambyID( $teamID[0]->team_id );
    }

    /**
     * @brief Get all the players of a given team.
     * @param teamID The ID of the team.
     * @return Array of the players.
     */
    public static function getPlayers( $teamID ) {
        // query for player ID
        $query = "SELECT player_id FROM`".self::TABLE_PLAYER_PER_TEAM."` WHERE team_id = ?";
        $values = array( $teamID );

        $playerIDs = DB::select( $query, $values );

        $players = array();
        foreach ( $playerIDs as $playerID ) {
            // query for player
            $query = "SELECT * FROM `".Player::TABLE_PLAYER."` WHERE id = ?";
            $values = array( $playerID->player_id );

            $player = DB::select( $query, $values );

            // add player
            array_push($players, $player);
        } // end foreach
        
        return $players;
    }

    /**
     * @brief Get all the FIFA points of each international teams.
     * @return array where each country is mapped to a point.
     */
    public static function getFIFAPoints() {
        $query = "SELECT name, fifapoints FROM `".self::TABLE_TEAM."`";

        $records = DB::select( $query );

        $points = array();
        foreach ( DB::select( $query ) as $row ) {
            $thesePoints = array(
                "name"      => $row->name,
                "points"    => $row->fifapoints,
            );

            array_push( $points, $thesePoints );
        } // end foreach

        return $points;
    }

    /**
     * @brief Get the first best teams.
     * @param limit The limit.
     * @return Results after the query.
     */
    public static function getTopTeams($limit = ''){
        $limit = ( '' != $limit && is_numeric( $limit ) ) ? "LIMIT ".$limit : $limit;

        $query = "SELECT team.id, team.name, team.fifapoints, country.abbreviation FROM team, country WHERE country.id = team.country_id ORDER BY team.fifapoints desc ".$limit;
        return DB::select( $query );
    }

    /**
     * @brief Get the matches of a given team.
     * @param teamID The ID of the team.
     * @return Results after the query.
     */
    public static function getMatches( $teamID ){
        $query = "SELECT `match`.date,
            `match`.id as match_id,
            (SELECT name FROM team WHERE team.id = `match`.hometeam_id) as hometeam,
            (SELECT name FROM team WHERE team.id = `match`.awayteam_id) as awayteam
            FROM `match` WHERE hometeam_id = ? OR awayteam_id = ?";
        $values = array( $teamID, $teamID );

        return DB::select( $query, $values );
    }

    /**
     * @brief Get the team's summary.
     * @param name The name of the team.
     * @return The team's biography (summary).
     */
    public static function getTeamText( $name ){
        $jsonurl = "http://en.wikipedia.org/w/api.php?action=query&prop=extracts&format=json&exsentences=5&exlimit=10&exintro=&exsectionformat=plain&titles=" . urlencode( $name );

        $json = file_get_contents($jsonurl);
        $decodedJSON = json_decode($json, true, JSON_UNESCAPED_UNICODE);
        
        foreach ($decodedJSON['query']['pages'] as $key => $value) {
            $pagenr = $key;
        } // end foreach

        try {
            return $decodedJSON['query']['pages'][$pagenr]['extract'];
        }
        catch (Exception $e) {
            return "No summary available.";
        } // end try-catch
    }

    /**
     * @brief Get the team image URL.
     * @param name The name of the team.
     * @return The image URL of the team.
     */
    public static function getTeamImageURL( $name ) {
        $jsonurl = "http://en.wikipedia.org/w/api.php?action=query&titles=" . urlencode( $name ) . "&prop=pageimages&format=json&pithumbsize=300";

        $json = file_get_contents($jsonurl);
        $decodedJSON = json_decode($json, true, JSON_UNESCAPED_UNICODE);

        foreach ($decodedJSON['query']['pages'] as $key => $value) {
            $pagenr = $key;
        } // end foreach
        
        try {
            return $decodedJSON['query']['pages'][$pagenr]['thumbnail']['source'];
        }
        catch (Exception $e) {
            return "https://encrypted-tbn1.gstatic.com/images?q=tbn:ANd9GcQDBQGDMwwKrrjyl5frVZhTV1qDP6u3YtPhFW_XM6zjdStHkm0";
        } // end try-catch
    }

}
