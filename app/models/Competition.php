<?php

/**
 * @class Competition
 * @brief Core data model of a competition.
 */
class Competition {

    /**
     * @var TABLE_COMPETITION
     * @brief The continent table.
     */
    const TABLE_COMPETITION             = "competition";

    /**
     * @var TABLE_TEAM_PER_COMPETITION
     * @brief The link between team and competition.
     */
    const TABLE_TEAM_PER_COMPETITION    = "teamPerCompetition";

    /**
     * @brief Get the competition ID by name.
     * @param name The name of the competition.
     * @return The result after the query.
     */
    public static function getIDsByName( $name ) {
        $query = "SELECT id FROM `".self::TABLE_COMPETITION."` WHERE name = ?";
        $values = array( $name );
        return DB::select( $query, $values );
    }

    /**
     * @brief Add a competition into the data model.
     * @param name The name of the competition.
     * @return The id of the competition.
     */
    public static function add( $name ) {
        $query = "INSERT INTO `".self::TABLE_COMPETITION."` (name) VALUES (?)";
        $values = array( $name );

        DB::insert( $query, $values );

        return self::getIDsByName( $name );
    }

    /**
     * @brief Link a team to a competition.
     * @param team_id The team ID
     * @param competition_id The competition ID
     * @return True if new link created, False otherwise.
     */
    public static function linkTeam( $team_id, $competition_id ) {
        // first check whether the link was already created
        $query = "SELECT * FROM `".self::TABLE_TEAM_PER_COMPETITION."` WHERE team_id = ? AND competition_id = ?";
        $values = array( $team_id, $competition_id );
        if ( !empty( DB::select( $query, $values ) ) ) return False;

        $query = 'INSERT INTO `'.self::TABLE_TEAM_PER_COMPETITION.'` (team_id, competition_id) VALUES (?, ?)';
        DB::insert( $query, $values );
        return True;
    }

}
