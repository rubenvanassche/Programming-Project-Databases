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

        try {
            $doc->loadHTMLFile( "http://www.cloford.com/resources/codes/index.htm" );
        } catch ( ErrorException $ee ) {
            // HTTP request failed
            return;
        } // end try-catch

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

        // clear crawler (to avoid memory exhausting)
        $crawler->clear();
        return;
    }

    /**
     * @brief Generator for all country teams in the official FIFA participant 
     * lists.
     * @details For the participant lists, see:
     * http://int.soccerway.com/teams/rankings/fifa/
     *
     * @return An associative array with the following values mapped:
     *          "href"      => $href,
     *          "name"      => $team,
     *          "rank"      => $rank,
     *          "points"    => $points,
     *          "coach"     => $first_name.' '.$last_name,
     *          "logo"      => $logo,
     *          "founded"   => $founded,
     *          "address"   => $address,
     *          "country"   => $country,
     *          "phone"     => $phone,
     *          "fax"       => $fax,
     *          "email"     => $email
     */
    public static function teams_FIFA() {
        // load document
        $doc = new DOMDocument();

        try {
            $doc->loadHTMLFile( "http://int.soccerway.com/teams/rankings/fifa/" );
        } catch ( ErrorException $ee ) {
            // HTTP request failed
            return;
        } // end try-catch

        $crawler = new Crawler();
        $crawler->addDocument( $doc );

        foreach ( $crawler->filterXPath( '//table[contains(@class, fifa_rankings)]/tbody/tr/td/..' ) as $row ) {
            $data = $row->getElementsByTagName( 'td' );

            $rank = $data->item(0);
            if ( empty( $rank ) ) { continue; }
            $rank = trim( $rank->textContent );

            $team = $data->item(1);
            if ( empty( $team ) ) { continue; }
            $team = trim( $team->textContent );

            $points = $data->item(2);
            if ( empty( $points ) ) { continue; }
            $points = trim( $points->textContent );

            $href = $data->item(1)->getElementsByTagName( 'a' );
            $href = $href->item(0)->getAttribute( 'href' );
            if ( empty( $href ) ) { continue; }

            // now navigate to the team page
            $team_page = new DOMDocument();

            try {
                $team_page->loadHTMLFile( "http://int.soccerway.com/".$href );
            } catch ( ErrorException $ee ) {
                // HTTP request failed
                continue;
            } // end try-catch

            $team_crawler = new Crawler();
            $team_crawler->addDocument( $team_page );

            $logo = $team_crawler->filterXPath( '//div[contains(@class, block_team_info)]/div/div[@class="logo"]/img' );
            $logo = empty( $logo->getNode(0) ) ? "" : $logo->getNode(0)->getAttribute( 'src' );

            $founded = $team_crawler->filterXPath( '//div[contains(@class, block_team_info)]/div/div/dl/dd[1]' );
            $founded = empty( $founded->getNode(0) ) ? "" : trim( $founded->getNode(0)->textContent );

            $address = $team_crawler->filterXPath( '//div[contains(@class, block_team_info)]/div/div/dl/dd[2]' );
            $address = empty( $address->getNode(0) ) ? "" : trim( $address->getNode(0)->textContent );

            $country = $team_crawler->filterXPath( '//div[contains(@class, block_team_info)]/div/div/dl/dd[3]' );
            if ( empty( $country->getNode(0) ) ) { continue; }
            $country = trim( $country->getNode(0)->textContent );

            $phone = $team_crawler->filterXPath( '//div[contains(@class, block_team_info)]/div/div/dl/dd[4]' );
            $phone = empty( $phone->getNode(0) ) ? "" : trim( $phone->getNode(0)->textContent );

            $fax = $team_crawler->filterXPath( '//div[contains(@class, block_team_info)]/div/div/dl/dd[5]' );
            $fax = empty( $fax->getNode(0) ) ? "" : trim( $fax->getNode(0)->textContent );

            $email = $team_crawler->filterXPath( '//div[contains(@class, block_team_info)]/div/div/dl/dd[6]' );
            $email = empty( $email->getNode(0) ) ? "" : trim( $email->getNode(0)->textContent );

            $coach_href = $team_crawler->filterXPath( '//table[contains(@class, squad)]/tbody[5]/tr/td[2]/div/a' );
            if ( empty( $coach_href->getNode(0) ) ) { continue; }
            $coach_href = $coach_href->getNode(0)->getAttribute( 'href' );

            // to the coach page to get his full name
            $coach_page = new DOMDocument();

            try {
                $coach_page->loadHTMLFile( "http://int.soccerway.com/".$coach_href );
            } catch ( ErrorException $ee ) {
                // HTTP request failed
                $team_crawler->clear();
                continue;
            } // end try-catch

            $coach_crawler = new Crawler();
            $coach_crawler->addDocument( $coach_page );

            $first_name = $coach_crawler->filterXPath( '//div[contains(@class, block_player_passport)]/div/div/div/div/dl/dd[1]' );
            if ( empty( $first_name->getNode(0) ) ) { continue; }
            $first_name = trim( $first_name->getNode(0)->textContent );

            $last_name = $coach_crawler->filterXPath( '//div[contains(@class, block_player_passport)]/div/div/div/div/dl/dd[2]' );
            if ( empty( $last_name->getNode(0) ) ) { continue; }
            $last_name = trim( $last_name->getNode(0)->textContent );

            yield array(
                "href"      => $href,
                "name"      => $team,
                "rank"      => $rank,
                "points"    => $points,
                "coach"     => $first_name.' '.$last_name,
                "logo"      => $logo,
                "founded"   => $founded,
                "address"   => $address,
                "country"   => $country,
                "phone"     => $phone,
                "fax"       => $fax,
                "email"     => $email
            );

            $coach_crawler->clear();
            $team_crawler->clear();
        } // end foreach

        // clear crawler to avoid memory exhausting
        $crawler->clear();
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
