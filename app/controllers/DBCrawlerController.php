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
    public function update_team( $team ) {
        $name = $team["name"];
        $country = $team["name"]; // TODO update to 'country'
        $coach = "Test Coach";
        $points = $team["points"];

        try {
            $this->db->addTeam( $name, $country, $coach, $points);
        } catch ( MissingFieldException $mfe ) {

            if ( $country == $mfe->missing ) {
                // TODO add actual continent instead of country
                // TODO abbreviation
                $this->db->addContinent( $country );
                $this->db->addCountry( $country, $country, strtoupper(substr( $country, 0, 3 ) ) );
                return $this->update_team( $team );
            } else if ( $coach == $mfe->missing ) {
                $this->db->addCoach( $coach );
                return $this->update_team( $team );
            } else {
                // don't know what's missing
                throw $mfe;
            } // end if-else

        } catch ( DuplicateException $de ) {
            // already added
            return;
        } catch ( InsertException $ie ) {
            throw $ie;
        } // end try-catch
    }

    /**
     * @brief Update the FIFA rankings.
     */
    public function update_FIFA_rank() {
        foreach ( $this->crawler->teams_FIFA() as $team ) {
            $this->update_team( $team );
            break;
        } // end foreach
        return;
    }

    /**
     * @brief Update the World Cup.
     */
    public function update_WorldCup() {
        // first, add the competition
        // TODO

        // then add the teams of the worldcup
        /*
        foreach ( $crawler->teams() as $team ) {
            $name = $team["name"];
            $country = $team["country"];
            $coach = $team["coach"];
            $points  = $teams["points"];

            // be sure the country of the team is already added
            try {
                $db->addCountry(
        } // end foreach
         */
        return;
    }

    /**
     * @brief Update the teams.
     * @details It will also update it's players.
    public function updateTeams() {
        $crawler = new CrawlerController();
        $db = new Stats();

        foreach ( $crawler->teams() as $team ) {
            $db->addTeam(
                $team["country"],
                $team["country"],
                "banana",
                $team["points"]
            );
            # TODO get coach

            if ( empty($team["href"]) ) { continue; }

            foreach ( $crawler->players( $team["href"] ) as $player ) {
                $db->addPlayer( $player["name"], false);
                $db->addPlayerPerTeam(
                    $player["name"],
                    $team["country"]
               );
            } // end foreach
        } // end foreach

        return;
    }

     * @brief Update all the matches.
    public function updateMatches() {
        $crawler = new CrawlerController();
        $db = new Stats();

        foreach( $crawler->matches() as $match ) {
            try {
            $db->addTeam(
                $match["team0"],
                $match["team0"],
                "banana",
                0
            );
            } catch (Exception $d) {
                // ignore
            }

            try {
            $db->addTeam(
                $match["team1"],
                $match["team1"],
                "banana",
                0
            );
            } catch (Exception $d) {
                // ignore
            }

            try {
            $db->addTeamPerCompetition($match["team0"], "World Cup");
            $db->addTeamPerCompetition($match["team1"], "World Cup");

            $db->addMatch(
                $match["team0"],
                $match["team1"],
                "World Cup",
                $match["status"]
           );
            } catch (Exception $d) {
                // ignore
            }
        } // end foreach

        return;
    }
     */
}
