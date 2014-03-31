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

            $name = $row->childNodes->item(4);
            if ( empty( $name ) ) continue;
            $name = trim( $name->textContent );

            $continent = $row->childNodes->item(0);
            if ( empty( $continent ) ) continue;
            $continent = trim( $continent->textContent );

            // add continent if necessary
            $continent_ids = Continent::getIDsByName( $continent_name );
            if ( empty( $continent_ids ) ) $continent_ids = Continent::add( $continent );

            $abbreviation = $row->childNodes->item(12);
            if ( empty( $abbreviation ) ) continue;
            $abbreviation = trim( $abbreviation->textContent );

            // okay, add the country
            if ( empty( Country::getIDsByName( $name ) ) ) Country::add( $name, $continent_ids[0]->id, $abbreviation );
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

            $name = $row->childNodes->item(2);
            if ( empty( $name ) ) continue;
            $name = trim( $name->textContent );

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
            $country_name = trim( $country->textContent );
            $country_ids = Country::getIDsByName( $country_name );
            if ( empty( $country_ids ) ) throw new DomainException( "Missing country ".$country_name );

            $coach_href = $team_data->filterXPath( "//table[contains(@class, squad)]/tbody[5]/tr/td[2]/div/a" )->getNode(0);
            $coach_id = NULL;
            if ( !empty( $coach_href ) ) {
                $coach_href = $coach_href->getAttribute( "href" );

                // coach info
                $coach_info = self::request( "http://int.soccerway.com/".$coach_href );
                if ( empty( $coach_info ) ) continue;

                $coach_data = new Crawler();
                $coach_data->addDocument( $coach_info );

                $coach_first_name = $coach_data->filterXPath( "//div[contains(@class, block_player_passport)]/div/div/div/div/dl/dd[1]" )->getNode(0);
                $coach_first_name = ( empty( $coach_first_name ) ) ? NULL : trim( $coach_first_name->textContent );

                $coach_last_name = $coach_data->filterXPath( "//div[contains(@class, block_player_passport)]/div/div/div/div/dl/dd[2]" )->getNode(0);
                $coach_last_name = ( empty( $coach_last_name ) ) ? NULL : trim( $coach_last_name->textContent );

                $coach_name = ( empty( $coach_first_name ) || empty( $coach_last_name ) ) ? NULL : $coach_first_name.' '.$coach_last_name;

                // add coach if not in database
                $coach_ids = ( !empty( $coach_name ) ) ? Coach::getIDsByName( $coach_name ) : NULL;
                if ( empty( $coach_ids ) && NULL != $coach_name ) $coach_ids = Coach::add( $coach_name );
                $coach_id = ( empty( $coach_ids ) ) ? NULL : $coach_ids[0]->id;

                $coach_data->clear();
            } // end if

            // allright, add the team into the database
            $team_ids = Team::getIDsByName( $team );
            if ( empty( $team_ids ) ) $team_ids = Team::add( $name, $coach_id, $country_ids[0]->id, $points );

            // okay, now let's do the players
            for ( $index = 1; $index < 5; $index++ ) {
                foreach ( $team_data->filterXPath( "//table[contains(@class, squad)]/tbody[".$index."]/tr/td/a/img/.." ) as $player_href ) {
                    $player_info = self::request( "http://int.soccerway.com/".$player_href->getAttribute( "href" ) );
                    if ( empty( $player_info ) ) continue;

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
            $team_data->clear();
        } // end foreach

        // clear cache to avoid memory exhausting
        $data->clear();
        return True;
    }

    /**
     * @brief Scrape all the competitions.
     * @details Based upon the matches on
     * http://int.soccerway.com/international/world/world-cup/c72/archive/?ICID=PL_3N_06
     */
    public static function matches() {
        $doc = self::request( "http://int.soccerway.com/international/world/world-cup/c72/archive/?ICID=PL_3N_06" );
        if ( empty( $doc ) ) return;

        $data = new Crawler();
        $data->addDocument( $doc );

        $competition = $data->filterXPath( "//div[contains(@class, block_competition_left_tree)]/ul/li/ul/li/a" )->getNode(0);
        if ( empty( $competition ) ) { $data->clear(); return False; }
        $competition = "World Cup ".$competition->textContent;
        $competition_ids = Competition::getIDsByName( $competition );
        if ( empty( $competition_ids ) ) $competition_ids = Competition::add( $competition );

        foreach ( $data->filterXPath( "//div[contains(@class, block_competition_left_tree)]/ul/li/ul/li/ul/li/ul/li/a" ) as $row ) {
            $group_href = $row->getAttribute( "href" );
            if ( empty( $group_href ) ) continue;

            $group_info = self::request( "http://int.soccerway.com/".$group_href );
            if ( empty( $group_info ) ) continue;

            $group_data = new Crawler();
            $group_data->addDocument( $group_info );

            foreach ( $group_data->filterXPath( "//div[contains(@class, block_competition_matches)]/div/table/tbody/tr[contains(@class, match)]" ) as $match_data ) {
                $match_data = $match_data->getElementsByTagName( "td" );
                if ( empty( $match_data ) ) continue;

                $date = $match_data->item(1);
                if ( empty( $date ) ) continue;
                $date = DateTime::createFromFormat('j/m/y', $date->textContent)->format('Y-m-d');

                $hometeam = $match_data->item(2);
                if ( empty( $hometeam ) ) continue;
                $hometeam = trim( $hometeam->textContent );
                $hometeam_ids = Team::getIDsByName( $hometeam );
                if ( empty( $hometeam_ids ) ) throw new DomainException( "Team ".$hometeam." missing." );
                Competition::linkTeam( $hometeam_ids[0]->id, $competition_ids[0]->id );

                $awayteam = $match_data->item(4);
                if ( empty( $awayteam ) ) { continue; }
                $awayteam = trim( $awayteam->textContent );
                $awayteam_ids = Team::getIDsByName( $awayteam );
                if ( empty( $awayteam_ids ) ) throw new DomainException( "Team ".$awayteam." missing." );
                Competition::linkTeam( $awayteam_ids[0]->id, $competition_ids[0]->id );

                Match::add( $hometeam_ids[0]->id, $awayteam_ids[0]->id, $competition_ids[0]->id, $date);
            } // end foreach

            $group_data->clear();
        } // end foreach

        $data->clear();
        return;
    }
    
     /**
     * @brief Fetch live info and update our database.
     * @details Will use information from pages of this website:
     * http://www.livescore.com 
     */
    public static function liveMatch($competition, $homeTeam, $awayTeam, $date) {
    	// First we need to find the correct url for the match.
    	// -> This means we need to crawl a webpage like this: http://www.livescore.com/worldcup/fixtures/ and look for the correct URL.
    	$doc = self::request( "http://www.livescore.com/worldcup/fixtures/");
        if ( empty( $doc ) ) return;

        $data = new Crawler();
        $data->addDocument( $doc );
        
        foreach ( $data->filterXPath( "//table[contains(@class, league-wc)]/tbody/tr/td/.." ) as $row ) {
            // Skip empty rows.
            if ( 0 == $row->childNodes->length ) continue;

            $teams = $row->childNodes->item(4);
            if ( empty( $name ) ) continue;
            $teams = trim( $teams->textContent );
            
            // Check whether or not this is the correct match.
            if ((strpos($teams, $homeTeam) !== FALSE) && (strpos($teams, $awayTeam) !== FALSE) {
			  	$href = $row->childNodes->item(4)->getElementsByTagName( 'a' );
		        if ( empty( $href ) ) continue;
		        $href = $href->item(0)->getAttribute( "href" );
		        
		        // At this point $href we need to concatenate $href with http://www.livescore.com
		        $href = "http://www.livescore.com" . $href;
		        break;
            }
			else {
	        	continue;
			}
        }
    	
    	// Next extract the info from this webpage.
    	
    	// Update the info in our database (this won't be visible on the website unless the user refreshes OR we could use Ajax)
    	// We'll call a method of the match model in here that updates it.
    	
    }

}
