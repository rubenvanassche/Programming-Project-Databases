<?php

use Symfony\Component\DomCrawler\Crawler;

// don't complain when the HTML document is not valid
libxml_use_internal_errors( true );

/**
 * @class CrawlerController
 * @brief Crawl data from site.
 */
class CrawlerController extends BaseController {

    /**
     * @brief Generator for all countries accompanied with the ISO (3) 
     * abbreviation and it's continent.
     * @details A complete list can be found at
     * http://www.cloford.com/resources/codes/index.htm
     *
     * @return An associative array with the following values mapped:
     *          "country"       => $country,
     *          "continent"     => $continent,
     *          "abbreviation"  => $abbreviation
     */
    public static function countries() {
        // load document
        $doc = new DOMDocument();
        $doc->loadHTMLFile( "http://www.cloford.com/resources/codes/index.htm" );

        $crawler = new Crawler();
        $crawler->addDocument( $doc );

        foreach ( $crawler->filterXPath( '//table[@class="outlinetable"]/tr/td/..') as $row ) {
            $data = $row->getElementsByTagName( 'td' );

            $continent = $data->item(0);
            if ( empty( $continent ) ) { continue; }
            $continent = trim( $continent->textContent );

            $country = $data->item(2);
            if ( empty( $country ) ) { continue; }
            $country = trim( $country->textContent );

            $abbreviation = $data->item(6);
            if ( empty( $abbreviation ) ) { continue; }
            $abbreviation = trim( $abbreviation->textContent );

            yield array(
                "country"       => $country,
                "continent"     => $continent,
                "abbreviation"  => $abbreviation
            );
        } // end foreach

        return;
    }

    /**
     * @brief Generator for all country teams in the official FIFA participant 
     * lists.
     * @details For the participant lists, see:
     * http://int.soccerway.com/teams/rankings/fifa/
     *
     * @return An associative array with the following values mapped:
     *      "href"      => $href,
     *      "name"      => $name,
     *      "rank"      => $rank,
     *      "points"    => $points,
     *      "coach"     => $coach,
     *      "logo"      => $logo,
     *      "founded"   => $founded,
     *      "address"   => $address
     *      "country"   => $country,
     *      "phone"     => $phone,
     *      "fax"       => $fax,
     *      "email"     => $email
     */
    public function teams_FIFA() {
        // load the page
        $page = new simple_html_dom();
        $url = "http://int.soccerway.com/teams/rankings/fifa/";
        $page->load_file( $url );

        foreach ( $page->find("table.fifa_rankings tbody tr") as $entry ) {
            // first, get all the required data
            $name = $entry->find("td.team a", 0);
            if ( empty( $name ) ) { continue; }
            $href = $name->href;

            $rank = $entry->find("td.rank", 0);
            if ( empty( $rank ) ) { continue; }

            $points = $entry->find("td.points", 0);
            if ( empty( $points ) ) { continue; }

            // now navigate to the page of the team
            $team_page = new simple_html_dom();
            $url = "http://int.soccerway.com/".$href;
            $team_page->load_file( $url );

            // also get the required data there
            #$coach = $team_page->find("table.squad tbody", 4);#->find("tr td div a", 0);#->find("td", 1)->find("div a", 0);
            #if ( empty( $coach ) ) { continue; }

            #$content = $team_page->find("div.block_team_info div div dl", 0);
            #if ( empty( $content ) ) { continue; }

            #$country = $team_page->find("div.block_team_info div div dl dd", 2);
            #if ( empty( $country ) ) { continue; }

            // okay, get the optional data now
            #$logo = $team_page->find("div.block_team_info div div.logo img", 0);
            #$founded = $content->find("dd", 0);
            #$address = $content->find("dd", 1);
            #$phone = $content->find("dd", 3);
            #$fax = $content->find("dd", 4);
            #$email = $content->find("dd", 5);

            // use default values or skip team if data not provided
            $name = trim( $name->plaintext );
            $rank = trim( $rank->plaintext );
            $points = trim( $points->plaintext );
            #$coach = trim( $coach->plaintext );
            #$founded = empty( $founded ) ? 0 : trim( $founded->plaintext );
            #$address = empty( $address ) ? "" : trim( $address->plaintext );
            #$country = trim( $country->plaintext );
            #$phone = empty( $founded ) ? "" : trim( $phone->plaintext );
            #$fax = empty( $founded ) ? "" : trim( $fax->plaintext );
            #$email = empty( $founded ) ? "" : trim( $email->plaintext );

            yield array(
                "href"      => $href,
                "name"      => $name,
                "rank"      => $rank,
                "points"    => $points,
                #"coach"     => $coach,
                #"logo"      => $logo,
                #"founded"   => $founded,
                #"address"   => $address
                #"country"   => $country,
                #"phone"     => $phone,
                #"fax"       => $fax,
                #"email"     => $email
            );

        } // end foreach

        // clear page to avoid memory exhausting
        $page->clear();
        return;
    }

    /**
     * @brief Generator for all players in a given team in the World Cup 
     * competition.
     * @details An example of a page where this function is based upon can be found 
     * at http://int.soccerway.com/teams/spain/spain/2137/squad/
     *
     * @param team_href The reference to the page of a team (see $team["href"]).
     * @return An associative array with the following values mapped:
     *      "href"          => [relative link to the players profile]
     *      "first name"    => [players first name]
     *      "second name"   => [players second name]
    public function players_WorldCup( $team_href ) {
        // load the page
        $page = new simple_html_dom();
        $url = "http://int.soccerway.com/".$team_href."/squad/";
        $page->load_file( $url );

        foreach ( $page->find("div.squad-container table.squad tbody tr") as $entry ) {
            $profile = $entry->find("td.name a", 0);

            // skip if one of the required element is empty
            if ( empty( $profile ) ) { continue; }

            $player_page = new simple_html_dom();
            $player_url = "http://int.soccerway.com/".$profile->href;
            $player_page->load_file( $player_url );

            $first_name = $player_page->find("div.block_player_passport div div div div dl dd", 0);
            $second_name = $player_page->find("div.block_player_passport div div div div dl dd", 1);

            // skip if one of the required element is empty
            if ( empty( $first_name ) ) { continue; }
            if ( empty( $second_name ) ) { continue; }

            $href = $profile->href;
            $first_name = trim( $first_name->plaintext );
            $second_name = trim( $second_name->plaintext );

            yield array(
                "href"          => $href,
                "first name"    => $first_name,
                "second name"   => $second_name
            );
        } // end foreach

        // clear page to avoid memory exhausting
        $page->clear();
        return;
    }
     */

    /**
     * @brief Generator for all matches in the World Cup.
     * @details Based upon matches on
     * http://int.soccerway.com/international/world/world-cup/2014-brazil/group-stage/r16351/matches/?ICID=PL_3N_02
     *
     * @return An associative array with the following values mapped:
     *      "href"          => [relative link to the match]
     *      "first team"    => [home team]
     *      "second team"   => [away team]
     *      "date"          => [date of the match]
     *      "time"          => [time of the match or empty if going on]
     *      "score"         => [result or empty if has to be played yet]
    public function matches_() {
        // load the page
        $page = new simple_html_dom();
        $url = "http://int.soccerway.com/international/world/world-cup/2014-brazil/group-stage/r16351/matches/?ICID=PL_3N_02";
        $page->load_file( $url );

        foreach ( $page->find("table.matches tbody tr.match") as $entry ) {
            $href = $entry->find("td.score-time a", 0);
            $first_team = $entry->find("td.team-a a", 0);
            $second_team = $entry->find("td.team-b a", 0);
            $date = $entry->find("td.date", 0);
            $time = $entry->find("td.status", 0);
            $score = $entry->find("td.score", 0);

            // skip if one of the required element is empty
            if ( empty( $href ) ) { continue; }
            if ( empty( $first_team ) ) { continue; }
            if ( empty( $second_team ) ) { continue; }
            if ( empty( $date ) ) { continue; }

            $href = $href->href;
            $first_team = trim( $first_team->plaintext )
            $second_team = trim( $second_team->plaintext )
            $date = $date->plaintext;
            $time = empty( $time ) ? "" : trim( $time->plaintext );
            $score = empty( $score ) ? "" : trim( $score->plaintext );

            yield array(
                "href"          => $href,
                "first team"    => $first_team,
                "second team"   => $second_team,
                "date"          => $date,
                "time"          => $time,
                "score"         => $score
            );
        } // end foreach

        // clear page to avoid memory exhausting
        $page->clear();
        return;
    }
     */
}
