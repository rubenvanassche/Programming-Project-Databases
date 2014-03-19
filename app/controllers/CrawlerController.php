<?php

/**
 * @class CrawlerController
 * @brief Crawl data from site.
 */
class CrawlerController extends BaseController {

    /**
     * @brief Generator for all teams
     * @details Based upon the teams on
     * http://int.soccerway.com/teams/rankings/fifa/
     */
    public function teams() {
        // load the page
        $page = new simple_html_dom();
        $url = "http://int.soccerway.com/teams/rankings/fifa/";
        $page->load_file( $url );

        foreach ( $page->find("table.fifa_rankings tbody tr") as $entry ) {
            $rank = $entry->find("td.rank", 0);
            $country = $entry->find("td.team a", 0);
            $points = $entry->find("td.points", 0);

            // skip if one of the required element is empty
            if ( empty( $rank ) ) { continue; }
            if ( empty( $country ) ) { continue; }
            if ( empty( $points ) ) { continue; }

            yield array(
                "rank"      => trim( $rank->plaintext ),
                "country"   => trim( $country->plaintext ),
                "points"    => trim( $points->plaintext ),
                "href"      => trim( $country->href ),
            );
        } // end foreach

        // clear page to avoid memory exhausting
        $page->clear();
        return;
    }

    /**
     * @brief Generator for all players in a given team.
     * @details An example of a page where this function is based upon can be found 
     * at http://int.soccerway.com/teams/spain/spain/2137/squad/
     *
     * @param team_href The reference to the page of a team (see $team["href"]).
     */
    public function players( $team ) {
        // load the page
        $page = new simple_html_dom();
        $url = "http://int.soccerway.com/".$team."/squad/";
        $page->load_file( $url );

        foreach ( $page->find("div.squad-container table.squad tbody tr") as $entry ) {
            $name = $entry->find("td.name a", 0);

            // skip if one of the required element is empty
            if ( empty( $name ) ) { continue; }

            $player_page = new simple_html_dom();
            $player_url = "http://int.soccerway.com/".$name->href;
            $player_page->load_file( $player_url );

            $first_name = $player_page->find("div.block_player_passport div div div div dl dd", 0);
            $second_name = $player_page->find("div.block_player_passport div div div div dl dd", 1);
            yield array(
                "name"      => trim( $first_name->plaintext ).' '.trim( $second_name->plaintext ),
                "href"      => trim( $name->href ),
            );
        } // end foreach

        // clear page to avoid memory exhausting
        $page->clear();
        return;
    }

    /**
     * @brief Generator for all matches.
     * @details Based upon matches on
     * http://int.soccerway.com/international/world/world-cup/2014-brazil/group-stage/r16351/matches/?ICID=PL_3N_02
     */
    public function matches() {
        // load the page
        $page = new simple_html_dom();
        $url = "http://int.soccerway.com/international/world/world-cup/2014-brazil/group-stage/r16351/matches/?ICID=PL_3N_02";
        $page->load_file( $url );

        foreach ( $page->find("table.matches tbody tr.match") as $entry ) {
            $date = $entry->find("td.date", 0);
            $teamA = $entry->find("td.team-a a", 0);
            $status = $entry->find("td.status a", 0);
            $teamB = $entry->find("td.team-b a", 0);

            // skip if one of the required element is empty
            if ( empty( $date ) ) { continue; }
            if ( empty( $teamA ) ) { continue; }
            if ( empty( $status ) ) { continue; }
            if ( empty( $teamB ) ) { continue; }

            yield array(
                "date"      => trim( $date->plaintext ),
                "team0"     => trim( $teamA->plaintext ),
                "status"    => trim( $status->plaintext ),
                "team1"     => trim( $teamB->plaintext ),
            );
        } // end foreach

        // clear page to avoid memory exhausting
        $page->clear();
        return;
    }
}
