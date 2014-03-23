<?php

use Symfony\Component\DomCrawler\Crawler;

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

            if ( $continent == $mfe->missing && Stats::TABLE_CONTINENT == $mfe->table ) {
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
     * @brief Update the team.
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

            if ( $coach == $mfe->missing && Stats::TABLE_COACH == $mfe->table ) {
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
     * @brief Update the teams.
     */
    public static function update_teams() {
        foreach ( CrawlerController::teams() as $team ) {
            self::update_team( $team );
        } // end foreach

        return;
    }

    /**
     * @brief Update the match
     *
     * @param match The match to be updated.
     */
    private static function update_match( $match ) {
        $competition = $match['competition'];
        $date = $match['date'];
        $hometeam = $match['home team'];
        $awayteam = $match['away team'];

        try {
            Stats::addMatch( $hometeam, $awayteam, $competition, $date );
        } catch ( MissingFieldException $mfe ) {

            if ( $competition == $mfe->missing && Stats::TABLE_COMPETITION == $mfe->table ) {
                Stats::addCompetition( $competition );
                return self::update_match( $match );
            } else if ( $hometeam == $mfe->missing && Stats::TABLE_TEAM_PER_COMPETITION == $mfe->table ) {
                // hometeam was not linked to the competition
                Stats::addTeamPerCompetition( $hometeam, $competition );
                return self::update_match( $match );
            } else if ( $awayteam == $mfe->missing && Stats::TABLE_TEAM_PER_COMPETITION == $mfe->table ) {
                // awayteam was not linked to the competition
                Stats::addTeamPerCompetition( $awayteam, $competition );
                return self::update_match( $match );
            } else {
                // other data cannot be inserted automatically
                throw $mfe;
            } // end if-else

        } catch ( DuplicateException $de ) {
            // oh, already added
        } // end try-catch

        return;
    }

    /**
     * @brief Update all the matches.
     */
    public static function update_matches() {
        // first, the current World Cup matches
        foreach ( CrawlerController::matches() as $match ) {
            self::update_match( $match );
        } // end foreach

        // then dive into the archive of the World Cup matches
        $doc = new DOMDocument();

        try {
            $doc->loadHTMLFile( 'http://int.soccerway.com/international/world/world-cup/c72/archive/?ICID=PL_3N_06' );
        } catch ( ErrorException $ee ) {
            // HTTP request failed
            return;
        } // end try-catch

        $crawler = new Crawler();
        $crawler->addDocument( $doc );

        foreach ( $crawler->filterXPath( '//div[contains(@class, block_competition_archive)]/table/tbody/tr') as $row ) {
            $href = $row->getElementsByTagName( 'a' );
            if ( empty( $href ) ) { continue; }
            $href = $href->item(0)->getAttribute( 'href' );

            foreach ( CrawlerController::matches( 'http://int.soccerway.com/'.$href ) as $match ) {
                self::update_match( $match );
            } // end foreach
        } // end foreach

        $crawler->clear();
        return;
    }
}
