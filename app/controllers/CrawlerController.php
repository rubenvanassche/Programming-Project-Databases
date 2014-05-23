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
     * @brief Generate empty set of data.
     *
     * @param keys Array of keys.
     *
     * @return Associative array where each key is mapped to NULL.
     */
    public static function empty_data($keys) {
        $data = array();
        foreach ($keys as $key) {
            $data[$key] = NULL;
        } // end foreach
        return $data;
    }

    /**
     * @brief Generator for parsing all the country data from site.
     * @details A complete list can be found at
     * http://www.cloford.com/resources/codes/index.htm
     *
     * @param keys What you want to parse, the following keys are available for 
     * use:
     *
     *      - name
     *      - continent
     *      - abbreviation
     *
     * Use empty (array or NULL) to catch'em all.
     *
     * @return An associative array with the given keys mapped to the parsed value.
     */
    public static function countries_data($keys=array()) {
        // all data in case no keys were given
        if (empty($keys)) $keys = array("name", "continent", "abbreviation");

        // load document
        $doc = self::request("http://www.cloford.com/resources/codes/index.htm");
        if (empty($doc)) { yield self::empty_data($keys); return; } // request failed

        $data = new Crawler();
        $data->addDocument( $doc );

        // parse country from table
        foreach ($data->filterXPath("//table[@class=\"outlinetable\"]/tr/td/..") as $row) {
            // skip short rows
            if (12 > $row->childNodes->length) continue;

            $country_data = array();
            foreach ($keys as $key) {
                if ("name" == $key) {
                    // get country name
                    $name = $row->childNodes->item(4);

                    $country_data[$key] = empty($name) ? NULL : trim($name->textContent);
                } else if ("continent" == $key) {
                    // get continent name
                    $continent = $row->childNodes->item(0);

                    $country_data[$key] = empty($continent) ? NULL : trim($continent->textContent);
                } else if ("abbreviation" == $key) {
                    // get abbreviation
                    $abbreviation = $row->childNodes->item(12);

                    $country_data[$key] = empty($abbreviation) ? NULL : trim($abbreviation->textContent);
                } else {
                    // other data
                    $country_data[$key] = NULL;
                } // end if-else
            } // end foreach

            // yield country data, because the list may be too long
            yield $country_data;
        } // end foreach

        // clear cache to avoid memory exhausting
        $data->clear();
        return;
    }

    /**
     * @brief Get all the desired data from the player page.
     * @details An example of the player page can be found at
     * http://int.soccerway.com/players/iker-casillas-fernandez/317/
     *
     * @param url The url of the player page.
     * @param keys Array of keys if you want to parse specific information.
     * Available keys are:
     *
     *      - first name
     *      - last name
     *      - position
     *
     * Use empty array or NULL to catch'em all.
     *
     * @return Associative array with the keys mapped to a value.
     */
    public static function player_data($url, $keys=array()) {
        // all data in case no keys were given
        if (empty($keys)) $keys = array("first name", "last name", "position");

        // load document
        $doc = self::request($url);
        if (empty($doc)) return self::empty_data($keys);    // request failed

        $data = new Crawler();
        $data->addDocument($doc);

        // parse player info from players passport
        $player_data = array();
        foreach ($keys as $key) {
            $passport = $data->filterXPath("//div[contains(@class, block_player_passport)]/div/div/div/div/dl/dd");

            if ("first name" == $key) {
                // get first name
                $first_name = $passport->getNode(0);

                $player_data[$key] = empty($first_name) ? NULL : trim($first_name->textContent);
            } else if ("last name" == $key) {
                // get last name
                $last_name = $passport->getNode(1);

                $player_data[$key] = empty($last_name) ? NULL : trim($last_name->textContent);
            } else if ("position" == $key) {
                // get players position
                $position = $passport->getNode(7);

                $position = empty($position) ? NULL : strtolower(trim($position->textContent));

                if (in_array($position, array("goalkeeper", "defender", "midfielder", "attacker"))) {
                    $player_data[$key] = $position;
                } else {
                    $position = $passport->getNode(6);

                    $position = 
                    $player_data[$key] = empty($position) ? NULL : strtolower(trim($position->textContent));
                } // end if-else
            } else {
                // other data
                $player_data[$key] = NULL;
            } // end if-else
        } // end foreach

        // clear cache to avoid memory exhausting
        $data->clear();
        return $player_data;
    }

    /**
     * @brief Get all the desired data from the coach page.
     * @details An example of the coach page can be found at
     * http://int.soccerway.com/coaches/vicente-del-bosque/130179/
     *
     * @param url The url of the coach page.
     * @param keys Array of keys if you want to parse specific information.
     * Available keys are:
     *
     *      - first name
     *      - last name
     *
     * Use empty array or NULL to catch'em all.
     *
     * @return Associative array with the keys mapped to a value.
     */
    public static function coach_data($url, $keys=array()) {
        // all data in case no keys were given
        if (empty($keys)) $keys = array("first name", "last name");

        // load document
        $doc = self::request($url);
        if (empty($doc)) return self::empty_data($keys);    // request failed

        $data = new Crawler();
        $data->addDocument($doc);

        // parse coach info from coach passport
        $coach_data = array();
        foreach ($keys as $key) {
            $passport = $data->filterXPath("//div[contains(@class, block_player_passport)]/div/div/div/div/dl/dd");

            if ("first name" == $key) {
                // get first name
                $first_name = $passport->getNode(0);

                $coach_data[$key] = empty($first_name) ? NULL : trim($first_name->textContent);
            } else if ("last name" == $key) {
                // get last name
                $last_name = $passport->getNode(1);

                $coach_data[$key] = empty($last_name) ? NULL : trim($last_name->textContent);
            } else {
                // other data
                $coach_data[$key] = NULL;
            } // end if-else
        } // end foreach

        // clear data to avoid memory exhausting
        $data->clear();
        return $coach_data;
    }

    /**
     * @brief Get all desired team data from the team page.
     * @details An example of the team data can be found at
     * http://int.soccerway.com/teams/south-africa/south-africa/2014/
     *
     * @param url The url from where you want get data.
     * @param keys Array of keys whose info you want to get. The following keys
     * are available:
     *
     *      - country name
     *      - coach url
     *      - players url
     *
     * Discard if you want to catch'em all.
     *
     * @return Associative array with the keys mapped to a value.
     */
    public static function team_data($url, $keys=array()) {
        // all data in case no keys were given
        if (empty($keys)) $keys = array("country name", "coach url", "players url");

        // load document
        $doc = self::request($url);
        if (empty($doc)) return self::empty_data($keys);    // request failed

        $data = new Crawler();
        $data->addDocument($doc);

        // gather all team information
        $team_data = array();
        foreach ($keys as $key) {
            if ("country name" == $key) {
                // get name of the country
                $country_name = $data->filterXPath("//div[contains(@class, block_team_info)]/div/div/dl/dd[3]")->getNode(0);

                $team_data[$key] = empty($country_name) ? NULL : trim($country_name->textContent);
            } else if ("coach url" == $key) {
                // get coach url
                $coach_url = $data->filterXPath("//table[contains(@class, squad)]/tbody[5]/tr/td[2]/div/a")->getNode(0);

                $team_data[$key] = empty($coach_url) ? NULL : "http://int.soccerway.com/".$coach_url->getAttribute("href");
            } else if ("players url" == $key) {
                // get players url
                $players_url = array();

                // squad < 5 because of (1) Goalkeeper, (2) Defender,
                // (3) Midfielder, (4) Attacker. (We don't want to include the
                // coach, and besides those players are always available (e.g.
                // no goalkeeper or midfielder is illegal in football).
                for ($index = 1; $index < 5; $index++) {
                    foreach ($data->filterXPath("//table[contains(@class, squad)]/tbody[".$index."]/tr/td/a/img/..") as $href) {
                        // skip if no href provided
                        $href = $href->getAttribute("href");
                        if (empty($href)) continue;

                        $players_url[] = "http://int.soccerway.com/".$href;
                    } // end foreach
                } // end for

                $team_data[$key] = $players_url;
            } else {
                // other data
                $team_data[$key] = NULL;
            } // end if-else
        } // end foreach

        // clear cache to avoid memory exhausting
        $data->clear();
        return $team_data;
    }

    /**
     * @brief Generator for parsing all the international teams from the
     * official FIFA participant list.
     * @details A complete list can be found at
     * http://int.soccerway.com/teams/rankings/fifa/
     *
     * @param keys Array of keys indicating what kind of data you want to get.
     * The following data is available:
     *
     *      - team name
     *      - team url
     *      - points
     *
     * @return Associative array with the keys mapped to either NULL or a
     * value.
     */
    public static function teams_data($keys=array()) {
        // use all keys when no keys were given
        if (empty($keys)) $keys = array("team name", "team url", "points");

        // load document
        $doc = self::request( "http://int.soccerway.com/teams/rankings/fifa/" );
        if (empty($doc)) { yield self::empty_data($keys); return; } // request failed

        $data = new Crawler();
        $data->addDocument($doc);

        foreach ($data->filterXPath("//table[contains(@class, fifa_rankings)]/tbody/tr/td/..") as $row) {
            // skip invalid rows
            if (4 > $row->childNodes->length) continue;

            // get team data
            $team_data = array();
            foreach ($keys as $key) {
                if ("team name" == $key) {
                    $name = $row->childNodes->item(2);

                    $team_data[$key] = empty($name) ? NULL : trim($name->textContent);
                } else if ("team url" == $key) {
                    $url = $row->childNodes->item(2);
                    $url = empty($url) ? NULL : $url->getElementsByTagName('a');
                    $url = empty($url) ? NULL : $url->item(0);
                    $url = empty($url) ? NULL : "http://int.soccerway.com/".$url->getAttribute("href");
                } else if ("points" == $key) {
                    $points = $row->childNodes->item(4);

                    $team_data[$key] = empty($points) ? 0 : trim($points->textContent);
                } else {
                    // other data
                    $team_data[$key] = NULL;
                } // end if-else
            } // end foreach
            yield $team_data;
        } // end foreach

        // clear cache to avoid memory exhausting
        $data->clear();
        return;
    }

    /**
     * @brief Get all desired match data from the match page.
     * @details An example of the match data can be found at
     * http://int.soccerway.com/matches/2014/06/12/world/world-cup/brazil/croatia/1220070/?ICID=PL_MS_01
     *
     * @param url The url of the match page.
     * @param keys Array of strings indicating the desired data to parse. The
     * following keys are available for use:
     *
     *      - date
     *      - kick-off
     *      - scoretime
     *      - hometeam
     *      - awayteam
     *      - hometeam url
     *      - awayteam url
     *      - hometeam lineups      [array(url, goals, yellow cards, red cards)]
     *      - awayteam lineups      [array(url, goals, yellow cards, red cards)]
     *      - hometeam substitutes  [array(url, url, time, goals, yellow cards, red cards)]
     *      - awayteam substitutes  [array(url, url, time, goals, yellow cards, red cards)]
     *
     * Use empty array to catch'em all.
     *
     * @return Associative array with the keys mapped to a vallue or to NULL.
     */
    public static function match_data($url, $keys=array()) {
        // all stuffs in case of empty array
        if (empty($keys)) $keys = array(
            "date", "kick-off", "scoretime", "hometeam url", "awayteam url", "hometeam", "awayteam",
            "hometeam lineups", "awayteam lineups", "hometeam substitutes", "awayteam substitutes");

        // load document
        $doc = self::request($url);
        if (empty($doc)) return self::empty_data($keys);    // request failed

        $data = new Crawler();
        $data->addDocument( $doc );

        $match_data = array();
        foreach ($keys as $key) {
            $match_info = $data->filterXPath("//div[contains(@class, block_match_info)]/div/div/div/dl/dd");
            $heading = $data->filterXPath("//div[contains(@class, block_match_info)]/div/div/h3");

            if ("date" == $key) {
                // get date of the match
                $date = $match_info->getNode(1);

                if (empty($date)) {
                    $match_data[$key] = NULL;
                } else {
                    $date = new DateTime(trim($date->textContent));

                    $match_data[$key] = $date->format("Y-m-d");
                } // end if-else
            } else if ("kick-off" == $key) {
                // get kick-off time
                $kick_off = $match_info->getNode(3);

                if (empty($kick_off)) {
                    $match_data[$key] = NULL;
                } else {
                    if (!preg_match("/\d+:\d+/", $kick_off->textContent)) $kick_off = $match_info->getNode(2);
                    $kick_off = new DateTime(trim($kick_off->textContent));

                    $match_data[$key] = $kick_off->format("H:i:s");
                } // end if-else
            } else if ("scoretime" == $key) {
                // get scoretime
                $scoretime = $heading->getNode(1);

                $match_data[$key] = empty($scoretime) ? NULL : trim($scoretime->textContent);
            } else if ("hometeam" == $key || "awayteam" == $key) {
                // get team name
                $index = "hometeam" == $key ? 0 : 2;

                $team = $heading->getNode($index);

                $match_data[$key] = empty($team) ? NULL : trim($team->textContent);
            } else if ("hometeam url" == $key || "awayteam url" == $key) {
                // get team url
                $index = "hometeam url" == $key ? 0 : 2;

                $match_data[$key] = "http://int.soccerway.com/".$heading->getNode($index)->childNodes->item(1)->getAttribute("href");
            } else if ("hometeam lineups" == $key || "awayteam lineups" == $key) {
                // get team lineup
                $side = "hometeam lineups" == $key ? "left" : "right";

                $team_lineups = array();
                foreach ($data->filterXPath("//div[contains(@class, block_match_lineups)]/div[contains(@class, '".$side."')]/table[contains(@class, 'playerstats lineups')]/tbody/tr/td[contains(@class, player)]/a/../..") as $row) {
                    // skip coaches and empty rows
                    if (empty($row) || preg_match("/^Coach/", trim($row->textContent))) continue;

                    $url = "http://int.soccerway.com/".$row->childNodes->item(2)->getElementsByTagname('a')->item(0)->getAttribute("href");

                    // grab info about goals and cards
                    $yellows = array();
                    $reds = array();
                    $goals = array();
                    foreach ($row->childNodes->item(4)->getElementsByTagName("img") as $booking) {
                        $time = trim($booking->parentNode->textContent);

                        $src = $booking->getAttribute("src");
                        if (preg_match("/Y2?C.png$/", $src)) $yellows[] = $time;
                        if (preg_match("/(R|Y2).png$/", $src)) $reds[] = $time;
                        if (preg_match("/G.png$/", $src)) $goals[] = $time;
                    } // end foreach

                    $team_lineups[] = array($url, $yellows, $reds, $goals);
                } // end foreach

                $match_data[$key] = $team_lineups;
            } else if ("hometeam substitutes" == $key || "awayteam substitutes" == $key) {
                // get team substitutes
                $side = "hometeam substitutes" == $key ? "left" : "right";

                $team_substitutes = array();
                foreach ($data->filterXPath("//div[contains(@class, block_match_substitutes)]/div[contains(@class, '".$side."')]/table[contains(@class, 'playerstats lineups')]/tbody/tr/td[contains(@class, player)]/p[contains(@class, substitute-in)]/a/../../..") as $row) {
                    // skip coaches and empty rows
                    if (empty($row) || preg_match("/^Coach/", trim($row->textContent))) continue;

                    $players = $row->childNodes->item(2)->getElementsByTagName('a');

                    $in_player = "http://int.soccerway.com/".$players->item(0)->getAttribute("href");
                    $out_player = $players->item(1);
                    if (!empty($out_player)) $out_player = "http://int.soccerway.com/".$out_player->getAttribute("href");

                    $subs_time = NULL;
                    preg_match("/\d+(\+\d+)?'/", trim($row->childNodes->item(2)->textContent), $subs_time);
                    $subs_time = empty($subs_time) ? NULL : $subs_time[0];

                    // grab info about goals and cards
                    $yellows = array();
                    $reds = array();
                    $goals = array();
                    foreach ($row->childNodes->item(4)->getElementsByTagName("img") as $booking) {
                        $time = trim($booking->parentNode->textContent);

                        $src = $booking->getAttribute("src");
                        if (preg_match("/Y2?C.png$/", $src)) $yellows[] = $time;
                        if (preg_match("/(R|Y2).png$/", $src)) $reds[] = $time;
                        if (preg_match("/G.png$/", $src)) $goals[] = $time;
                    } // end foreach

                    $team_substitutes[] = array($in_player, $out_player, $subs_time, $yellows, $reds, $goals);
                } // end foreach

                $match_data[$key] = $team_substitutes;
            } else {
                // other data
                $match_data[$key] = NULL;
            } // end if-else
        } // end foreach

        // clear cache to avoid memory exhausting
        $data->clear();
        return $match_data;
    }

    /**
     * @brief Get all the desired competition data from the competition page.
     * @details An example of the competition page can be found at
     * http://int.soccerway.com/international/world/world-cup/c72/
     *
     * @param url The url to the competition page.
     * @param key Array of keys for parsing specific parts of competition data.
     * The following keys are available:
     *
     *      - name
     *      - group matches [array(url)]
     *      - final matches [array(url)]
     *
     * @return Associative array with the keys mapped to either NULL or a value.
     */
    public static function competition_data($url, $keys=array()) {
        // all data in case no keys were given
        if (empty($keys)) $keys = array("name", "group matches", "final matches");

        // load document
        $doc = self::request($url);
        if (empty($doc)) return self::empty_data($keys);    // request failed

        $data = new Crawler();
        $data->addDocument($doc);

        // parse competition data
        $competition_data = array();
        foreach ($keys as $key) {
            $list = $data->filterXPath("//div[contains(@class, block_competition_left_tree)]/ul/li[contains(@class, expanded)]/ul[contains(@class, expanded)]")->getNode(0);

            if ("name" == $key) {
                // get competition name and edition
                $name = $data->filterXPath("//div[@id=\"subheading\"]/h1")->getNode(0);
                $name = empty($name) ? NULL : trim($name->textContent);

                $edition = empty($list) ? NULL : $list->childNodes->item(0);
                $edition = empty($edition) ? NULL : $edition->childNodes->item(1);
                $edition = empty($edition) ? NULL : trim($edition->textContent);

                $competition_data[$key] = !(empty($name) || empty($edition)) ? $name.' '.$edition : NULL;
            } else if ("group matches" == $key || "final matches" == $key) {
                $xpath = "group matches" == $key ? "//div[contains(@class, block_competition_left_tree)]/ul/li/ul/li/ul/li/ul/li/a" : "//div[contains(@class, block_competition_left_tree)]/ul/li/ul/li/ul/li/a";

                // get matches urls
                $matches = array();
                foreach ($data->filterXPath($xpath) as $stage) {
                    $stage_url = $stage->getAttribute("href");
                    if (empty($stage_url) || ("final matches" == $key && strpos($stage_url, "group") !== false)) continue;

                    $stage_page = self::request("http://int.soccerway.com/".$stage_url);
                    if (empty($stage_page)) continue;

                    $stage_data = new Crawler();
                    $stage_data->addDocument($stage_page);

                    foreach ($stage_data->filterXPath("//table[contains(@class, matches)]/tbody/tr[contains(@class, match)]/td[4]/a") as $match_url) {
                        // get match url
                        $match_url = $match_url->getAttribute("href");
                        if (empty($match_url) || preg_match("/^\?/", $match_url)) continue;

                        $matches[] = "http://int.soccerway.com/".$match_url;
                    } // end foreach

                    $stage_data->clear();
                } // end foreach

                $competition_data[$key] = $matches;
            } else {
                // other data
                $competition_data[$key] = NULL;
            } // end if-else
        } // end foreach

        // clear cache to avoid memory exhausting
        $data->clear();
        return $competition_data;
    }

    /**
     * @brief Update the countries from database.
     */
    public static function update_countries() {
        foreach (self::countries_data() as $country_data) {
            $name = $country_data["name"];
            $continent = $country_data["continent"];
            $abbreviation = $country_data["abbreviation"];

            // add continent if necessary
            $ids = Continent::getIDsByName($continent);
            if (empty($ids)) $ids = Continent::add($continent);
            $continent_id = $ids[0]->id;

            // add country if necessary
            $ids = Country::getIDsByName($name);
            if (empty($ids)) $ids = Country::add($name, $continent_id, $abbreviation);
            $country_id = $ids[0]->id;
        } // end foreach

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
                Team::linkPlayer( $player_id, $team_id, $player_data["position"] );
            } // end foreach
        } // end foreach

        return;
    }

    /**
     * @brief Update the competition.
     *
     * @param url The url to be used for parsing competition.
     * @param name The name of the competition (or let the crawler find out).
     */
    public static function update_competition( $url, $name="" ) {
        // get the competition data
        $competition_data = self::competition_data( $url );
        if ( empty( $competition_data ) ) return;

        // get the competition id
        $competition = empty($name) ? $competition_data["name"] : $name;

        $ids = Competition::getIDsByName( $competition );
        if ( empty( $ids ) ) $ids = Competition::add( $competition );
        $competition_id = $ids[0]->id;

        // update match to the competition (and also link team to the competition)
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
            $date = new DateTime( $match_data["date"] . ' ' . $match_data["kick-off"] );
            $date = $date->format( "Y-m-d H:i:s" );

            $ids = Match::getIDs( $hometeam_id, $awayteam_id, $competition_id, $date );
            if ( empty( $ids ) ) $ids = Match::add( $hometeam_id, $awayteam_id, $competition_id, $date );
            $match_id = $ids[0]->id;

            // okay, let's update lineups, substitutes and goals
            foreach ($match_data["home lineups"] as $lineup_data) {
                // get the player id
                $player_data = $lineup_data["player data"];

                $first_name = $player_data["first name"];
                $last_name = $player_data["last name"];
                $player = ( empty( $first_name ) || empty( $last_name ) ) ? NULL : $first_name.' '.$last_name;

                $ids = Player::getIDsByName( $player );
                if ( empty( $ids ) && NULL != $player ) {
                    $ids = Player::add( $player );
                    $player_id = $ids[0]->id;

                    // also link player to team
                    Team::linkPlayer( $player_id, $hometeam_id, $player_data["position"] );
                } // end if
                $player_id = $ids[0]->id;

                // link player to match
                Match::linkPlayer( $player_id, $match_id);

                // cards
                foreach ($lineup_data["yellow cards"] as $time) {
                    if (empty(Card::getIDs( $player_id, $match_id, "yellow", $time ))) Card::add( $player_id, $match_id, "yellow", $time );
                } // end foreach

                foreach ($lineup_data["red cards"] as $time) {
                    if (empty(Card::getIDs( $player_id, $match_id, "red", $time ))) Card::add( $player_id, $match_id, "red", $time );
                } // end foreach

                // goals
                foreach ( $lineup_data["goals"] as $timegoal ) {
                    if ( empty( Goal::getIDs( $match_id, $hometeam_id, $player_id, $time ) ) ) Goal::add( $match_id, $hometeam_id, $player_id, $time );
                } // end foreach

            } // end foreach

            foreach ($match_data["away lineups"] as $lineup_data) {
                // get the player id
                $player_data = $lineup_data["player data"];

                $first_name = $player_data["first name"];
                $last_name = $player_data["last name"];
                $player = ( empty( $first_name ) || empty( $last_name ) ) ? NULL : $first_name.' '.$last_name;

                $ids = Player::getIDsByName( $player );
                if ( empty( $ids ) && NULL != $player ) {
                    $ids = Player::add( $player );
                    $player_id = $ids[0]->id;

                    // also link player to team
                    Team::linkPlayer( $player_id, $awayteam_id, $player_data["position"] );
                } // end if
                $player_id = $ids[0]->id;

                // link player to match
                Match::linkPlayer( $player_id, $match_id);

                // cards
                foreach ($lineup_data["yellow cards"] as $time) {
                    if (empty(Card::getIDs( $player_id, $match_id, "yellow", $time ))) Card::add( $player_id, $match_id, "yellow", $time );
                } // end foreach

                foreach ($lineup_data["red cards"] as $time) {
                    if (empty(Card::getIDs( $player_id, $match_id, "red", $time ))) Card::add( $player_id, $match_id, "red", $time );
                } // end foreach

                // goals
                foreach ( $lineup_data["goals"] as $timegoal ) {
                    if ( empty( Goal::getIDs( $match_id, $awayteam_id, $player_id, $time ) ) ) Goal::add( $match_id, $awayteam_id, $player_id, $time );
                } // end foreach

            } // end foreach

            foreach ($match_data["home substitutes"] as $lineup_data) {
                // get the player id
                $player_data = $lineup_data["player data"];

                $first_name = $player_data["first name"];
                $last_name = $player_data["last name"];
                $player = ( empty( $first_name ) || empty( $last_name ) ) ? NULL : $first_name.' '.$last_name;

                $ids = Player::getIDsByName( $player );
                if ( empty( $ids ) && NULL != $player ) {
                    $ids = Player::add( $player );
                    $player_id = $ids[0]->id;

                    // also link player to team
                    Team::linkPlayer( $player_id, $hometeam_id, $player_data["position"] );
                } // end if
                $player_id = $ids[0]->id;

                // link player to match
                $time = $lineup_data["time"];

                if (empty($time)) continue;
                $out_player = $lineup_data["out player"];

                $out_name = $out_player["first name"].' '.$out_player["last name"];
                $ids = Player::getIDsByName( $out_name );

                if (empty($ids)) continue;
                $out_id = $ids[0]->id;

                // link
                Match::linkPlayer( $player_id, $match_id, $time);
                Match::substitute( $out_id, $time);

                // cards
                foreach ($lineup_data["yellow cards"] as $time) {
                    if (empty(Card::getIDs( $player_id, $match_id, "yellow", $time ))) Card::add( $player_id, $match_id, "yellow", $time );
                } // end foreach

                foreach ($lineup_data["red cards"] as $time) {
                    if (empty(Card::getIDs( $player_id, $match_id, "red", $time ))) Card::add( $player_id, $match_id, "red", $time );
                } // end foreach

                // goals
                foreach ( $lineup_data["goals"] as $timegoal ) {
                    if ( empty( Goal::getIDs( $match_id, $hometeam_id, $player_id, $time ) ) ) Goal::add( $match_id, $hometeam_id, $player_id, $time );
                } // end foreach

            } // end foreach

            foreach ($match_data["away substitutes"] as $lineup_data) {
                // get the player id
                $player_data = $lineup_data["player data"];

                $first_name = $player_data["first name"];
                $last_name = $player_data["last name"];
                $player = ( empty( $first_name ) || empty( $last_name ) ) ? NULL : $first_name.' '.$last_name;

                $ids = Player::getIDsByName( $player );
                if ( empty( $ids ) && NULL != $player ) {
                    $ids = Player::add( $player );
                    $player_id = $ids[0]->id;

                    // also link player to team
                    Team::linkPlayer( $player_id, $awayteam_id, $player_data["position"] );
                } // end if
                $player_id = $ids[0]->id;

                // link player to match
                $time = $lineup_data["time"];

                if (empty($time)) continue;
                $out_player = $lineup_data["out player"];

                $out_name = $out_player["first name"].' '.$out_player["last name"];
                $ids = Player::getIDsByName( $out_name );

                if (empty($ids)) continue;
                $out_id = $ids[0]->id;

                // link
                Match::linkPlayer( $player_id, $match_id, $time);
                Match::substitute( $out_id, $time);

                // cards
                foreach ($lineup_data["yellow cards"] as $time) {
                    if (empty(Card::getIDs( $player_id, $match_id, "yellow", $time ))) Card::add( $player_id, $match_id, "yellow", $time );
                } // end foreach

                foreach ($lineup_data["red cards"] as $time) {
                    if (empty(Card::getIDs( $player_id, $match_id, "red", $time ))) Card::add( $player_id, $match_id, "red", $time );
                } // end foreach

                // goals
                foreach ( $lineup_data["goals"] as $timegoal ) {
                    if ( empty( Goal::getIDs( $match_id, $awayteam_id, $player_id, $time ) ) ) Goal::add( $match_id, $awayteam_id, $player_id, $time );
                } // end foreach

            } // end foreach

        } // end foreach

        return;
    }

    /**
     * @brief
     * @param competitions
     */
    public static function update( $competition, $url ) {
        // are there matches to be played?
        if ( !Match::match_played( $competition ) ) return False;

        self::update_competition( $url, $competition );
        return True;
    }

}
