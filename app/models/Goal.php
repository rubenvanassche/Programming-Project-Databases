<?php

/**
 * @class Goal
 * @brief Core data model of a goal.
 */
class Goal {

    /**
     * @var TABLE_GOAL
     * @brief The database table of goals.
     */
    const TABLE_GOAL    = "goal";

    /**
     * @brief Get the id of the given goal.
     * @param match_id The ID of the match.
     * @param team_id The ID of the team.
     * @param player_id The ID of the player maked the goal.
     * @param time At which time he has made a goal.
     * @return The result after the query.
     */
    public static function getIDs( $match_id, $team_id, $player_id, $time ) {
        $query = "SELECT id FROM `".self::TABLE_GOAL."` WHERE match_id = ? AND team_id = ? AND player_id = ? AND time = ?";
        $values = array( $match_id, $team_id, $player_id, $time );

        return DB::select( $query, $values );
    }

    /**
     * @brief Add the goal.
     * @param match_id The ID of the match.
     * @param team_id The ID of the team.
     * @param player_id The ID of the player maked the goal.
     * @param time At which time he has made a goal.
     * @return The IDs.
     */
    public static function add( $match_id, $team_id, $player_id, $time ) {
        $query = "INSERT INTO `".self::TABLE_GOAL."` (match_id, team_id, player_id, time) VALUES (?, ?, ?, ?)";
        $values = array( $match_id, $team_id, $player_id, $time );

        DB::insert( $query, $values );

        return self::getIDs( $match_id, $team_id, $player_id, $time );
    }

    /**
     * @brief Get all the home goals of the given match.
     * @param match The queried match.
     * @return Result after the query.
     */
    public static function getHomeGoals( $match ){
        $query = "SELECT * FROM `".self::TABLE_GOAL."` WHERE match_id = ? AND team_id = ?";
        $values = array( $match->id, $match->hometeam_id );

        return DB::select( $query, $values );
    }

    /**
     * @brief Get all the away goals of the given match.
     * @param match The queried match.
     * @return Result after the query.
     */
    public static function getAwayGoals( $match ){
        $query = "SELECT * FROM `".self::TABLE_GOAL."` WHERE match_id = ? AND team_id = ?";
        $values = array( $match->id, $match->awayteam_id );

        return DB::select( $query, $values );
    }

}
