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
     * @param name The name of the country.
     * @param continent_id The continent ID of the country it belongs to.
     * @param abbreviation The abbreviation of the country.
     * @return The id of the continent.
     */
    public static function add( $name, $continent_id, $abbreviation ) {
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

	public static function getCountryNames() {
		$countries = DB::select("SELECT id, name FROM ".self::TABLE_COUNTRY);
		foreach ($countries as $country) {
			$result[$country->id] = $country->name;
		}
        return $result;
	}

	public static function getName( $id ) {
		$result = DB::select("SELECT name FROM ".self::TABLE_COUNTRY." WHERE id = ?", array($id));
		return $result[0]->name;
	}
}
