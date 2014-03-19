<?php
include("../../lib/crawlers/simple_html_dom.php");

/**
 * @class CrawlerController
 * @brief Crawl data from site and put dem shit into the databases with more 
 * shits.
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
            $rank = $entry->find("td.rank");
            $country = $entry->find("td.team a");
            $points = $entry->find("td.points");

            yield array(
                "rank"      => trim( $rank[0]->plaintext ),
                "country"   => trim( $country[0]->plaintext ),
                "points"    => trim( $points[0]->plaintext ),
                "href"      => trim( $country[0]->href ),
            );
        } // end foreach

        $page->clear();
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
            $name = $entry->find("td.name a");

            yield array(
                "name"      => trim( $name[0]->plaintext ),
                "href"      => trim( $name[0]->href ),
            );
        } // end foreach

        // clear page to avoid memory exhausting
        $page->clear();
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
            $date = $entry->find("td.date");
            $teamA = $entry->find("td.team-a a");
            $status = $entry->find("td.status a");
            $teamB = $entry->find("td.team-b a");

            yield array(
                "date"      => trim( $date[0]->plaintext ),
                "team0"     => trim( $teamA[0]->plaintext ),
                "status"    => trim( $status[0]->plaintext ),
                "team1"     => trim( $teamB[0]->plaintext ),
            );
        } // end foreach

        // clear page to avoid memory exhausting
        $page->clear();
    }
}


#$crawler = new CrawlerController();

# This one doesn't work...
#foreach ( $crawler->teams() as $team ) {
#    echo $team["rank"].' '.$team["country"].' '.$team["points"].' '."\n";
#
#    if ( empty($team["href"]) ) { continue; }
#
#    foreach ( $crawler->players( $team["href"] ) as $player ) {
#        echo "\t\t".$player["name"]."\n";
#    }
#}

# .. but this one does.. You can parse once, but not 2 at a time, apparently
# WTF FUCK YOU PHP!
#foreach ( $crawler->players( "/teams/germany/germany/1037/" ) as $player ) {
#    echo $player["name"]."\n";
#}

#foreach( $crawler->matches() as $match ) {
#    echo $match["date"].' '.$match["team0"].' '.$match["status"].' '.$match["team1"].' '."\n";
#}
