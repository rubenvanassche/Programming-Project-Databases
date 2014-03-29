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
     * @brief Request the page.
     * @details Sometimes, the site is too busy, but you can then send another 
     * request again.
     *
     * @param url The url to be requested.
     * @param time_limit The maximum time limit (in seconds) that has to be passed,
     * default is 5 seconds.
     *
     * @return DOMDocument or NULL if time_limit has been exceeded.
     */
    public static function request( $url, $time_limit=5 ) {
        $start = time();
        $stop = time();

        do {
            try {
                $doc = new DOMDocument();
                $doc->loadHTMLFile( $url );
                return $doc;
            } catch ( ErrorException $ee ) {
                $stop = time();
            } // end try-catch
        } while ( $stop - $start <= $time_limit );

        return NULL;
    }

    /**
     * @brief Scrape all countries accompanied with the ISO3 abbreviation and
     * it's continent.
     * @details A complete list can be found at 
     * http://www.cloford.com/resources/codes/index.htm
     * 
     * @return True if succeed, False otherwise.
     */
    public static function countries() {
        // load document
        $doc = self::request( "http://www.cloford.com/resources/codes/index.htm" );
        if ( empty( $doc ) ) return False;    // request failed

        $data = new Crawler();
        $data->addDocument( $doc );

        foreach ( $data->filterXPath( "//table[@class=\"outlinetable\"]/tr/td/..") as $row ) {
            // skip empty rows
            if ( 0 == $row->childNodes->length ) continue;

            $country = $row->childNodes->item(4);
            if ( empty( $country ) ) continue;
            $country = trim( $country->textContent );

            // skip if country is already added
            if ( !empty( Country::getIDsByName( $country ) ) ) continue;

            $continent = $row->childNodes->item(0);
            if ( empty( $continent ) ) continue;
            $continent = trim( $continent->textContent );

            $abbreviation = $row->childNodes->item(12);
            if ( empty( $abbreviation ) ) continue;
            $abbreviation = trim( $abbreviation->textContent );

            // add continent if necessary
            $continent_ids = Continent::getIDsByName( $continent );
            if ( empty( $continent_ids ) ) $continent_ids = Continent::add( $continent );

            // okay, add the country
            Country::add( $country, $continent_ids[0]->id, $abbreviation );
        } // end foreach

        // clear cache to avoid memory exhausting
        $data->clear();
        return True;
    }

    public static function scrape() {
        // first, do the countries and continents
        /*
        // start from the FIFA ranking
        $fifa_rank = self::request( "http://int.soccerway.com/teams/rankings/fifa/" );
        if ( empty( $fifa_rank ) ) continue;

        $teams = new Crawler();
        $teams->addDocument( $fifa_rank );

        $missing_countries = array();

        foreach ( $teams->filterXPath( "//table[contains(@class, fifa_rankings)]/tbody/tr/td/.." ) as $team ) {
            // skip empty rows
            if ( 0 == $team->childNodes->length ) continue;

            $team_name = $team->childNodes->item(2);
            if ( empty( $team_name ) ) continue;
            $team_name = trim( $team_name->textContent );

            $team_points = $team->childNodes->item(4);
            if ( empty( $team_points ) ) continue;
            $team_points = trim( $team_points->textContent );

            $team_href = $team->getElementsByTagName( 'a' );
            if ( empty( $team_href ) ) continue;
            $team_href = $team_href->item(0)->getAttribute( "href" );

            // load team page
            $team_info = self::request( "http://int.soccerway.com/".$team_href );
            if ( empty( $team_info ) ) continue;

            $team = new Crawler();
            $team->addDocument( $team_info );

            $team_country = $team->filterXPath( "//div[contains(@class, block_team_info)]/div/div/dl/dd[3]" )->getNode(0);
            if ( empty( $team_country ) ) continue;
            $team_country = trim( $team_country->textContent );
            $team_country_id = Country::getIDsByName( $team_country );
            if ( empty( $team_country_id ) ) {
                $missing_countries[] = $team_country;
                continue;
            }
            $team_country_id = $team_country_id[0]->id;

            $team_coach_href = $team->filterXPath( "//table[contains(@class, squad)]/tbody[5]/tr/td/a/img/.." )->getNode(0);
            if ( empty( $team_coach_href ) ) continue;
            $team_coach_href = $team_coach_href->getAttribute( "href" );

            $coach_info = self::request( "http://int.soccerway.com/".$team_coach_href );

            $coach = new Crawler();
            $coach->addDocument( $coach_info );

            $coach_first_name = $coach->filterXPath( "//div[contains(@class, block_player_passport)]/div/div/div/div/dl/dd[1]" )->getNode(0);
            if ( empty( $coach_first_name ) ) continue;
            $coach_first_name = trim( $coach_first_name->textContent );

            $coach_second_name = $coach->filterXPath( "//div[contains(@class, block_player_passport)]/div/div/div/div/dl/dd[2]" )->getNode(0);
            if ( empty( $coach_second_name ) ) continue;
            $coach_second_name = trim( $coach_second_name->textContent );

            $coach_name = $coach_first_name.' '.$coach_second_name;
            var_dump( $coach_name );

            // clear caches
            $coach->clear();
            $team->clear();
        } // end foreach

        foreach ($missing_countries as $country ) {
            echo $country."<br>";
        } 
        // clear crawler cache to avoid memory exhausting
        $teams->clear();
             */
        return;
    }

    /**
            // okay, get the player
            for ( $index = 1; $index <= 5; $index++ ) {
                foreach ( $team_crawler->filterXPath( "//table[contains(@class, squad)]/tbody[".$index."]/tr/td/a/img/.." ) as $player_href ) {
                    $player = array();

                    // to the player page to get his full name
                    $player_page = new DOMDocument();
                    $player_page->loadHTMLFile( "http://int.soccerway.com/".$player_href->getAttribute( "href" ) );

                    $player_crawler = new Crawler();
                    $player_crawler->addDocument( $player_page );

                    // get his full name
                    $first_name = $player_crawler->filterXPath( "//div[contains(@class, block_player_passport)]/div/div/div/div/dl/dd[1]" )->getNode(0);
                    if ( empty( $first_name ) ) continue;

                    $last_name = $player_crawler->filterXPath( "//div[contains(@class, block_player_passport)]/div/div/div/div/dl/dd[2]" )->getNode(0);
                    if ( empty( $last_name ) ) continue;
                    $player["name"] = trim( $first_name->textContent ).' '.trim( $last_name->textContent );

                    if ( 5 == $index ) {
                        // it's a coach

                    // insert player and link player to team
                    $player_crawler->clear();
                } // end foreach
            } // end for

            $team_crawler->clear();
            break;
        } // end foreach
        echo "<br>AFTER<br>";

        // clear cache to avoid memory exhausting
        $crawler->clear();
        return;
    }
     */

    /**
     * @brief Generator for all teams.
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
    public static function teams() {
        // load document
        $doc = new DOMDocument();

        try {
            request( $doc, "http://int.soccerway.com/teams/rankings/fifa/" );
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
                request( $team_page, "http://int.soccerway.com/".$href );
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
                request( $coach_page, "http://int.soccerway.com/".$coach_href );
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
     */

    /**
     * @brief Generator for all matches.
     * @details Based upon the matches on
     * http://int.soccerway.com/international/world/world-cup/2014-brazil/s6395/
     *
     * @returns Array with info about the match and thus the following values 
     * mapped:
     *          'competition'   => $competition,
     *          'date'          => $date,
     *          'time'          => $time,
     *          'score'         => $score,
     *          'home team'     => $hometeam,
     *          'away team'     => $awayteam,
     */
    public static function matches( $url='http://int.soccerway.com/international/world/world-cup/c72/' ) {
        $doc = new DOMDocument();

        try {
            request( $doc, $url );
        } catch ( ErrorException $ee ) {
            // HTTP request failed
            return;
        } // end try-catch

        $crawler = new Crawler();
        $crawler->addDocument( $doc );

        $competition = $crawler->filterXPath( '//div[contains(@class, block_competition_left_tree)]/ul/li/ul/li/a');
        if ( empty( $competition->getNode(0) ) ) { continue; }
        $competition = 'World Cup '.$competition->getNode(0)->textContent;

        foreach ( $crawler->filterXPath( '//div[contains(@class, block_competition_matches)]/div/table/tbody/tr' ) as $row ) {
            $data = $row->getElementsByTagName( 'td' );

            $date = $data->item(1);
            if ( empty( $date ) ) { continue; }
            $date = DateTime::createFromFormat('j/m/y', $date->textContent)->format('Y-m-d');

            $hometeam = $data->item(2);
            if ( empty( $hometeam ) ) { continue; }
            $hometeam = trim( $hometeam->textContent );

            $awayteam = $data->item(4);
            if ( empty( $awayteam ) ) { continue; }
            $awayteam = trim( $awayteam->textContent );

            $status = $data->item(3);
            if ( empty( $status ) ) { continue; }
            $time =  (1 == substr_count( $status->textContent, ':' ) ) ? trim( $status->textContent ) : "";
            $score = (1 == substr_count( $status->textContent, '-' ) ) ? trim( $status->textContent ) : "0 - 0";

            yield array(
                'competition'   => $competition,
                'date'          => $date,
                'time'          => $time,
                'score'         => $score,
                'home team'     => $hometeam,
                'away team'     => $awayteam,
            );
        } // end foreach

        // clear cache to avoid memory exhausting
        $crawler->clear();
        return;
    }
}
