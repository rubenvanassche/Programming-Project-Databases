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
    const TABLE_COMPETITION = "competition";

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

}
