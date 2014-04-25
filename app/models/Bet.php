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




}

?>
