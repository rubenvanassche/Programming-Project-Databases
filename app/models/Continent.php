<?php

/**
 * @class Continent
 * @brief Core data model of a continent.
 */
class Continent {

    /**
     * @var TABLE_CONTINENT
     * @brief The continent table.
     */
    const TABLE_CONTINENT   = "continent";

    /**
     * @var name
     * @brief The name of the continent.
     */
    public $name;

    /**
     * @brief Get the continent ID by name.
     * @param name The name of the continent.
     * @return The result after the query.
     */
    public static function getIDsByName( $name ) {
        $query = "SELECT id FROM `".self::TABLE_CONTINENT."` WHERE name = ?";
        $values = array( $name );
        return DB::select( $query, $values );
    }

    /**
     * @brief Add a continent into the data model.
     * @param continent The continent object.
     * @return The id of the continent.
     */
    public static function add( $continent ) {
        $name = $continent->name;

        $query = "INSERT INTO `".self::TABLE_CONTINENT."` (name) VALUES (?)";
        $values = array( $name );

        DB::insert( $query, $values );

        return self::getIDsByName( $name );
    }

}
