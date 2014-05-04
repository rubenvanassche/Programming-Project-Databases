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
            } catch ( FatalErrorException $fee ) {
                continue;
            } // end try-catch
        } while ( $stop - $start <= $time_limit );

        return NULL;
    }

    /**
     * @brief Generator for parsing all the country data from site.
     * @details A complete list can be found at 
     * http://www.cloford.com/resources/codes/index.htm
     * 
     * @return An associative array with the following values mapped:
     *          "name"       => $name,
     *          "continent"     => $continent,
     *          "abbreviation"  => $abbreviation,
     */
    public static function countries_generator() {
        // load document
        $doc = self::request( "http://www.cloford.com/resources/codes/index.htm" );
        if ( empty( $doc ) ) return;    // request failed

        $data = new Crawler();
        $data->addDocument( $doc );

        foreach ( $data->filterXPath( "//table[@class=\"outlinetable\"]/tr/td/.." ) as $row ) {
            // skip empty rows
            if ( 0 == $row->childNodes->length ) continue;

            // get the country name
            $name = $row->childNodes->item(4);
            if ( empty( $name ) ) continue;
            $name = trim( $name->textContent );

            // get the continent and its id
            $continent = $row->childNodes->item(0);
            if ( empty( $continent ) ) continue;
            $continent = trim( $continent->textContent );

            // get the abbreviation
            $abbreviation = $row->childNodes->item(12);
            if ( empty( $abbreviation ) ) continue;
            $abbreviation = trim( $abbreviation->textContent );

            // yield data
            yield array(
                "name"          => $name,
                "continent"     => $continent,
                "abbreviation"  => $abbreviation,
            );

        } // end foreach

        // clear cache to avoid memory exhausting
        $data->clear();
        return;
    }

    /**
     * @brief Update the countries from database.
     */
    public static function update_countries() {
        // use generator (so it'll do it really fast)
        foreach ( self::countries_generator() as $country_data ) {
            $name = $country_data["name"];
            $continent = $country_data["continent"];
            $abbreviation = $country_data["abbreviation"];

            // need continent id
            $ids = Continent::getIDsByName( $continent );

            $continent_id = ( empty( $ids ) ) ? Continent::add( $continent )[0]->id : $ids[0]->id;

            // okay, add country if not yet added
            if ( empty( Country::getIDsByName( $name ) ) ) Country::add( $name, $continent_id, $abbreviation );
        } // end foreach

        return;
    }

    /**
     * @brief Get all the desired data from the player page.
     * @details An example of the player page can be found at 
     * http://int.soccerway.com/players/iker-casillas-fernandez/317/
     *
     * @param url The url of the player page.
     *
     * @return An associative array with the following values mapped:
     *      "first name"    => $first_name,
     *      "last name"     => $last_name,
     */
    public static function player_data( $url ) {
        // load document
        $doc = self::request( $url );
        if ( empty( $doc ) ) return array();    // request failed

        $data = new Crawler();
        $data->addDocument( $doc );

        // query for first name
        $xpath = "//div[contains(@class, block_player_passport)]/div/div/div/div/dl/dd[1]";

        $first_name = $data->filterXPath( $xpath )->getNode(0);
        $first_name = ( empty( $first_name ) ) ? NULL : trim( $first_name->textContent );

        // query for last name
        $xpath = "//div[contains(@class, block_player_passport)]/div/div/div/div/dl/dd[2]";

        $last_name = $data->filterXPath( $xpath )->getNode(0);
        $last_name = ( empty( $last_name ) ) ? NULL : trim( $last_name->textContent );

        // clear cache to avoid memory exhausting
        $data->clear();
        return array(
            "first name"    => $first_name,
            "last name"     => $last_name,
        );
    }

    /**
     * @brief Get all the desired data from the coach page.
     * @details An example of the coach page can be found at 
     * http://int.soccerway.com/coaches/vicente-del-bosque/130179/
     *
     * @param url The url of the coach page.
     *
     * @return An associative array with the following values mapped:
     *      "first name"    => $first_name,
     *      "last name"     => $last_name,
     */
    public static function coach_data( $url ) {
        // load document
        $doc = self::request( $url );
        if ( empty( $doc ) ) return array();    // request failed

        $data = new Crawler();
        $data->addDocument( $doc );

        // query for first name
        $xpath = "//div[contains(@class, block_player_passport)]/div/div/div/div/dl/dd[1]";

        $first_name = $data->filterXPath( $xpath )->getNode(0);
        $first_name = ( empty( $first_name ) ) ? NULL : trim( $first_name->textContent );

        // query for last name
        $xpath = "//div[contains(@class, block_player_passport)]/div/div/div/div/dl/dd[2]";

        $last_name = $data->filterXPath( $xpath )->getNode(0);
        $last_name = ( empty( $last_name ) ) ? NULL : trim( $last_name->textContent );

        // clear data to avoid memory exhausting
        $data->clear();
        return array(
            "first name"    => $first_name,
            "last name"     => $last_name,
        );
    }

    /**
     * @brief Get all desired team data from the team page.
     * @details An example of the team data can be found at
     * http://int.soccerway.com/teams/south-africa/south-africa/2014/
     *
     * @param url The url from where you want get data.
     *
     * @return An associative array with the following values mapped:
     *      "country"       => $country,
     *      "coach data"    => $coach_data,
     *      "players data"  => $players_data,
     */
    public static function team_data( $url ) {
        // load document
        $doc = self::request( $url );
        if ( empty( $doc ) ) return array();    // request failed

        $data = new Crawler();
        $data->addDocument( $doc );

        // query for country
        $xpath = "//div[contains(@class, block_team_info)]/div/div/dl/dd[3]";

        $country = $data->filterXPath( $xpath )->getNode(0);
        $country = ( empty( $country ) ) ? NULL : trim( $country->textContent );

        // query for the coach
        $xpath = "//table[contains(@class, squad)]/tbody[5]/tr/td[2]/div/a";

        $href = $data->filterXPath( $xpath )->getNode(0);

        $coach_data = ( empty( $href ) ) ? NULL : self::coach_data( "http://int.soccerway.com/".$href->getAttribute( "href" ) );

        // now get all the participating players
        $players_data = array();

        // squad < 5 because of (1) Goalkeeper, (2) Defender, (3) Midfielder, 
        // (4) Attacker. (We don't want to include the coach, and besides those 
        // players are always available (e.g. no goalkeeper or midfielder is 
        // against the rules of football).
        for ( $index = 1; $index < 5; $index++ ) {
            // query for player href
            $xpath = "//table[contains(@class, squad)]/tbody[".$index."]/tr/td/a/img/..";

            foreach ( $data->filterXPath( $xpath ) as $href ) {
                // skip if no href provided
                $href = $href->getAttribute( "href" );
                if ( empty( $href ) ) continue;

                // add new player data
                $players_data[] = self::player_data( "http://int.soccerway.com/".$href );
            } // end foreach

        } // end for

        // clear cache to avoid memory exhausting
        $data->clear();
        return array(
            "country"       => $country,
            "coach data"    => $coach_data,
            "players data"  => $players_data,
        );
    }

    /**
     * @brief Generator for parsing all the international teams from the 
     * official FIFA participant list.
     * @details A complete list can be found at 
     * http://int.soccerway.com/teams/rankings/fifa/
     *
     * @return An associative array with the following values mapped:
     *      "name"          => $name,
     *      "points"        => $points,
     *      "country"       => $country,
     *      "coach data"    => $coach_data,
     *      "players data"  => $players_data,
     */
    public static function teams_generator() {
        // load document
        $doc = self::request( "http://int.soccerway.com/teams/rankings/fifa/" );
        if ( empty( $doc ) ) return;    // request failed

        $data = new Crawler();
        $data->addDocument( $doc );

        // query for row
        $xpath = "//table[contains(@class, fifa_rankings)]/tbody/tr/td/..";
        foreach ( $data->filterXPath( $xpath ) as $row ) {
            // skip empty rows
            if ( 0 == $row->childNodes->length ) continue;

            $name = $row->childNodes->item(2);
            $name = ( empty( $name ) ) ? NULL : trim( $name->textContent );

            $points = $row->childNodes->item(4);
            $points = ( empty( $points ) ) ? 0 : trim( $points->textContent );

            // get more data from the team's page
            $href = $row->childNodes->item(2)->getElementsByTagName( 'a' );
            $href = ( empty( $href ) ) ? NULL : $href->item(0)->getAttribute( "href" );
            $url = ( empty( $href ) ) ? NULL : "http://int.soccerway.com/".$href;

            $team_data = ( empty( $url ) ) ? array() : self::team_data( $url );

            // merge team data with what you already have
            yield array_merge(
                array( "name" => $name, "points" => $points ),
                $team_data
            );

        } // end foreach

        // clear cache to avoid memory exhausting
        $data->clear();
        return;
    }

    /**
     * @brief Update the teams using the generator.
     */
    public static function update_teams() {
        foreach ( self::teams_generator() as $team_data ) {
            // skip if team already added
            $name = $team_data["name"];

            $ids = Team::getIDsByName( $name );
            if ( !empty( $ids ) ) continue;

            // query for country ID
            $country = $team_data["country"];

            $country_id = Country::getIDsByName( $country );
            if ( empty( $country_id ) ) throw new DomainException( "Missing country ".$country );
            $country_id = $country_id[0]->id;

            // query for coach id
            $first_name = $team_data["coach data"]["first name"];
            $last_name = $team_data["coach data"]["last name"];
            $coach = ( empty( $first_name ) || empty( $last_name ) ) ? NULL : $first_name.' '.$last_name;

            $coach_id = NULL;
            if ( NULL != $coach ) {
                $ids = Coach::getIDsByName( $coach );
                if ( empty( $ids ) && NULL != $coach ) $ids = Coach::add( $coach );
                $coach_id = $ids[0]->id;
            } // end if

            // add the team
            $points = $team_data["points"];

            $team_id = Team::add( $name, $coach_id, $country_id, $points )[0]->id;

            // alright, link players to this team
            foreach ( $team_data["players data"] as $player_data ) {
                $first_name = $player_data["first name"];
                $last_name = $player_data["last name"];
                $player = ( empty( $first_name ) || empty( $last_name ) ) ? NULL : $first_name.' '.$last_name;

                $ids = Player::getIDsByName( $player );
                if ( empty( $ids ) && NULL != $player ) $ids = Player::add( $player );
                $player_id = $ids[0]->id;

                // link player to team
                Team::linkPlayer( $player_id, $team_id );
            } // end foreach
        } // end foreach

        return;
    }

    /**
     * @brief Get all desired match data from the match page.
     * @details An example of the match data can be found at
     * http://int.soccerway.com/matches/2014/06/12/world/world-cup/brazil/croatia/1220070/?ICID=PL_MS_01
     *
     * @param url The url of the match page.
     *
     * @return An associative array with the following values mapped:
     *      "date"      => $date,
     *      "kick-off"  => $kick_off,
     *      "hometeam"  => $hometeam,
     *      "scoretime" => $scoretime,
     *      "awayteam"  => $awayteam,
     *      "goals"     => $goals
     *
     *  Where as $goals is an array of associative arrays with the following 
     *  values mapped:
     *      "team"          => $hometeam or $awayteam,
     *      "player data"   => $player_data, 
     */
    public static function match_data( $url ) {
        // load document
        $doc = self::request( $url );
        if ( empty( $doc ) ) return array();    // request failed

        $data = new Crawler();
        $data->addDocument( $doc );

        // query for date
        $xpath = "//div[contains(@class, block_match_info)]/div/div/div/dl/dd[2]";

        $date = $data->filterXPath( $xpath )->getNode(0);
        $date = ( empty( $date ) ) ? NULL : trim( $date->textContent );

        // query for kick-off
        $xpath = "//div[contains(@class, block_match_info)]/div/div/div/dl/dd[3]";

        $kick_off = $data->filterXPath( $xpath )->getNode(0);
        $kick_off = ( empty( $kick_off ) ) ? NULL : trim( $kick_off->textContent );

        // query for heading
        $xpath = "//div[contains(@class, block_match_info)]/div/div/h3";
        $heading = $data->filterXPath( $xpath );

        // get hometeam
        $hometeam = $heading->getNode(0);
        $hometeam = ( empty( $hometeam ) ) ? NULL : trim( $hometeam->textContent );

        // get scoretime
        $scoretime = $heading->getNode(1);
        $scoretime = ( empty( $scoretime ) ) ? NULL : trim( $scoretime->textContent );

        // get awayteam
        $awayteam = $heading->getNode(2);
        $awayteam = ( empty( $awayteam ) ) ? NULL : trim( $awayteam->textContent );

        // query for goals, it seems quite strange, but it's the only way this 
        // works
        $xpath = "//div[contains(@class, block_match_goals)]/div/table[contains(@class, matches)]";

        $goals = array();

        // skip if no goals
        if ( "0 - 0" == $scoretime ) return array(
            "date"      => $date,
            "kick-off"  => $kick_off,
            "hometeam"  => $hometeam,
            "scoretime" => $scoretime,
            "awayteam"  => $awayteam,
            "goals"     => $goals,
        );

        foreach ( $data->filterXPath( $xpath )->getNode(1)->childNodes as $row ) {
            if ( 0 == $row->childNodes->length ) continue;

            $home = $row->childNodes->item(0);
            $away = $row->childNodes->item(4);

            // determine which team has scored a goal
            $homegoal = ( empty( $home ) ) ? NULL : trim( $home->textContent );
            $awaygoal = ( empty( $away ) ) ? NULL : trim( $away->textContent );

            if ( !empty( $homegoal ) ) {
                // get the player data
                $href = $home->getElementsByTagName( 'a' );
                $href = ( empty( $href ) ) ? NULL : $href->item(0)->getAttribute( "href" );
                $url = ( empty( $href ) ) ? NULL : "http://int.soccerway.com/".$href;

                $player_data = self::player_data( $url );

                // get the time (using regular expressions)
                preg_match('!\d+!', trim( $homegoal ), $time);
                $time = $time[0];

                $goals[] = array(
                    "team"          => $hometeam,
                    "player data"   => $player_data,
                    "time"          => $time,
                );
            } else if ( !empty( $awaygoal ) ) {
                // get the player data
                $href = $away->getElementsByTagName( 'a' );
                $href = ( empty( $href ) ) ? NULL : $href->item(0)->getAttribute( "href" );
                $url = ( empty( $href ) ) ? NULL : "http://int.soccerway.com/".$href;

                $player_data = self::player_data( $url );

                // get the time (using regular expressions)
                preg_match('!\d+!', trim( $awaygoal ), $time);
                $time = $time[0];

                $goals[] = array(
                    "team"          => $awayteam,
                    "player data"   => $player_data,
                    "time"          => $time,
                );
            } else {
                continue;
            } // end if-else

        } // end foreach

        // clear cache to avoid memory exhausting
        $data->clear();
        return array(
            "date"      => $date,
            "kick-off"  => $kick_off,
            "hometeam"  => $hometeam,
            "scoretime" => $scoretime,
            "awayteam"  => $awayteam,
            "goals"     => $goals,
        );
    }

    /**
     * @brief Get all the desired competition data from the competition page.
     * @details An example of the competition page can be found at
     * http://int.soccerway.com/international/world/world-cup/c72/
     *
     * @param url The url to the competition page.
     *
     * @return An associative array with the following values mapped:
     *      "name"          => $name,
     *      "matches data"  => $matches_data,
     */
    public static function competition_data( $url ) {
        // load document
        $doc = self::request( $url );
        if ( empty( $doc ) ) return array();    // request failed

        $data = new Crawler();
        $data->addDocument( $doc );

        // query for the name of the competition
        $xpath = "//div[contains(@class, block_competition_left_tree)]/ul/li/ul/li/a/../../../a";

        $competition_name = $data->filterXPath( $xpath )->getNode(0);
        $competition_name = ( empty( $competition_name ) ) ? NULL : trim( $competition_name->textContent );

        // query for the edition
        $xpath = "//div[contains(@class, block_competition_left_tree)]/ul/li/ul/li/a";

        $edition = $data->filterXPath( $xpath )->getNode(0);
        $edition = ( empty( $edition ) ) ? NULL : trim( $edition->textContent );

        // name is the competition name + edition
        $name = $competition_name.' '.$edition;

        // query for the matches of the group stages
        $xpath = "//div[contains(@class, block_competition_left_tree)]/ul/li/ul/li/ul/li/ul/li/a";

        $matches_data = array();
        foreach ( $data->filterXPath( $xpath ) as $group ) {
            $href = $group->getAttribute( "href" );
            if ( empty( $href ) ) continue;
            $url = "http://int.soccerway.com/".$href;

            $group_page = self::request( $url );
            if ( empty( $group_page ) ) continue;

            $group_data = new Crawler();
            $group_data->addDocument( $group_page );

            // query for href
            $xpath_href = "//table[contains(@class, matches)]/tbody/tr[contains(@class, match)]/td[4]/a";

            foreach ( $group_data->filterXPath( $xpath_href ) as $href ) {
                $href = $href->getAttribute( "href" );
                if ( empty( $href ) ) continue;
                $url = "http://int.soccerway.com/".$href;

                // add match data
                $matches_data[] = self::match_data( $url );
            } // end foreach

            $group_data->clear();
        } // end foreach

        // clear cache to avoid memory exhausting
        $data->clear();
        return array(
            "name"          => $name,
            "matches data"  => $matches_data,
        );
    }
    
    /**
     * @brief Update the competition.
     *
     * @param url The url to be used for parsing competition.
     */
    public static function update_competition( $url ) {
        // get the competition data
        $competition_data = self::competition_data( $url );
        if ( empty( $competition_data ) ) return;

        // get the competition id
        $competition = $competition_data["name"];

        $ids = Competition::getIDsByName( $competition );
        if ( empty( $ids ) ) $ids = Competition::add( $competition );
        $competition_id = $ids[0]->id;

        // add match to the competition (and also link team to the competition)
        foreach ( $competition_data["matches data"] as $match_data ) {
            // get the hometeam ID
            $hometeam = $match_data["hometeam"];

            $ids = Team::getIDsByName( $hometeam );
            if ( empty( $ids ) ) throw new DomainException( "Missing team ".$hometeam );
            $hometeam_id = $ids[0]->id;

            // get the awayteam ID
            $awayteam = $match_data["awayteam"];

            $ids = Team::getIDsByName( $awayteam );
            if ( empty( $ids ) ) throw new DomainException( "Missing team ".$awayteam );
            $awayteam_id = $ids[0]->id;

            // link both teams to the competition
            Competition::linkTeam( $hometeam_id, $competition_id );
            Competition::linkTeam( $awayteam_id, $competition_id );

            // alright, add the match (if not already added)
            $date = new DateTime( $match_data["date"] );
            $date = $date->format( "Y-m-d" );

            $ids = Match::getIDs( $hometeam_id, $awayteam_id, $competition_id, $date );
            if ( empty( $ids ) ) $ids = Match::add( $hometeam_id, $awayteam_id, $competition_id, $date );
            $match_id = $ids[0]->id;

            // okay, let's update the goals (if any)
            foreach ( $match_data["goals"] as $goal ) {
                // get the time
                $time = $goal["time"];

                // get the team id
                $team = $goal["team"];

                $ids = Team::getIDsByName( $team );
                if ( empty( $ids ) ) throw new DomainException( "Could not find team ".$team );
                $team_id = $ids[0]->id;

                // get the player id
                $player_data = $goal["player data"];

                $first_name = $player_data["first name"];
                $last_name = $player_data["last name"];
                $player = ( empty( $first_name ) || empty( $last_name ) ) ? NULL : $first_name.' '.$last_name;

                $ids = Player::getIDsByName( $player );
                if ( empty( $ids ) && NULL != $player ) {
                    $ids = Player::add( $player );
                    $player_id = $ids[0]->id;

                    // also link player to team
                    Team::linkPlayer( $player_id, $team_id );
                } // end if
                $player_id = $ids[0]->id;

                // now add the goal (if not already added)
                if ( empty( Goal::getIDs( $match_id, $team_id, $player_id, $time ) ) ) Goal::add( $match_id, $team_id, $player_id, $time );
            } // end foreach

        } // end foreach

        return;
    }

#    /**
#     * @brief Fetch live info and update our database.
#     * @details Will use information from pages of this website:
#     * http://www.livescore.com
#     */
#    public static function liveMatch($competition, $homeTeam, $awayTeam, $date) {
#        // First we need to find the correct url for the match.
#        // -> This means we need to crawl a webpage like this: http://www.livescore.com/worldcup/fixtures/ and look for the correct URL.
#        $doc = self::request( "http://www.livescore.com/worldcup/fixtures/");
#        if ( empty( $doc ) ) return;
#
#        $data = new Crawler();
#        $data->addDocument( $doc );
#
#        foreach ( $data->filterXPath( "//table[contains(@class, league-wc)]/tbody/tr/td/.." ) as $row ) {
#            // Skip empty rows.
#            if ( 0 == $row->childNodes->length ) continue;
#
#            $teams = $row->childNodes->item(4);
#            if ( empty( $name ) ) continue;
#            $teams = trim( $teams->textContent );
#
#            // Check whether or not this is the correct match.
#            if ((strpos($teams, $homeTeam) !== FALSE) && (strpos($teams, $awayTeam) !== FALSE) {
#                $href = $row->childNodes->item(4)->getElementsByTagName( 'a' );
#                if ( empty( $href ) ) continue;
#                $href = $href->item(0)->getAttribute( "href" );
#
#                // At this point $href we need to concatenate $href with http://www.livescore.com
#                $href = "http://www.livescore.com" . $href;
#                break;
#            } else {
#                continue;
#            }
#        }
#
#        // Next extract the info from this webpage.
#
#        // Update the info in our database (this won't be visible on the website unless the user refreshes OR we could use Ajax)
#        // We'll call a method of the match model in here that updates it.
#
#    }

}
