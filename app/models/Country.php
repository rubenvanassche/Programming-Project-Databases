<?php

/**
 * @class Country
 * @brief Core data of country.
 */
class Country {

    /**
     * @var TABLE_COUNTRY
     * @brief The country table.
     */
    const TABLE_COUNTRY = "country";

    /**
     * @brief Get the country by name.
     *
     * @param name The name of the country.
     *
     * @return The result after the query.
     */
    public static function getIDsByName( $name ) {
        $query = "SELECT id FROM country WHERE name = ?";
        $values = array( $name );
        return DB::select( $query, $values );
    }

    /**
     * @brief Add a country into the data model.
     *
     * @param name The name of the country.
     * @param continent_id The id of the country.
     * @param abbreviation The abbreviation of the country.
     *
     * @return The id of the continent.
     */
    public static function add( $name, $continent_id, $abbreviation ) {
        $query = "INSERT INTO `".self::TABLE_COUNTRY."` (name, continent_id, abbreviation) VALUES (?, ?, ?)";
        $values = array( $name, $continent_id, $abbreviation );

        DB::insert( $query, $values );

        return self::getIDsByName( $name );
    }

    // TODO DOCUMENT
    public static function getCountry($id){
        $result = DB::select('SELECT * FROM country WHERE id = ?', array($id));
        return $result;
    }

}
