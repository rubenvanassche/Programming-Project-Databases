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
