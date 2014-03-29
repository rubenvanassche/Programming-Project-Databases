<?php

/**
 * @class Coach
 * @brief Core data model of Coach.
 */
class Coach {

    /**
     * @var TABLE_COACH
     * @brief The table of the coaches.
     */
    const TABLE_COACH   = "coach";

    /**
     * @brief Get the coach IDs by name.
     *
     * @param name The name of the coaches.
     *
     * @return The result after the query.
     */
    public static function getIDsByName( $name ) {
        $query = "SELECT id FROM `".self::TABLE_COACH."` WHERE name = ?";
        $values = array( $name );
        return DB::select( $query, $values );
    }

    /**
     * @brief Add a coach to the data model.
     *
     * @param name The name of the coach.
     *
     * @return The ID's named after the coaches.
     */
    public static function add( $name ) {
        $query = "INSERT INTO `".self::TABLE_COACH."` (name) VALUES (?)";
        $values = array( $name );

        DB::insert( $query, $values );

        return self::getIDsByName( $name );
    }

}
