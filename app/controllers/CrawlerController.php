<?php
include("../../lib/crawlers/simple_html_dom.php");

/**
 * @class CrawlerController
 * @brief Crawl data from site and put dem shit into the databases with more 
 * shits.
class CrawlerController extends BaseController {
    // will be putted soon
}
*/

/**
 * @brief Generator for all teams
 * @details Based the teams on http://int.soccerway.com/teams/rankings/fifa/
 */
function teams() {
    // load the page
    $page = new simple_html_dom();
    $page->load_file("http://int.soccerway.com/teams/rankings/fifa/");

    foreach ( $page->find("table.fifa_rankings tbody tr") as $entry ) {
        $rank = $entry->find("td.rank");
        $country = $entry->find("td.team a");
        $points = $entry->find("td.points");

        yield array(
            "rank"      => $rank[0]->plaintext,
            "country"   => $country[0]->plaintext,
            "points"    => $points[0]->plaintext,
            "href"      => $country[0]->href,
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
function players( $team ) {
    // load the page
    $page = new simple_html_dom();
    $url = "http://int.soccerway.com/".$team."/squad/";
    $page->load_file( $url );

    foreach ( $page->find("div.squad-container table.squad tbody tr") as $entry ) {
        $name = $entry->find("td.name a");

        yield array(
            "name"      => $name[0]->plaintext,
            "href"      => $name[0]->href,
        );
    } // end foreach

    // clear page to avoid memory exhausting
    $page->clear();
}

# This one doesn't work...
#foreach ( teams() as $team ) {
#    echo $team["rank"].' '.$team["country"].' '.$team["points"].' '."\n";
#
#    foreach ( players( $team["href"] ) as $player ) {
#        echo "\t\t".$player["name"]."\n";
#    }
#}

# .. but this one does.. You can parse once, but not 2 at a time, apparently
# WTF FUCK YOU PHP!
foreach ( players( "/teams/germany/germany/1037/" ) as $player ) {
    echo $player["name"]."\n";
}
