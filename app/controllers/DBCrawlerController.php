<?php

/**
 * @class DBCrawlerController
 * @brief Put data shit from crawler into the databases with more shits.
 */
class DBCrawlerController extends BaseController {

    /**
     * @brief Update the teams.
     * @details It will also update it's players.
     */
    public function updateTeams() {
        $crawler = new CrawlerController();
        $db = new Stats();

        foreach ( $crawler->teams() as $team ) {
            $db->addTeam(
                $team["country"],
                $team["country"],
                "banana",
                $team['points']
            );
            # TODO get coach

            if ( empty($team["href"]) ) { continue; }

            foreach ( $crawler->players( $team["href"] ) as $player ) {
            	$db->addPlayer($player['name'], false);
                $db->addPlayerPerTeam(
                    $player["name"],
                    $team["country"]
               );
            } // end foreach
        } // end foreach

        return;
    }

    /**
     * @brief Update all the matches.
     */
    public function updateMatches() {
        $crawler = new CrawlerController();
        $db = new Stats();

        foreach( $crawler->matches() as $match ) {
            $db->addMatch(
                $match["team0"],
                $match["team1"],
                "World Cup"
            );
        } // end foreach

        return;
    }
}
