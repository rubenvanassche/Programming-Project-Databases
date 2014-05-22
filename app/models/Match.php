<?php

/**
 * @class Match
 * @brief Core data model of a match.
 */
class Match {

    /**
     * @var TABLE_MATCH
     * @brief The match table from database.
     */
    const TABLE_MATCH = "match";

    /**
     * @var TABLE_PLAYER_PER_MATCH
     * @brief The table where each player is linked to a match.
     */
    const TABLE_PLAYER_PER_MATCH = "playerPerMatch";

    /**
     * @brief Get The ids of a given match.
     * @param hometeam_id The ID of the hometeam.
     * @param awayteam_id The ID of the awayteam.
     * @param competition_id The ID of the competition.
     * @param date The date of the match.
     * @return The query after the results.
     */
    public static function getIDs( $hometeam_id, $awayteam_id, $competition_id, $date ) {
        $query = "SELECT * FROM `".self::TABLE_MATCH."` WHERE hometeam_id = ? AND awayteam_id = ? AND competition_id = ? AND date = ?";
        $values = array( $hometeam_id, $awayteam_id, $competition_id, $date );
        return DB::select( $query, $values );
    }

    /**
     * @brief Add a match into the database.
     * @param hometeam_id The ID of the hometeam.
     * @param awayteam_id The ID of the awayteam.
     * @param competition_id The ID of the competition.
     * @param date The date of the match.
     * @return The IDs of the given match.
     */
    public static function add( $hometeam_id, $awayteam_id, $competition_id, $date ) {
        $query = "INSERT INTO `".self::TABLE_MATCH."` (hometeam_id, awayteam_id, competition_id, date) VALUES (?, ?, ?, ?)";
        $values = array( $hometeam_id, $awayteam_id, $competition_id, $date );
        DB::insert( $query, $values );
        return self::getIDs( $hometeam_id, $awayteam_id, $competition_id, $date );
    }

    /**
     * @brief Link player to the match.
     * @param player_id The ID of the player.
     * @param match_id The ID of the match.
     * @return True if new link created, False otherwise.
     */
    public static function linkPlayer( $player_id, $match_id ) {
        // first check whether the link was already created
        $query = "SELECT * FROM `".self::TABLE_PLAYER_PER_MATCH."` WHERE player_id = ? AND match_id = ?";
        $values = array( $player_id, $team_id );
        $sql = DB::select( $query, $values );
        if ( !empty( $sql ) ) return False;

        $query = 'INSERT INTO `'.self::TABLE_PLAYER_PER_MATCH.'` (player_id, team_id) VALUES (?, ?)';
        $values = array( $player_id, $team_id );
        DB::insert( $query, $values );
        return True;
    }

    /**
     * @brief Check whether there are matches already played.
     * @param competition The competition to be checked.
     * @return True if there are match played, False otherwise.
     */
    public static function match_played( $competition ) {
        // ask competition id (if any)
        $query = "SELECT id FROM `competition` WHERE name = ?";
        $values = array( $competition );
        $sql = DB::select( $query, $values );

        if ( empty( $sql ) ) return False;

        // get competition id and current date
        $competition_id = $sql[0]->id;
        $now = new DateTime();

        // get all matches past today's date
        $query = "SELECT `id`, `date` FROM `match` WHERE `competition_id` = ? AND `date` <= ?";
        $values = array( $competition_id, $now->format( "Y-m-d H:i:s" ) );
        $sql = DB::select( $query, $values );

        return !( empty( $sql ) );
    }

    // TODO DOCUMENTIZE
    public static function getRecentMatches($amount){
        // Will return a certain amount of last played matches.
        $results = DB::select("SELECT * FROM `match` WHERE date < CURDATE() ORDER BY date DESC LIMIT ?", array($amount));
        return $results;
    }

    public static function getFutureMatches($amount){
        // Will return a certain amount of closest future matches.
        $results = DB::select("SELECT * FROM `match` WHERE date > CURDATE() ORDER BY date LIMIT ?", array($amount));
        return $results;
    }

    public static function getScore($matchID){
        $results = DB::select('SELECT
                                (SELECT COUNT(id) FROM goal WHERE team_id = `match`.hometeam_id AND match_id = `match`.id) as hometeam_score,
                                (SELECT COUNT(id) FROM goal WHERE team_id = `match`.awayteam_id AND match_id = `match`.id) as awayteam_score
                                FROM `match` WHERE id = ?', array($matchID));
        return $results[0]->hometeam_score." - ".$results[0]->awayteam_score;
    }

    public static function get($matchID){
        $results = DB::select("SELECT date,
                                hometeam_id,
                                awayteam_id,
                                (SELECT name FROM team WHERE id = `match`.hometeam_id) AS hometeam,
                                (SELECT name FROM team WHERE id = `match`.awayteam_id) AS awayteam,
                                (SELECT COUNT(id) FROM goal WHERE team_id = `match`.hometeam_id AND match_id = `match`.id) as hometeam_score,
                                (SELECT COUNT(id) FROM goal WHERE team_id = `match`.awayteam_id AND match_id = `match`.id) as awayteam_score
                                FROM `match` WHERE id = ?", array($matchID));
        return $results[0];
    }

    public static function goals($matchID, $teamID){
        $results = DB::select("SELECT time, (SELECT name FROM player WHERE id = goal.player_id) as player,
											(SELECT id FROM player WHERE id = goal.player_id) as player_id FROM goal
																										WHERE match_id = ? AND team_id = ?", array($matchID, $teamID));
        return $results;
    }

    public static function cards($matchID, $teamID){
        $results = DB::select("SELECT color, time, (SELECT name FROM player WHERE player.id = cards.player_id) AS player,
												   player_id FROM cards
									WHERE match_id = ?
										  AND EXISTS (SELECT playerPerTeam.player_id FROM playerPerTeam
																WHERE playerPerTeam.player_id = cards.player_id
																AND playerPerTeam.team_id = ?)", array($matchID, $teamID));
        return $results;
    }


    public static function getScore2($matchID){
        $results = DB::select('SELECT
                                (SELECT COUNT(id) FROM goal WHERE team_id = `match`.hometeam_id AND match_id = `match`.id) as hometeam_score,
                                (SELECT COUNT(id) FROM goal WHERE team_id = `match`.awayteam_id AND match_id = `match`.id) as awayteam_score
                                FROM `match` WHERE id = ?', array($matchID));
        return array($results[0]->hometeam_score, $results[0]->awayteam_score);
    }

	public static function getFirstGoalTeam($matchID) {
		$results = DB::select("SELECT team_id FROM goal WHERE match_id = ? AND time = (SELECT min(time) FROM goal WHERE match_id = ?)", array($matchID, $matchID));
		if (empty($results))
			return NULL;
		else
			return $results[0]->team_id;
	}

	public static function getCardCounts($matchID) {
		//Color 0 is yellow, color 1 is red
		$hometeam = DB::select("SELECT hometeam_id FROM `match` WHERE id = ?", array($matchID))[0]->hometeam_id;
		$awayteam = DB::select("SELECT awayteam_id FROM `match` WHERE id = ?", array($matchID))[0]->awayteam_id;
		$hometeam_yellows = DB::select("SELECT count(player_id) AS yellows FROM cards WHERE color = 0
																	AND match_id = ?
										  AND EXISTS (SELECT playerPerTeam.player_id FROM playerPerTeam
																WHERE playerPerTeam.player_id = cards.player_id
																AND playerPerTeam.team_id = ?)",
										array($matchID, $hometeam));
		$hometeam_reds = DB::select("SELECT count(player_id) AS reds FROM cards WHERE color = 1
																	AND match_id = ?
										  AND EXISTS (SELECT playerPerTeam.player_id FROM playerPerTeam
																WHERE playerPerTeam.player_id = cards.player_id
																AND playerPerTeam.team_id = ?)",
										array($matchID, $hometeam));
		$awayteam_yellows = DB::select("SELECT count(player_id) AS yellows FROM cards WHERE color = 0
																	AND match_id = ?
										  AND EXISTS (SELECT playerPerTeam.player_id FROM playerPerTeam
																WHERE playerPerTeam.player_id = cards.player_id
																AND playerPerTeam.team_id = ?)",
										array($matchID, $awayteam));
		$awayteam_reds = DB::select("SELECT count(player_id) AS reds FROM cards WHERE color = 1
																	AND match_id = ?
										  AND EXISTS (SELECT playerPerTeam.player_id FROM playerPerTeam
																WHERE playerPerTeam.player_id = cards.player_id
																AND playerPerTeam.team_id = ?)",
										array($matchID, $awayteam));
		return array($hometeam_yellows[0]->yellows, $hometeam_reds[0]->reds, $awayteam_yellows[0]->yellows, $awayteam_reds[0]->reds);
	}

    public static function getMatchByID($matchID) {
        $results = DB::select('SELECT * FROM `match` WHERE id = ?', array($matchID));
        return $results;
    }

    public static function getMatchByTeams($hometeam_id, $awayteam_id) {
        $results = DB::select('SELECT * FROM `match` WHERE hometeam_id = ? AND awayteam_id = ?', array($hometeam_id, $awayteam_id));
        return $results;
    }

    public static function getMatchByHometeam($hometeam_id) {
        $results = DB::select('SELECT * FROM `match` WHERE hometeam_id = ?', array($hometeam_id));
        return $results;
    }

    public static function getMatchByAwayteam($awayteam_id) {
        $results = DB::select('SELECT * FROM `match` WHERE awayteam_id = ?', array($awayteam_id));
        return $results;
    }

    public static function getMatchByTeamsAndDate($hometeam_id, $awayteam_id, $date) {
        $results = DB::select('SELECT * FROM `match` WHERE hometeam_id = ? AND awayteam_id = ? AND date = ?', array($hometeam_id, $awayteam_id, $date));
		if (empty($results))
			return NULL;
		else
	        return $results[0];
    }

    public static function getInfo($rm) {
    		$recentTeamMatches = array();
    		$matchGoals = array();
    		$countryFlags = array();

            $hid = Team::getTeambyID($rm->hometeam_id);
            $aid = Team::getTeambyID($rm->awayteam_id);
            array_push($recentTeamMatches, $hid, $aid);

            $hGoals = Match::goals($rm->id, $rm->hometeam_id);
            $aGoals = Match::goals($rm->id, $rm->awayteam_id);

            array_push($matchGoals, $hGoals, $aGoals);

            $hFlag = Country::getCountry($hid[0]->country_id);
            $aFlag = Country::getCountry($aid[0]->country_id);


            array_push($countryFlags, $hFlag, $aFlag);

            $match = Match::get($rm->id);

            $info = array();
            array_push($info, $matchGoals, $countryFlags, $recentTeamMatches, $match, $rm->id);

            return $info;
    }

	public static function isInFuture($matchID) {
		$now = date('y-m-d h:i:s', time());;
		//Convert sql datetime to php datetime
		$match = Match::getMatchByID($matchID)[0];
		$matchDateTime = new DateTime($match->date);
		$matchDateTime = $matchDateTime->format("Y-m-d h:i:s");
		return $matchDateTime > $now;
	}

	public static function isPlayed($matchID) {
		$now = new DateTime();
		$now = $now->format("Y-m-d h:i:s");
		//Convert sql datetime to php datetime
		$match = Match::getMatchByID($matchID)[0];
		$matchDateTime = new DateTime($match->date);
		$matchDateTime->add(new DateInterval('PT3H'));  //+3 hours, match should be over by then
		$matchDateTime = $matchDateTime->format("Y-m-d h:i:s");
		return $matchDateTime < $now;
	}

  public static function getNextMatches($days) {
    // Returns all matches that will be played in the following $days.
    $results = DB::select('
      SELECT `match`.id, date, hometeam_id, awayteam_id, (SELECT name FROM team WHERE id = `match`.hometeam_id) AS hometeam,
      (SELECT name FROM team WHERE id = `match`.awayteam_id) AS awayteam
      FROM `match`
      WHERE DATEDIFF(`date`, CURDATE()) <= ?
      AND DATEDIFF(`date`, CURDATE()) >= 0', array($days));

    return $results;
  }

  public static function getNextUnbetMatches($days, $user) {
    // Returns all matches that will be played in the following $days where $user hasn't yet bet on.
    if (Bet::noBets()) {
      return Match::getNextMatches($days);
    }
    else {
      $results = DB::select('
        SELECT `match`.id, date, hometeam_id, awayteam_id, (SELECT name FROM team WHERE id = `match`.hometeam_id) AS hometeam,
          (SELECT name FROM team WHERE id = `match`.awayteam_id) AS awayteam
          FROM `match`, `bet`
          WHERE DATEDIFF(`date`, CURDATE()) <= ?
          AND DATEDIFF(`date`, CURDATE()) >= 0
          AND `match`.id NOT IN (
            SELECT match_id
            FROM `bet`
            WHERE `bet`.user_id = ?)
        ', array($days, $user->id));

      return $results;
    }
  }

  public static function getNextMatchesCustom($days, $user) {
    $unbet = Match::getNextUnbetMatches($days, $user);
    $all = Match::getNextMatches($days);
    foreach($all as $match) {
      if (Bet::noBets() || in_array($match, $unbet)) {
        $match->bet = false;
      }
      else {
        $match->bet = true;
      }
    }
    return $all;
  }
}
