<?php

class Stats {

	function addCard($playerName, $matchID, $color, $time){
		//Look for all players with this name
		$playerIDs = DB::select('SELECT id FROM player WHERE name = ?', array($playerName));
		if (empty($playerIDs)) {
			echo "No players with this name found";
			return false;
		}

		foreach ($playerIDs as $playerID) {
			//Check if this player played in this match and if so, check when exactly
			$results = DB::select('SELECT intime, outtime FROM playerPerMatch WHERE player_id  = ? AND match_id = ?', array($playerID->id, $matchID));
			if (!empty($results)) {
				$intime = $results[0]->intime;
				$outtime = $results[0]->outtime;

				//Was the player playing when he got a card?
				if ($intime <= $time && $time <= $outtime) {
					$result = DB::insert	("INSERT INTO cards (player_id, match_id, color, time) VALUES (?, ?, ?, ?)", 		
					array($playerID->id,
								$matchID,
								$color,
								$time));
					if ($result == 1) {
						echo "Card added";
						return true;
					}
					else {
						echo "Something went wrong while adding card";
						return false;
					}
				}

			}
			echo "Player was not on the field during this time";
			return false;
		}
		echo "None of the players with this name played in this match";
		return false;
	}



	function addCoach($name) {
		$result = DB::insert('INSERT INTO coach (name) VALUES (?)', array($name));
		if($result == 1) {
			echo "Coach added";
			return true;
		}
		else {
			echo "Something went wrong while adding coach";
			return false;
		}
	}



	function addCoachUnique($name) {
		$results = DB::select('SELECT * FROM coach WHERE name = ?', array($name));
		if(!empty($results)) {
			echo "Cocah already in database";
			return false;
		}

		$result = DB::insert('INSERT INTO coach (name) VALUES (?)', array($name));
		if($result == 1) {
			echo "Coach added";
			return true;
		}
		else {
			echo "Something went wrong while adding coach";
			return false;
		}
	}



	function addCompetition($name) {
		$results = DB::select('SELECT * FROM competition WHERE name = ?', array($name));
		if(!empty($results)) {
			echo "Competition already in database";
			return false;
		}

		$result = DB::insert('INSERT INTO competition (name) VALUES (?)', array($name));
		if($result == 1) {
			echo "Competition added";
			return true;
		}
		else {
			echo "Something went wrong while adding competition";
			return false;
		}
	}



	function addContinent($name) {
		$results = DB::select('SELECT * FROM continent WHERE name = ?', array($name));
		if(!empty($results)) {
			echo "Continent already in database";
			return false;
		}

		$result = DB::insert('INSERT INTO continent (name) VALUES (?)', array($name));
		if($result == 1) {
			echo "Continent added";
			return true;
		}
		else {
			echo "Something went wrong while adding continent";
			return false;
		}
	}



	function addCountry($countryName, $continentName, $abbreviation) {
		$results = DB::select('SELECT id FROM continent WHERE name = ?', array($continentName));
		if(empty($results)) {
			echo "Continent not in database";
			return false;
		}
		$continentID = $results[0]->id;

		$results = DB::select('SELECT * FROM country WHERE name = ?', array($countryName));
		if(!empty($results)) {
			echo "Country already in database";
			return false;
		}

		$result = DB::insert('INSERT INTO country (name, continent_id, abbreviation) VALUES (?, ?, ?)', array($countryName, $continentID));
		if($result == 1) {
			echo "Country added";
			return true;
		}
		else {
			echo "Something went wrong while adding country";
			return false;
		}
	}



	function addGoal($matchID, $time, $playerName, $teamName, $penaltyPhase) {

		$results = DB::select('SELECT id FROM `team` WHERE name = ?', array($teamName));
		if(empty($results)) {
			echo "Team not in database";
			return false;
		}
		$teamID = $results[0]->id;

		$results = DB::select('SELECT hometeam_id, awayteam_id FROM `match` WHERE id = ?', array($matchID));
		if(empty($results)) {
			echo "Match not in database";
			return false;
		}
		$homeTeamID = $results[0]->hometeam_id;
		$awayTeamID = $results[0]->awayteam_id;

		if($teamID != $homeTeamID && $teamID != $awayTeamID) {
			echo "Team did not play in this match";
			return false;
		}

		$playerIDs = DB::select('SELECT id FROM player WHERE name = ?', array($playerName));
		if (empty($playerIDs)) {
			echo "No players with this name found";
			return false;
		}

		foreach ($playerIDs as $playerID) {
			$results = DB::select('SELECT intime, outtime FROM playerPerMatch WHERE player_id = ? and match_id = ?', array($playerID->id, $matchID));
			if(empty($results)) {
				continue;
			}
			$intime = $results[0]->intime;
			$outtime = $results[0]->outtime;
			if ($intime <= $time && $time <= $outtime) {

				$results = DB::select('SELECT * FROM goal WHERE match_id = ? AND time = ? AND player_id = ? AND team_id = ? AND penaltyphase = ?', 
										array($matchID, $time, $playerID->id, $teamID, $penaltyPhase));
				if(!empty($results)) {
					echo "Goal already in database";
					return false;
				}

				$result = DB::insert('INSERT INTO goal (match_id, time, player_id, team_id, penaltyphase) VALUES (?, ?, ?, ?, ?)', 
										array($matchID, $time, $playerID->id, $teamID, $penaltyPhase));
				if($result == 1) {
					echo "Goal added";
					return true;
				}
				else {
					echo "Something went wrong while adding goal";
					return false;
				}
			}
			else {
				echo "Player not on field during time of goal";
				return false;
			}	
		}
		echo "No player with this name played in this match";
		return false;
	}



	function addMatch($homeTeamName, $awayTeamName, $competitionName) {
		$results = DB::select('SELECT id FROM team WHERE name = ?', array($homeTeamName));
		if(empty($results)) {
			echo "Home team not in database";
			return false;
		}
		$homeTeamID = $results[0]->id;

		$results = DB::select('SELECT id FROM team WHERE name = ?', array($awayTeamName));
		if(empty($results)) {
			echo "Away team not in database";
			return false;
		}
		$awayTeamID = $results[0]->id;

		$results = DB::select('SELECT id FROM competition WHERE name = ?', array($competitionName));
		if(empty($results)) {
			echo "Competition not in database";
			return false;
		}
		$competitionID = $results[0]->id;

		$results = DB::select('SELECT * FROM teamPerCompetition WHERE team_id = ? AND competition_id = ?', array($homeTeamID, $competitionID));
		if(empty($results)) {
			echo "Home team not in competition";
			return false;
		}

		$results = DB::select('SELECT * FROM teamPerCompetition WHERE team_id = ? AND competition_id = ?', array($awayTeamID, $competitionID));
		if(empty($results)) {
			echo "Away team not in competition";
			return false;
		}

		$results = DB::select('SELECT * FROM `match` WHERE hometeam_id = ? AND awayteam_id = ? AND competition_id = ?', 
								array($homeTeamID, $awayTeamID, $competitionID));
		if(!empty($results)) {
			echo "Match already in database";
			return false;
		}

		$result = DB::insert('INSERT INTO `match` (hometeam_id, awayteam_id, competition_id) VALUES (?, ?, ?)', 
								array($homeTeamID, $awayTeamID, $competitionID));
		if($result == 1) {
			echo "Match added";
			return true;
		}
		else {
			echo "Something went wrong while adding match";
			return false;
		}
	}


	function addPlayer($name, $injured) {
		$result = DB::insert('INSERT INTO player (name, injured) VALUES (?, ?)', array($name, $injured));
		if($result == 1) {
			echo "Player added";
			return true;
		}
		else {
			echo "Something went wrong while adding player";
			return false;
		}
	}

	//Won't add player if player with same name is already in db
	function addPlayerUnique($name, $injured) {
		$results = DB::select('SELECT * FROM player WHERE name = ?', array($name));
		if(!empty($results)) {
			echo "Player already in database";
			return false;
		}

		$result = DB::insert('INSERT INTO player (name, injured) VALUES (?, ?)', array($name, $injured));
		if($result == 1) {
			echo "Player added";
			return true;
		}
		else {
			echo "Something went wrong while adding player";
			return false;
		}
	}



	//Won't check for playerPerTeam entry
	function addPlayerPerMatch($playerName, $matchID, $intime, $outtime) {
		$results = DB::select('SELECT id FROM player WHERE name = ?', array($playerName));
		if(empty($results)) {
			echo "Player not in database";
			return false;
		}
		$playerID = $results[0]->id;

		$results = DB::select('SELECT id FROM `match` WHERE id = ?', array($matchID));
		if(empty($results)) {
			echo "Match not in database";
			return false;
		}

		$results = DB::select('SELECT * FROM playerPerMatch WHERE player_id = ? AND match_id = ?', array($playerID, $matchID));
		if(!empty($results)) {
			echo "Player/match combination already in database";
			return false;
		}
		$result = DB::insert('INSERT INTO playerPerMatch (player_id, match_id, intime, outtime) VALUES (?, ?, ?, ?)', 
									array($playerID, $matchID, $intime, $outtime));
		if($result == 1) {
			echo "Player per match added";
			return true;
		}
		else {
			echo "Something went wrong while adding player per match";
			return false;
		}
	}



	//Will only add player per match if there is a playerPerTeam entry with the player and one of the two teams in the match
	function addPlayerPerMatchStrict($playerName, $matchID, $intime, $outtime) {
		$results = DB::select('SELECT id FROM player WHERE name = ?', array($playerName));
		if(empty($results)) {
			echo "Player not in database";
			return false;
		}
		$playerID = $results[0]->id;

		$results = DB::select('SELECT hometeam_id, awayteam_id FROM `match` WHERE id = ?', array($matchID));
		if(empty($results)) {
			echo "Match not in database";
			return false;
		}
		$homeTeamID = $results[0]->hometeam_id;
		$awayTeamID = $results[0]->awayteam_id;

		$resultsA = DB::select('SELECT * FROM playerPerTeam WHERE player_id = ? AND team_id = ?', array($playerID, $homeTeamID));
		$resultsB = DB::select('SELECT * FROM playerPerTeam WHERE player_id = ? AND team_id = ?', array($playerID, $awayTeamID));
		if (empty($resultsA) && empty($resultsB)) {
			echo "Player plays for neither team";
			return false;
		}

		$results = DB::select('SELECT * FROM playerPerMatch WHERE player_id = ? AND match_id = ?', array($playerID, $matchID));
		if(!empty($results)) {
			echo "Player/match combination already in database";
			return false;
		}
		$result = DB::insert('INSERT INTO playerPerMatch (player_id, match_id, intime, outtime) VALUES (?, ?, ?, ?)', 
									array($playerID, $matchID, $intime, $outtime));
		if($result == 1) {
			echo "Player per match added";
			return true;
		}
		else {
			echo "Something went wrong while adding Player per match";
			return false;
		}
	}



	function addPlayerPerTeam($playerName, $teamName) {
		$results = DB::select('SELECT id FROM player WHERE name = ?', array($playerName));
		if(empty($results)) {
			echo "Player not in database";
			return false;
		}
		$playerID = $results[0]->id;

		$results = DB::select('SELECT id FROM team WHERE name = ?', array($teamName));
		if(empty($results)) {
			echo "Team not in database";
			return false;
		}
		$teamID = $results[0]->id;

		$results = DB::select('SELECT * FROM playerPerTeam WHERE player_id = ? AND team_id = ?', array($playerID, $teamID));
		if(!empty($results)) {
			echo "Player/team combination already in database";
			return false;
		}

		$result = DB::insert('INSERT INTO playerPerTeam (player_id, team_id) VALUES (?, ?)', array($playerID, $teamID));
		if($result == 1) {
			echo "Player per team added";
			return true;
		}
		else {
			echo "Something went wrong while adding Player per team";
			return false;
		}
	}



	function addTeam($teamName, $countryName, $coachName) {
		$results = DB::select('SELECT id FROM country WHERE name = ?', array($countryName));
		if(empty($results)) {
			echo "Country not in database";
			return false;
		}
		$countryID = $results[0]->id;

		$results = DB::select('SELECT id FROM coach WHERE name = ?', array($coachName));
		if(empty($results)) {
			echo "Coach not in database";
			return false;
		}
		$coachID = $results[0]->id;

		$results = DB::select('SELECT * FROM team WHERE name = ?', array($teamName));
		if(!empty($results)) {
			echo "Team already in database";
			return false;
		}

		$result = DB::insert('INSERT INTO team (name, country_id, coach_id) VALUES (?, ?, ?)', array($teamName, $countryID, $coachID));
		if($result == 1) {
			echo "Team added";
			return true;
		}
		else {
			echo "Something went wrong while adding team";
			return false;
		}
	}



	function addTeamPerCompetition($teamName, $competitionName) {
		$results = DB::select('SELECT id FROM team WHERE name = ?', array($teamName));
		if(empty($results)) {
			echo "Team not in database";
			return false;
		}
		$teamID = $results[0]->id;

		$results = DB::select('SELECT * FROM competition WHERE name = ?', array($competitionName));
		if(empty($results)) {
			echo "Competition not in database";
			return false;
		}
		$competitionID = $results[0]->id;

		$results = DB::select('SELECT * FROM teamPerCompetition WHERE team_id = ? AND competition_id = ?', array($teamID, $competitionID));
		if(!empty($results)) {
			echo "Team/Competition combination already in database";
			return false;
		}

		$result = DB::insert('INSERT INTO teamPerCompetition (team_id, competition_id) VALUES (?, ?)', array($teamID, $competitionID));
		if($result == 1) {
			echo "Team per competition added";
			return true;
		}
		else {
			echo "Something went wrong while adding team per competition";
			return false;
		}
	}



}
