<?php

/**
 * @class Country
 * @brief Core data model of a country.
 */
class Country {

    /**
     * @var TABLE_COUNTRY
     * @brief The country table.
     */
    const TABLE_COUNTRY = "country";

    /**
     * @var name
     * @brief The name of the country.
     */
    public $name;

    /**
     * @var continent_id
     * @brief The ID of the continent the country belongs to.
     */
    public $continent_id;

    /**
     * @var abbreviation
     * @brief The abbreviation of the country.
     */
    public $abbreviation;

    /**
     * @brief Get the country by name.
     * @param name The name of the country.
     * @return The result after the query.
     */
    public static function getIDsByName( $name ) {
        $query = "SELECT id FROM `".self::TABLE_COUNTRY."` WHERE name = ?";
        $values = array( $name );
        return DB::select( $query, $values );
    }

    /**
     * @brief Add a country into the data model.
     * @param country The country object.
     * @return The id of the continent.
     */
    public static function add( $country ) {
        $name = $country->name;
        $continent_id = $country->continent_id;
        $abbreviation = $country->abbreviation;

        $query = "INSERT INTO `".self::TABLE_COUNTRY."` (name, continent_id, abbreviation) VALUES (?, ?, ?)";
        $values = array( $name, $continent_id, $abbreviation );

        DB::insert( $query, $values );

        return self::getIDsByName( $name );
    }

    /**
     * @brief Get the country by id.
     * @param id The ID of the country.
     * @return The results after the query.
     */
    public static function getCountry( $id ) {
        $query = "SELECT * FROM `".self::TABLE_COUNTRY."` WHERE id = ?";
        $values = array( $id );

        return DB::select( $query, $values );
    }

}
