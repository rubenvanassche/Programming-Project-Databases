<?php

/**
 * @class Player
 * @brief Core data model of a player.
 */
class Player {

    /**
     * @var TABLE_PLAYER
     * @brief The table of the players.
     */
    const TABLE_PLAYER   = "player";

    /**
     * @brief Get the player IDs by name.
     * @param name The name of the players.
     * @return The result after the query.
     */
    public static function getIDsByName( $name ) {
        $query = "SELECT id FROM `".self::TABLE_PLAYER."` WHERE name = ?";
        $values = array( $name );

        return DB::select( $query, $values );
    }

    /**
     * @brief Add a player to the data model.
     * @param name The name of the player.
     * @return The ID's named after the players.
     */
    public static function add( $name ) {
        $query = "INSERT INTO `".self::TABLE_PLAYER."` (name) VALUES (?)";
        $values = array( $name );

        DB::insert( $query, $values );

        return self::getIDsByName( $name );
    }

    /**
     * @brief Get the player by name.
     * @param name The name of the player.
     * @return The results after the query.
     */
    public static function getPlayer( $id ) {
        $query = "SELECT * FROM `".self::TABLE_PLAYER."` WHERE id = ?";
        $values = array( $id );

        return DB::select( $query, $values );
    }

    /**
     * @brief Get the goals of the player with the given player ID.
     * @param id The player ID.
     * @return The result after the query.
     */
    public static function goals( $id ) {
        $query = "SELECT goal.time,
            goal.match_id,
            `match`.date,
            (SELECT name FROM team WHERE team.id = `match`.hometeam_id) as hometeam,
            (SELECT name FROM team WHERE team.id = `match`.awayteam_id) as awayteam
            FROM `match`, goal WHERE `match`.id = goal.match_id AND goal.player_id = ?";
        $values = array( $id );

        return DB::select( $query, $values );
    }

    /**
     * @brief Count the goals made by a certain player.
     * @param id The player ID.
     * @return The amount of goals made by a player.
     */
    public static function countGoals( $id ) {
        $query = "SELECT COUNT(id) as count FROM goal WHERE player_id = ?";
        $values = array( $id );

        $result = DB::select( $query, $values );

        // 0 if player id not in the table.
        return ( empty( $result ) ) ? 0 : $result[0]->count;
    }

    /**
     * @brief Get the cards of the player.
     * @param id The player id.
     * @return The results after the query.
     */
    public static function cards( $id ){
        $query = "SELECT cards.time, 
            cards.color,
            cards.match_id,
            (SELECT date FROM `match` WHERE  `match`.id = cards.match_id) as date,
            (SELECT name FROM team,`match`  WHERE  team.id = `match`.hometeam_id AND `match`.id = cards.match_id) as hometeam,
            (SELECT name FROM team,`match`  WHERE  team.id = `match`.awayteam_id AND `match`.id = cards.match_id) as awayteam
            FROM cards WHERE player_id = ? ORDER BY date desc, time asc";
        $values = array( $id );

        return DB::select( $query, $values );
    }

    /**
     * @brief Get the player biography.
     * @param name The name of the player.
     * @return The biography (summary) of the player.
     */
    public static function getPlayerText( $name ) {
	
		$arr = str_word_count($name, 1);
		$name = $arr[0] . " " . $arr[1];
		
	    $jsonurl = "http://en.wikipedia.org/w/api.php?action=query&prop=extracts&format=json&exsentences=5&exlimit=10&exintro=&exsectionformat=plain&titles=" . urlencode( $name );
        $json = file_get_contents( $jsonurl );
        $decodedJSON = json_decode( $json, true, JSON_UNESCAPED_UNICODE );
        
        foreach ($decodedJSON['query']['pages'] as $key => $value) {
            $pagenr = $key;
        } // end foreach
        
        try {
            return $decodedJSON['query']['pages'][$pagenr]['extract'];
        } catch (Exception $e) {
            return "No summary available.";
        } // end try-catch
    }

    /**
     * @brief Get the URL of the player.
     * @param name The name of the player.
     * @return The URL of the player image.
     */
    public static function getPlayerImageURL( $name ) {
	
		$arr = str_word_count($name, 1);
		$name = $arr[0] . " " . $arr[1];
		
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
