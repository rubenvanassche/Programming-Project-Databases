<?php

/**
 * @class Bet
 * @brief Core data model of a bet.
 */
class Bet {

    /**
     * @var TABLE_BET
     * @brief The bet table from database.
     */
    const TABLE_BET = "bet";


    /**
     * @brief Add a bet into the database.
     * @param match_id The ID of the match.
     * @param user_id The ID of the user.
     * @param hometeam_score The predicted score of the home team
     * @param awayteam_score The predicted score of the away team
     * @param firstGoal The predicted team scoring first goal
     * @param hometeam_yellows The predicted number of yellow cards for the home team
     * @param hometeam_reds The predicted number of red cards for the home team
     * @param awayteam_yellows The predicted number of yellow cards for the away team
     * @param awayteam_reds The predicted number of red cards for the awat team
     */
    public static function add( $match_id, $user_id, $hometeam_score, $awayteam_score, $firstGoal, $hometeam_yellows, $hometeam_reds, $awayteam_yellows, $awayteam_reds ) {
        $query = "INSERT INTO `".self::TABLE_BET."` (match_id, user_id, hometeam_score, awayteam_score, first_goal, hometeam_yellows, hometeam_reds, awayteam_yellows, awayteam_reds) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $values = array( $match_id, $user_id, $hometeam_score, $awayteam_score, $firstGoal, $hometeam_yellows, $hometeam_reds, $awayteam_yellows, $awayteam_reds );
        DB::insert( $query, $values );
        //return self::getIDs( ... );
		return true;
    }


	/**
	 *@brief get all bets made by a specific user for played matches
	 *@param user_id The id of the user
	 *@return the bets by the user
	 */
	public static function getPastBetsByUserID( $user_id ) {
		//Check if uid exists?
		$results = DB::select("SELECT * FROM bet WHERE user_id = ?
												 AND EXISTS (
														SELECT * FROM `match`
														WHERE id = match_id
														AND date < CURDATE())", array($user_id));
		return $results;
	}

	/**
	 *@brief get all bets made by a specific user for future matches
	 *@param user_id The id of the user
	 *@return the bets by the user
	 */
	public static function getFutureBetsByUserID( $user_id ) {
		//Check if uid exists?
		$results = DB::select("SELECT * FROM bet WHERE user_id = ?
												 AND EXISTS (
														SELECT * FROM `match`
														WHERE id = match_id
														AND date > CURDATE())", array($user_id));
		return $results;
	}

	public static function hasBet( $user_id, $match_id ) {
		$results = DB::select("SELECT id FROM `bet` WHERE user_id = ? AND match_id = ?", array($user_id, $match_id));
		return !(empty($results));
	}

	public static function processBets( $match_id ) {
		$firstBet = DB::select("SELECT evaluated FROM bet WHERE match_id = ? LIMIT 1", array($match_id));
		if ($firstBet == NULL || $firstBet[0]->evaluated == 1)
			return 0; //0 indicates no bets were processed
		$bets = DB::select("SELECT * FROM bet WHERE match_id = ?", array($match_id));
		$match = Match::get($match_id);
		$score = Match::getScore2($match_id);
		$cards = Match::getCardCounts($match_id);
		foreach ($bets as $bet) {
			$user = DB::select("SELECT betscore FROM user WHERE id = $bet->user_id");
			$points = $user[0]->betscore;
			if ($bet->hometeam_score == $score[0] && $bet->awayteam_score == $score[1])
				$points = $points + 30;
			if ($bet->hometeam_score == $score[0] xor $bet->awayteam_score == $score[1])
				$points = $points + 10;
			if ($bet->hometeam_score != $score[0] && $bet->awayteam_score != $score[1])
				$points = $points - 5;
			if ($bet->first_goal != NULL) {
				if ($bet->first_goal == Match::getFirstGoalTeam($match_id))
					$points = $points + 10;
				else
					$points = $points - 5;
			}
			if ($bet->hometeam_yellows != -1) {
				if ($bet->hometeam_yellows == $cards[0])
					$points = $points + 20;
				else
					$points = $points - 5;;
			}
			if ($bet->hometeam_reds != -1) {
				if ($bet->hometeam_reds == $cards[0])
					$points = $points + 20;
				else
					$points = $points - 5;;
			}
			if ($bet->awayteam_yellows != -1) {
				if ($bet->awayteam_yellows == $cards[0])
					$points = $points + 20;
				else
					$points = $points - 5;;
			}
			if ($bet->awayteam_reds != -1) {
				if ($bet->awayteam_reds == $cards[0])
					$points = $points + 20;
				else
					$points = $points - 5;;
			}
			DB::update("UPDATE bet SET evaluated = 1 WHERE id = $bet->id");
			DB::update("UPDATE user SET betscore = $points WHERE id = $bet->user_id");
		}
		return count($bets);
	}

	public static function processAllBets() {
		$now = new DateTime();
		$tomorrow = new DateTime();
		$tomorrow = $tomorrow->add(new DateInterval('P1D'));
		$now = $now->format("Y-m-d H:i:s");
		$tomorrow = $tomorrow->format("Y-m-d H:i:s");
		$matches = DB::select("SELECT id FROM `match` WHERE date > ? AND date < ?", array($now, $tomorrow));
		$totalBetCount = 0;
		$matchCount = 0;
		foreach($matches as $match) {
			$betCount = Bet::processBets($match->id);
			$totalBetCount += $betCount;
			if ($betCount != 0)
				$matchCount += 1;
		}
		return array('matchCount' => $matchCount, 'betCount' => $totalBetCount);
	}

  public static function noBets() {
    $results = DB::select("SELECT * FROM `bet` LIMIT 1");
    if (count($results) > 0) {
      return false;
    }
    else {
      return true;
    }
  }
}

?>
