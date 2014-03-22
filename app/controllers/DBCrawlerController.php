<?php

/**
 * @class DBCrawlerController
 * @brief Put data shit from crawler into the databases with more shits.
 */
class DBCrawlerController extends BaseController {

    /**
     * @brief Update the country.
     */
    private static function update_country( $item ) {
        $continent = $item["continent"];
        $country = $item["country"];
        $abbreviation = $item["abbreviation"];

        try {
            Stats::addCountry( $country, $continent, $abbreviation );
        } catch ( MissingFieldException $mfe ) {

            if ( $continent == $mfe->missing ) {
                Stats::addContinent( $continent );
                return self::update_country( $item );
            } else {
                throw $mfe;
            } // end if-else

        } catch ( DuplicateException $de ) {
            // oh, already added into the database
        } // end try-catch

        return;
    }

    /**
     * @brief Update the list of countries and continents.
     */
    public static function update_countries() {
        foreach ( CrawlerController::countries() as $item ) {
            self::update_country( $item );
        } // end foreach

        return;
    }

    /**
     * @brief update the team.
     *
     * @param team The team to be updated.
     */
    private static function update_team( $team ) {
        $name = $team["name"];
        $country = $team["country"];
        $coach = $team["coach"];
        $points = $team["points"];

        try {
            Stats::addTeam( $name, $country, $coach, $points );
        } catch ( MissingFieldException $mfe ) {

            if ( $coach == $mfe->missing ) {
                Stats::addCoach( $coach );
                return self::update_team( $team );
            } else {
                // cannot add country because you'll need to know the continent
                throw $mfe;
            } // end if-else

        } catch ( DuplicateException $de ) {
            // oh, already in the database
        } // end try-catch

        return;
    }

    /**
     * @brief Update the FIFA rankings.
     */
    public static function update_FIFA_rank() {
        foreach ( CrawlerController::teams_FIFA() as $team ) {
            self::update_team( $team );
        } // end foreach

        return;
    }
}
