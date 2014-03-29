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
            if ( empty( Country::getIDsByName( $country ) ) ) Country::add( $country, $continent_ids[0]->id, $abbreviation );
        } // end foreach

        // clear cache to avoid memory exhausting
        $data->clear();
        return True;
    }

    /**
     * @brief Scrape all international teams in the official FIFA participant 
     * lists.
     * @details A complete list can be found at 
     * http://int.soccerway.com/teams/ranking/fifa/
     *
     * @return True if succeed, False otherwise.
     */
    public static function teams() {
        // load document
        $doc = self::request( "http://int.soccerway.com/teams/rankings/fifa/" );
        if ( empty( $doc ) ) return False;  // request failed

        $data = new Crawler();
        $data->addDocument( $doc );

        foreach ( $data->filterXPath( "//table[contains(@class, fifa_rankings)]/tbody/tr/td/.." ) as $row ) {
            // skip empty rows
            if ( 0 == $row->childNodes->length ) continue;

            $team = $row->childNodes->item(2);
            if ( empty( $team ) ) continue;
            $team = trim( $team->textContent );

            $points = $row->childNodes->item(4);
            $points = empty( $points ) ? 0.0 : trim( $points->textContent );

            $href = $row->childNodes->item(2)->getElementsByTagName( 'a' );
            if ( empty( $href ) ) continue;
            $href = $href->item(0)->getAttribute( "href" );

            $team_doc = self::request( "http://int.soccerway.com/".$href );
            if ( empty( $team_doc ) ) continue;

            $team_data = new Crawler();
            $team_data->addDocument( $team_doc );

            $country = $team_data->filterXPath( "//div[contains(@class, block_team_info)]/div/div/dl/dd[3]" )->getNode(0);
            if ( empty( $country ) ) continue;
            $country = trim( $country->textContent );

            $country_ids = Country::getIDsByName( $country );
            if ( empty( $country_ids ) ) throw new DomainException( "Missing country ".$country );

            $coach_href = $team_data->filterXPath( "//table[contains(@class, squad)]/tbody[5]/tr/td[2]/div/a" )->getNode(0);
            if ( empty( $coach_href ) ) continue;
            $coach_href = $coach_href->getAttribute( "href" );

            // coach info
            $coach_info = self::request( "http://int.soccerway.com/".$coach_href );
            if ( empty( $coach_info ) ) continue;

            $coach_data = new Crawler();
            $coach_data->addDocument( $coach_info );

            $coach_first_name = $coach_data->filterXPath( "//div[contains(@class, block_player_passport)]/div/div/div/div/dl/dd[1]" )->getNode(0);
            if ( empty( $coach_first_name ) ) continue;
            $coach_first_name = trim( $coach_first_name->textContent );

            $coach_last_name = $coach_data->filterXPath( "//div[contains(@class, block_player_passport)]/div/div/div/div/dl/dd[2]" )->getNode(0);
            if ( empty( $coach_last_name ) ) continue;
            $coach_last_name = trim( $coach_last_name->textContent );

            $coach_name = $coach_first_name.' '.$coach_last_name;

            // add coach if not in database
            $coach_ids = Coach::getIDsByName( $coach_name );
            if ( empty( $coach_ids ) ) $coach_ids = Coach::add( $coach_name );

            // allright, add the team into the database
            $team_ids = Team::getIDsByName( $team );
            if ( empty( $team_ids ) ) $team_ids = Team::add( $team, $country_ids[0]->id, $coach_ids[0]->id, $points );

            // okay, now let's do the players
            for ( $index = 1; $index < 5; $index++ ) {
                foreach ( $team_data->filterXPath( "//table[contains(@class, squad)]/tbody[".$index."]/tr/td/a/img/.." ) as $player_href ) {
                    $player_info = self::request( "http://int.soccerway.com/".$player_href->getAttribute( "href" ) );

                    $player_data = new Crawler();
                    $player_data->addDocument( $player_info );

                    $player_first_name = $player_data->filterXPath( "//div[contains(@class, block_player_passpaort)]/div/div/div/div/dl/dd[1]" )->getNode(0);
                    if ( empty( $player_first_name ) ) continue;
                    $player_first_name = trim( $player_first_name->textContent );

                    $player_last_name = $player_data->filterXPath( "//div[contains(@class, block_player_passpaort)]/div/div/div/div/dl/dd[2]" )->getNode(0);
                    if ( empty( $player_last_name ) ) continue;
                    $player_last_name = trim( $player_last_name->textContent );

                    $player_name = $player_first_name.' '.$player_last_name;

                    // add player if necessary
                    $player_ids = Player::getIDsByName( $player_name );
                    if ( empty( $player_ids ) ) $player_ids = Player::add( $player_name );

                    Team::linkPlayer( $player_ids[0]->id, $team_ids[0]->id );

                    // clear cache to avoid memory exhausting
                    $player_data->clear();
                } // end foreach
            } // end for

            // clear crawler caches to avoid memory exhausting
            $coach_data->clear();
            $team_data->clear();
        } // end foreach

        // clear cache to avoid memory exhausting
        $data->clear();
        return True;
    }

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
