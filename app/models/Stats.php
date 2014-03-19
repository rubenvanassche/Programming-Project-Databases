<?php


/**
 * @class Duplicate
 * @brief Exception thrown in case an entry is already in the DB, so you 
 * cannot insert the entry into the database again.
 */
class Duplicate extends Exception {}

class MissingEntry extends Exception{}

class ConflictingData extends Exception{}

class FailedInsert extends Exception{}

class Stats {

	static function addCard($playerName, $matchID, $color, $time){
		//Check if matchID is valid if one was provided
		if ($matchID != NULL) {
			$result = DB::select('SELECT id FROM `match` WHERE id = ?', array($matchID));
			if (empty($result)) {
				throw new MissingEntry("No match with id " . $matchID . " found while inserting card with player name " . $playerName . ", color "  . $color . " and time " . $time);
			}
		}
		//Set playerID to NULL if no playerName provided, else go look for the correct ID
		if ($playerName == NULL) {
			$playerID = NULL;
		}
		else {
			$playerID = NULL;  //placeholder value
			$playerIDs = DB::select('SELECT id FROM player WHERE name = ?', array($playerName));
			if (empty($playerIDs)) {
				throw new MissingEntry("No player with name " . $playerName . " found while inserting card with matchID " . $matchID . ", color "  . $color . " and time " . $time);
			}

			foreach ($playerIDs as $thisPlayerID) {
				//Check if this player played in this match and if so, check when exactly
				$results = DB::select('SELECT intime, outtime FROM playerPerMatch WHERE player_id  = ? AND match_id = ?', array($thisPlayerID->id, $matchID));
				if (!empty($results)) {
					$intime = $results[0]->intime;
					$outtime = $results[0]->outtime;
					$playerID = $thisPlayerID->id;
					//Was the player playing when he got a card? (only check if time was provided)
					if ($time != NULL && ($intime > $time || $time > $outtime)) {
							throw new ConflictingData("Player with name " . $playerName . " was only on field between " . $intime . " and " . $outtime . 
																				" but received card at " . $time . " while adding card with matchID " . $matchID . " and color "  . $color);
					}
					break; //playerID found

				}
			}
		}
		//If a name was provided but no ID was found
		if ($playerName != NULL && $playerID == NULL) {
			throw new MissingEntry("No player with name " . $playerName . " played in match with ID " . $matchID . " while adding card with color " . $color . " and time " . $time);
			return false;
		}

		$result = DB::insert	("INSERT INTO cards (player_id, match_id, color, time) VALUES (?, ?, ?, ?)", 		
		array($playerID,
					$matchID,
					$color,
					$time));
		if ($result == 1) {
			echo "Card added";
			return true;
		}
		else {
			throw new FailedInsert("Failed to insert card with player name " . $playerName . ", matchID " . $matchID . ", color " . $color . " and time " . $time);
		}

	}



	static function addCoach($name) {
		$result = DB::insert('INSERT INTO coach (name) VALUES (?)', array($name));
		if($result == 1) {
			echo "Coach added";
			return true;
		}
		else {
			throw new FailedInsert("Failed to insert coach with name " . $Name);
		}
	}



	static function addCoachUnique($name) {
		$results = DB::select('SELECT * FROM coach WHERE name = ?', array($name));
		if(!empty($results)) {
			throw new Duplicate("Coach with name " . $name . " already in database");
		}

		$result = DB::insert('INSERT INTO coach (name) VALUES (?)', array($name));
		if($result == 1) {
			echo "Coach added";
			return true;
		}
		else {
			throw new FailedInsert("Failed to insert coach with name " . $Name);
		}
	}



	static function addCompetition($name) {
		$results = DB::select('SELECT * FROM competition WHERE name = ?', array($name));
		if(!empty($results)) {
			throw new Duplicate("Competition with name " . $name . " already in database");
		}

		$result = DB::insert('INSERT INTO competition (name) VALUES (?)', array($name));
		if($result == 1) {
			echo "Competition added";
			return true;
		}
		else {
			throw new FailedInsert("Failed to insert competition with name " . $Name);
		}
	}



	static function addContinent($name) {
		$results = DB::select('SELECT * FROM continent WHERE name = ?', array($name));
		if(!empty($results)) {
			throw new Duplicate("Continent with name " . $name . " already in database");
		}

		$result = DB::insert('INSERT INTO continent (name) VALUES (?)', array($name));
		if($result == 1) {
			echo "Continent added";
			return true;
		}
		else {
			throw new FailedInsert("Failed to insert competition with name " . $Name);
		}
	}



	static function addCountry($countryName, $continentName, $abbreviation) {
		$results = DB::select('SELECT id FROM continent WHERE name = ?', array($continentName));
		if(empty($results)) {
			throw new MissingEntry("No continent with name " . $continentName . " in database while adding country with name " . $countryName . " and abbreviation " . $abbreviation);
		}
		$continentID = $results[0]->id;

		$results = DB::select('SELECT * FROM country WHERE name = ?', array($countryName));
		if(!empty($results)) {
			throw new Duplicate("Country with name " . $countryName . ", in continent " . $continentName . " and with abbreviation " . $abbreviation . " already in database");
		}

		$result = DB::insert('INSERT INTO country (name, continent_id, abbreviation) VALUES (?, ?, ?)', array($countryName, $continentID, $abbreviation));
		if($result == 1) {
			echo "Country added";
			return true;
		}
		else {
			throw new FailedInsert("Failed to insert country with name " . $Name, ", in continent " . $continentName . " and with abbreviation " . $abbreviation);
		}
	}



	static function addGoal($matchID, $time, $playerName, $teamName, $penaltyPhase) {

		//Find teamID if teamName provided
		if ($teamName != NULL)  {
			$results = DB::select('SELECT id FROM `team` WHERE name = ?', array($teamName));
			if(empty($results)) {
			throw new MissingEntry("No team with name " . $teamName . " in database while adding goal with matchID " . $matchID . ", player name " . $playerName . 
														 ", time " . $time . " and penaltyPhase " . $penaltyPhase);
			}
			$teamID = $results[0]->id;
		}
		else {
			$teamID = NULL;
		}

		//Check if match exists if matchID provided
		if ($matchID != NULL) {
			$results = DB::select('SELECT hometeam_id, awayteam_id FROM `match` WHERE id = ?', array($matchID));
			if(empty($results)) {
			throw new MissingEntry("No match with ID " . $matchID . " in database while adding goal with team name " . $teamName . ", player name " . $playerName . 
														 ", time " . $time . " and penaltyPhase " . $penaltyPhase);
			}
			$homeTeamID = $results[0]->hometeam_id;
			$awayTeamID = $results[0]->awayteam_id;
			//Check if team played in the match if matchID and teamName provided
			if($teamID != NULL && $teamID != $homeTeamID && $teamID != $awayTeamID) {
				throw new MissingEntry("No team with name " . $teamName . " played in match with ID " . $matchID . " while adding goal with player name " . $playerName . 
														 ", time " . $time . " and penaltyPhase " . $penaltyPhase);
			}
		}
		//Set playerID to NULL if no name provided, else find right ID
		if ($playerName == NULL) {
			$playerID = NULL;
		}
		else {
			$playerID = NULL; //placeholder value
			$playerIDs = DB::select('SELECT id FROM player WHERE name = ?', array($playerName));
			if (empty($playerIDs)) {
			throw new MissingEntry("No players with name " . $playerName . " in database while adding goal with matchID " . $matchID . ", team name " . $teamName . 
														 ", time " . $time . " and penaltyPhase " . $penaltyPhase);
			}
	
			//No way to check if player played that match if no matchID provided, so just pick first ID for provided name then
			if ($matchID == NULL && !empty($playerIDs)) {
				$playerID = $playerIDs[0]->id;
			}
			else {
				foreach ($playerIDs as $thisPlayerID) {
					$results = DB::select('SELECT intime, outtime FROM playerPerMatch WHERE player_id = ? and match_id = ?', array($thisPlayerID->id, $matchID));
					if(empty($results)) {
						continue;  //Player didn't play this match, check next
					}
					$intime = $results[0]->intime;
					$outtime = $results[0]->outtime;
					$playerID = $thisPlayerID->id;
					//Check if player was on field if goal time was provided
					if ($time && ($intime > $time || $time > $outtime)) {
							throw new ConflictingData("Player with name " . $playerName .  " was only on field between " . $intime . " and " . $outtime . 
																				" but scored goal at " . $time . " while adding goal with matchID " . $matchID . 
														 						", team name " . $teamName . " and penaltyPhase " . $penaltyPhase);
					}	
				}
			}
		}
		//Only if playerName provided but no ID found
		if ($playerName != NULL && $playerID == NULL) {
				throw new MissingEntry("No player with name " . $playerName . " played in match with ID " . $matchID . " while adding goal with team name " . $teamName . 
														 ", time " . $time . " and penaltyPhase " . $penaltyPhase);
		}
		//Figure out when to check for duplicates!!
		/*
		$results = DB::select('SELECT * FROM goal WHERE match_id = ? AND time = ? AND player_id = ? AND team_id = ? AND penaltyphase = ?', 
								array($matchID, $time, $thisPlayerID->id, $teamID, $penaltyPhase));
		if(!empty($results)) {
			echo "Goal already in database";
			return false;
		}*/

		$result = DB::insert('INSERT INTO goal (match_id, time, player_id, team_id, penaltyphase) VALUES (?, ?, ?, ?, ?)', 
								array($matchID, $time, $playerID, $teamID, $penaltyPhase));
		if($result == 1) {
			echo "Goal added";
			return true;
		}
		else {
			throw new FailedInsert("Failed to insert country with name " . $Name, ", in continent " . $continentName . " and with abbreviation " . $abbreviation);
		}

	}



	static function addMatch($homeTeamName, $awayTeamName, $competitionName, $date) {
		$homeTeamID = NULL;  //only used if no name provided
		$awayTeamID = NULL;
		$competitionID = NULL;
		//Find home team ID if name provided
		if ($homeTeamName != NULL) {
			$results = DB::select('SELECT id FROM team WHERE name = ?', array($homeTeamName));
			if(empty($results)) {
				throw new MissingEntry("Home team with name " . $homeTeamName . " not in database while adding match with away team name " . $awayTeamName . 
														 " and competition name " . $competitionName);
			}
			$homeTeamID = $results[0]->id;
		}

		//Find away team ID if name provided
		if ($awayTeamName != NULL) {
			$results = DB::select('SELECT id FROM team WHERE name = ?', array($awayTeamName));
			if(empty($results)) {
				throw new MissingEntry("Away team with name " . $awayTeamName . " not in database while adding match with home team name " . $homeTeamName . 
														 " and competition name " . $competitionName);
			}
			$awayTeamID = $results[0]->id;
		}

		//Find competitionID if name provided
		if ($competitionName != NULL) {
			$results = DB::select('SELECT id FROM competition WHERE name = ?', array($competitionName));
			if(empty($results)) {
				throw new MissingEntry("Competition with name " . $competitionName . " not in database while adding match with home team name " . $homeTeamName .
															" and away team name " . $awayTeamName);
			}
			$competitionID = $results[0]->id;
		}

		//Check if home team plays in the competition if both provided
		if ($homeTeamID != NULL && $competitionID != NULL) {
			$results = DB::select('SELECT * FROM teamPerCompetition WHERE team_id = ? AND competition_id = ?', array($homeTeamID, $competitionID));
			if(empty($results)) {
				throw new MissingEntry("Home team with name " . $homeTeamName . " not in competition with name " . $competitionName . " while adding match with away team name " . $awayTeamName);
			}
		}

		//Check if away team plays in the competition if both provided
		if ($awayTeamID != NULL && $competitionID != NULL) {

			$results = DB::select('SELECT * FROM teamPerCompetition WHERE team_id = ? AND competition_id = ?', array($awayTeamID, $competitionID));
			if(empty($results)) {
				throw new MissingEntry("Away team with name " . $awayTeamName . " not in competition with name " . $competitionName . " while adding match with home team name " . $homeTeamName);
			}
		}

		//Check for duplicates if all info provided
		if ($homeTeamID != NULL && $awayTeamID != NULL && $competitionID != NULL && $date != NULL) {
			$results = DB::select('SELECT * FROM `match` WHERE hometeam_id = ? AND awayteam_id = ? AND competition_id = ? AND date = ?', 
									array($homeTeamID, $awayTeamID, $competitionID, $date));
			if(!empty($results)) {
				throw new Duplicate("Match with home team name " . $homeTeamName . ", away team name " . $awayTeamName . ", competition " . $competitionName . 
														" and date " . $date . " already in database");
			}
		}

		$result = DB::insert('INSERT INTO `match` (hometeam_id, awayteam_id, competition_id, date) VALUES (?, ?, ?, ?)', 
								array($homeTeamID, $awayTeamID, $competitionID, $date));
		if($result == 1) {
			echo "Match added";
			return true;
		}
		else {
			throw new FailedInsert("Failed to insert match with home team name " . $homeTeamName . ", away team name " . $awayTeamName . " and competition " . $competitionName);
		}
	}


	static function addPlayer($name, $injured) {
		$result = DB::insert('INSERT INTO player (name, injured) VALUES (?, ?)', array($name, $injured));
		if($result == 1) {
			echo "Player added";
			return true;
		}
		else {
			throw new FailedInsert("Failed to insert player with name " . $name);
		}
	}

	//Won't add player if player with same name is already in db
	static function addPlayerUnique($name, $injured) {
		$results = DB::select('SELECT * FROM player WHERE name = ?', array($name));
		if(!empty($results)) {
				throw new Duplicate("Player with name " . $name . " already in database");
		}

		$result = DB::insert('INSERT INTO player (name, injured) VALUES (?, ?)', array($name, $injured));
		if($result == 1) {
			echo "Player added";
			return true;
		}
		else {
			throw new FailedInsert("Failed to insert player with name " . $name);
		}
	}



	//Won't check for playerPerTeam entry
	static function addPlayerPerMatch($playerName, $matchID, $intime, $outtime) {
		//playerPerMatch entry without playerName and matchID is pointless, so have to be provided
		$results = DB::select('SELECT id FROM player WHERE name = ?', array($playerName));
		if(empty($results)) {
				throw new MissingEntry("Player with name " . $playerName . " not in database while adding playerPerMach with matchID " . $matchID . 
															 ", intime " . $intime . " and outtime " . $outtime);
		}
		$playerID = $results[0]->id;

		$results = DB::select('SELECT id FROM `match` WHERE id = ?', array($matchID));
		if(empty($results)) {
				throw new MissingEntry("Match with ID " . $matchID . " not in database while adding playerPerMach with player name " . $playerName . 
															 ", intime " . $intime . " and outtime " . $outtime);
		}

		//If no in-out provided, set to values that will not cause errors elsewhere
		if ($intime == NULL && $outtime == NULL) {
			$intime = 1;
			$outtime = 150;
		}

		$results = DB::select('SELECT * FROM playerPerMatch WHERE player_id = ? AND match_id = ?', array($playerID, $matchID));
		if(!empty($results)) {
				throw new Duplicate("PlayerPerMatch with player name " . $playerName . ", matchID " . $matchID . ", intime " . $intime . 
														" and outtime " . $outtime . " already in database");
		}
		$result = DB::insert('INSERT INTO playerPerMatch (player_id, match_id, intime, outtime) VALUES (?, ?, ?, ?)', 
									array($playerID, $matchID, $intime, $outtime));
		if($result == 1) {
			echo "Player per match added";
			return true;
		}
		else {
			throw new FailedInsert("Failed to insert player with player name " . $playerName . ", matchID " . $matchID . ", intime " . $intime . 
														 " and outtime " . $outtime);
		}
	}



	//Will only add player per match if there is a playerPerTeam entry with the player and one of the two teams in the match
	static function addPlayerPerMatchStrict($playerName, $matchID, $intime, $outtime) {
		//playerPerMatch entry without playerName and matchID is pointless, so have to be provided
		$results = DB::select('SELECT id FROM player WHERE name = ?', array($playerName));
		if(empty($results)) {
				throw new MissingEntry("Player with name " . $playerName . " not in database while adding playerPerMach with matchID " . $matchID . 
															 ", intime " . $intime . " and outtime " . $outtime);
		}
		$playerID = $results[0]->id;

		$results = DB::select('SELECT hometeam_id, awayteam_id FROM `match` WHERE id = ?', array($matchID));
		if(empty($results)) {
				throw new MissingEntry("Match with ID " . $matchID . " not in database while adding playerPerMach with player name " . $playerName . 
															 ", intime " . $intime . " and outtime " . $outtime);
		}
		$homeTeamID = $results[0]->hometeam_id;
		$awayTeamID = $results[0]->awayteam_id;

		$resultsA = DB::select('SELECT * FROM playerPerTeam WHERE player_id = ? AND team_id = ?', array($playerID, $homeTeamID));
		$resultsB = DB::select('SELECT * FROM playerPerTeam WHERE player_id = ? AND team_id = ?', array($playerID, $awayTeamID));
		if (empty($resultsA) && empty($resultsB)) {
			throw new MissingEntry("Player with name " . $playerName . " does not play for either team in match with ID " . $matchID . 
														 " while adding playerPerMatch with intime " . $intime . " and outtime " . $outtime);
		}

		//If no in-out provided, set to values that will not cause errors elsewhere
		if ($intime == NULL && $outtime == NULL) {
			$intime = 1;
			$outtime = 150;
		}

		$results = DB::select('SELECT * FROM playerPerMatch WHERE player_id = ? AND match_id = ?', array($playerID, $matchID));
		if(!empty($results)) {
				throw new Duplicate("PlayerPerMatch with player name " . $playerName . ", matchID " . $matchID . ", intime " . $intime . 
														" and outtime " . $outtime . " already in database");
		}
		$result = DB::insert('INSERT INTO playerPerMatch (player_id, match_id, intime, outtime) VALUES (?, ?, ?, ?)', 
									array($playerID, $matchID, $intime, $outtime));
		if($result == 1) {
			echo "Player per match added";
			return true;
		}
		else {
			throw new FailedInsert("Failed to insert player with player name " . $playerName . ", matchID " . $matchID . ", intime " . $intime . 
														 " and outtime " . $outtime);
		}
	}



	static function addPlayerPerTeam($playerName, $teamName) {
		//Useless without playerName and teamName, so have to be provided
		$results = DB::select('SELECT id FROM player WHERE name = ?', array($playerName));
		if(empty($results)) {
			throw new MissingEntry("Player with name " . $playerName . " not in database while adding playerPerTeam with team name " . $teamName);
		}
		$playerID = $results[0]->id;

		$results = DB::select('SELECT id FROM team WHERE name = ?', array($teamName));
		if(empty($results)) {
			throw new MissingEntry("Team with name " . $teamName . " not in database while adding playerPerTeam with player name " . $playerName);
		}
		$teamID = $results[0]->id;

		$results = DB::select('SELECT * FROM playerPerTeam WHERE player_id = ? AND team_id = ?', array($playerID, $teamID));
		if(!empty($results)) {
				throw new Duplicate("PlayerPerTeam with player name " . $playerName . " and team name " . $teamName . " already in database");
		}

		$result = DB::insert('INSERT INTO playerPerTeam (player_id, team_id) VALUES (?, ?)', array($playerID, $teamID));
		if($result == 1) {
			echo "Player per team added";
			return true;
		}
		else {
				throw new FailedInsert("Failed to insert PlayerPerTeam with player name " . $playerName . " and team name " . $teamName);
		}
	}



	static function addTeam($teamName, $countryName, $coachName, $fifaPoints) {
		$countryID = NULL;
		$coachID = NULL;
		//If countryName provided, find its ID
		if ($countryName != NULL) {
			$results = DB::select('SELECT id FROM country WHERE name = ?', array($countryName));
			if(empty($results)) {
				throw new MissingEntry("Country with name " . $countryName . " not in database while adding team with name " . $teamName . " and coach with name " . $coachName);
			}
			$countryID = $results[0]->id;
		}

		//If coachName provided, find its ID
		if ($coachName != NULL) {
			$results = DB::select('SELECT id FROM coach WHERE name = ?', array($coachName));
			if(empty($results)) {
				throw new MissingEntry("Coach with name " . $coachName . " not in database while adding team with name " . $teamName . " and country with name " . $countryName);
			}
			$coachID = $results[0]->id;
		}

		$results = DB::select('SELECT * FROM team WHERE name = ?', array($teamName));
		if(!empty($results)) {
			throw new Duplicate("Team with name " . $teamName . ", country name " . $countryName . " and coach name " . $coachName . " already in database");
		}

		$result = DB::insert('INSERT INTO team (name, country_id, coach_id, fifapoints) VALUES (?, ?, ?, ?)', array($teamName, $countryID, $coachID, $fifaPoints));
		if($result == 1) {
			echo "Team added";
			return true;
		}
		else {
			throw new FailedInsert("Failed to insert team with name " . $teamName . ", country name " . $countryName . " and coach name " . $coachName);
		}
	}



	static function addTeamPerCompetition($teamName, $competitionName) {
		//Useless without teamName and competitionName, so have to be provided
		$results = DB::select('SELECT id FROM team WHERE name = ?', array($teamName));
		if(empty($results)) {
			throw new MissingEntry("Team with name " . $teamName . " not in database while adding TeamPerCompetition with competition name " . $competitionName);
		}
		$teamID = $results[0]->id;

		$results = DB::select('SELECT * FROM competition WHERE name = ?', array($competitionName));
		if(empty($results)) {
			throw new MissingEntry("Competition with name " . $competitionName . " not in database while adding TeamPerCompetition with team name " . $teamName);
		}
		$competitionID = $results[0]->id;

		$results = DB::select('SELECT * FROM teamPerCompetition WHERE team_id = ? AND competition_id = ?', array($teamID, $competitionID));
		if(!empty($results)) {
			throw new Duplicate("TeamPerCompetition with team name " . $teamName . " and competition name " . $competitionName . " already in database");
		}

		$result = DB::insert('INSERT INTO teamPerCompetition (team_id, competition_id) VALUES (?, ?)', array($teamID, $competitionID));
		if($result == 1) {
			echo "Team per competition added";
			return true;
		}
		else {
			throw new FailedInsert("Failed to insert TeamPerCompetition with team name " . $teamName . " and competition name " . $competitionName);
		}
	}


}
