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

        foreach ( $crawler->teams() as $team ) {
            echo $team["rank"].' '.$team["country"].' '.$team["points"].' '."\n";

            if ( empty($team["href"]) ) { continue; }

            # doesn't work from here...
            #foreach ( $crawler->players( $team["href"] ) as $player ) {
            #    echo "\t\t".$player["name"]."\n";
            #} // end foreach
        } // end foreach

        return;
    }

    /**
     * @brief Update all the matches.
     */
    public function updateMatches() {
        $crawler = new CrawlerController();

        foreach( $crawler->matches() as $match ) {
            echo $match["date"].' '.$match["team0"].' '.$match["status"].' '.$match["team1"].' '."\n";
        }
        return;
    }
}
