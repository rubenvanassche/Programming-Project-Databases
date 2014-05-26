<?php

/**
 * @class Team
 * @brief The core data model of a team.
 */
class Prediction {

	public static function predictOutcome($matchID) {
	
		$hometeam_points = 0;
		$awayteam_points = 0;

		$matches = Match::getMatchByID($matchID);
	
		// Get the team id's.
		$hometeam_id = $matches[0]->hometeam_id;
		$awayteam_id = $matches[0]->awayteam_id;
	
		//$hometeams = DB::select('SELECT * FROM team WHERE id = ?', array($hometeam_id));
		//$awayteams = DB::select('SELECT * FROM team WHERE id = ?', array($awayteam_id));
	
		// Get all matches with same setup.
		$same_lineup_matches = Match::getMatchByTeams($hometeam_id, $awayteam_id);
	
		foreach ($same_lineup_matches as $match) {
			$score_home = Match::getScore2($match->id)[0];
			$score_away = Match::getScore2($match->id)[1];

			if ($score_home > $score_away) {
				$hometeam_points += 1;
			}
			elseif ($score_home < $score_away) {
				$awayteam_points += 1;
			}
	 	}
	
		// Get all matches with reverse setup.
		$reverse_lineup_matches = Match::getMatchByTeams($awayteam_id, $hometeam_id);
	
		foreach ($reverse_lineup_matches as $match) {
			$score_home = Match::getScore2($match->id)[0];
			$score_away = Match::getScore2($match->id)[1];

			if ($score_home > $score_away) {
				$awayteam_points += 0.9;
			}
			elseif ($score_home < $score_away) {
				$hometeam_points += 0.9;
			}
		}

	
		// Calculate average win/loss hometeam @ home
		$matches_played = 0;
		$matches_won = 0;
		$matches_hometeam_at_home = Match::getMatchByHometeam($hometeam_id);
	
		foreach ($matches_hometeam_at_home as $match) {
			$score_home = Match::getScore2($match->id)[0];
			$score_away = Match::getScore2($match->id)[1];

			$matches_played++;
			if ($score_home > $score_away) {
				$matches_won++;
			}
		}
	
		// add average to the score.
		if ($matches_played != 0)
			$hometeam_points += $matches_won / $matches_played;
	
		// Calculate average win/loss hometeam @ away
		$matches_played = 0;
		$matches_won = 0;
		$matches_hometeam_at_away = Match::getMatchByAwayteam($hometeam_id);
	
		foreach ($matches_hometeam_at_away as $match) {
			$score_home = Match::getScore2($match->id)[0];
			$score_away = Match::getScore2($match->id)[1];

			$matches_played++;
			if ($score_home < $score_away) {
				$matches_won++;
			}
		}
	
		// add average multiplied by factor to the score.
		if ($matches_played != 0)
			$hometeam_points += 0.9 * ($matches_won / $matches_played);
	
		// Calculate average win/loss awayteam @ away
		$matches_played = 0;
		$matches_won = 0;
		$matches_awayteam_at_away = Match::getMatchByAwayteam($awayteam_id);
	
		foreach ($matches_awayteam_at_away as $match) {
			$score_home = Match::getScore2($match->id)[0];
			$score_away = Match::getScore2($match->id)[1];

			$matches_played++;
			if ($score_home < $score_away) {
				$matches_won++;
			}
		}
	
		// add average to the score.
		if ($matches_played != 0)
			$awayteam_points += $matches_won / $matches_played;
	
		// Calculate average win/loss awayteam @ home
		$matches_played = 0;
		$matches_won = 0;
		$matches_awayteam_at_home = Match::getMatchByHometeam($awayteam_id);

		foreach ($matches_awayteam_at_home as $match) {
			$score_home = Match::getScore2($match->id)[0];
			$score_away = Match::getScore2($match->id)[1];

			$matches_played++;
			if ($score_home > $score_away) {
				$matches_won++;
			}
		}
	
		// add average multiplied by factor to the score.
		if ($matches_played)
			$awayteam_points += 0.9 * ($matches_won / $matches_played);

		$fifapoints_home = Team::getFifaPointsByID($hometeam_id);
		$fifapoints_away = Team::getFifaPointsByID($awayteam_id);

		$hometeam_points += ($fifapoints_home->fifapoints / 1000);
		$awayteam_points += ($fifapoints_away->fifapoints / 1000);

	
		// Make up the chances

	
		$totalpoints = $hometeam_points + $awayteam_points;
	
		$chance_hometeam_wins = $hometeam_points / $totalpoints;
	
		return round($chance_hometeam_wins, 3); //Round to 3 decimals
	
	}

	public static function predictScore($matchID)
	{
		// Average variables for the hometeam
		$avg_same_setup_home_score = 0;
		$avg_reversed_setup_home_score = 0;
		$avg_home_at_home_score = 0;
		$avg_home_at_away_score = 0;

		// Average variables for the awayteam
		$avg_same_setup_away_score = 0;
		$avg_reversed_setup_away_score = 0;
		$avg_away_at_home_score = 0;
		$avg_away_at_away_score = 0;

		$matches = Match::getMatchByID($matchID);
	
		// Get the team id's.
		$hometeam_id = $matches[0]->hometeam_id;
		$awayteam_id = $matches[0]->awayteam_id;
	
		//$hometeams = DB::select('SELECT * FROM team WHERE id = ?', array($hometeam_id));
		//$awayteams = DB::select('SELECT * FROM team WHERE id = ?', array($awayteam_id));
	
		// Get all matches with same setup.
		$same_lineup_matches = Match::getMatchByTeams($hometeam_id, $awayteam_id);
		$goals_scored_home = 0;
		$goals_scored_away = 0;
		$matches_played = 0;
	
		foreach ($same_lineup_matches as $match) {
			$score_home = Match::getScore2($match->id)[0];
			$score_away = Match::getScore2($match->id)[1];
			$matches_played++;
			$goals_scored_home += $score_home;
			$goals_scored_away += $score_away;
	 	}
		if ($matches_played) {
		 	$avg_same_setup_home_score = $goals_scored_home / $matches_played;
		 	$avg_same_setup_away_score = $goals_scored_away / $matches_played;
		}	
		// Get all matches with reverse setup.
		$reverse_lineup_matches = Match::getMatchByTeams($awayteam_id, $hometeam_id);

		$goals_scored_home = 0;
		$goals_scored_away = 0;
		$matches_played = 0;
	
		foreach ($reverse_lineup_matches as $match) {
			$score_home = Match::getScore2($match->id)[0];
			$score_away = Match::getScore2($match->id)[1];
			$matches_played++;
			$goals_scored_home += $score_away;
			$goals_scored_away += $score_home;
		}

		if ($matches_played) {
			$avg_reversed_setup_home_score = $goals_scored_home / $matches_played;
			$avg_reversed_setup_away_score = $goals_scored_away / $matches_played;
		}
	
		// Calculate average win/loss hometeam @ home
		$matches_hometeam_at_home = Match::getMatchByHometeam($hometeam_id);

		$goals_scored_home = 0;
		$matches_played = 0;
	
		foreach ($matches_hometeam_at_home as $match) {
			$score_home = Match::getScore2($match->id)[0];
			$score_away = Match::getScore2($match->id)[1];
			$matches_played++;
			$goals_scored_home += $score_home;
		}
	
		// add average to the score.
		if ($matches_played)
				$avg_home_at_home_score = $goals_scored_home / $matches_played;
	
		// Calculate average win/loss hometeam @ away
		$matches_hometeam_at_away = Match::getMatchByAwayteam($hometeam_id);
	
		$goals_scored_home = 0;
		$matches_played = 0;
	
		foreach ($matches_hometeam_at_home as $match) {
			$score_home = Match::getScore2($match->id)[0];
			$score_away = Match::getScore2($match->id)[1];
			$matches_played++;
			$goals_scored_home += $score_away;
		}
	
		// add average to the score.
		if ($matches_played)
			$avg_home_at_away_score = $goals_scored_home / $matches_played;
	
		// Calculate average win/loss awayteam @ away
		$matches_awayteam_at_away = Match::getMatchByAwayteam($awayteam_id);
		$goals_scored_away = 0;
		$matches_played = 0;
	
		foreach ($matches_awayteam_at_away as $match) {
			$score_home = Match::getScore2($match->id)[0];
			$score_away = Match::getScore2($match->id)[1];
			$matches_played++;
			$goals_scored_away += $score_away;
		}
	
		// add average to the score.
		if ($matches_played)
			$avg_away_at_away_score += $goals_scored_away / $matches_played;
	
		// Calculate average win/loss awayteam @ home
		$matches_awayteam_at_home = Match::getMatchByHometeam($awayteam_id);
	
		$goals_scored_away = 0;
		$matches_played = 0;
	
		foreach ($matches_awayteam_at_away as $match) {
			$score_home = Match::getScore2($match->id)[0];
			$score_away = Match::getScore2($match->id)[1];
			$matches_played++;
			$goals_scored_away += $score_home;
		}
	
		// add average to the score.
		if ($matches_played)
			$avg_away_at_home_score += $goals_scored_away / $matches_played;
	
		$home_team_score = round(($avg_same_setup_home_score + ($avg_reversed_setup_home_score * 0.9) + ($avg_home_at_home_score * 0.7) + ($avg_home_at_away_score * 0.5)) / 3.1);
		$away_team_score = round(($avg_same_setup_away_score + ($avg_reversed_setup_away_score * 0.9) + ($avg_away_at_home_score * 0.7) + ($avg_away_at_away_score * 0.5)) / 3.1);

		$match_chance = Prediction::predictOutcome($matchID);

		if ($match_chance >= 0.45 && $match_chance <= 0.55) {
			while(true) {
				if ($home_team_score < $away_team_score) {
					$home_team_score++;
				}
				elseif ($away_team_score < $home_team_score) {
					$away_team_score++;
				}
				else {
					return $score = array($home_team_score, $away_team_score);
				}
			}
		}
		elseif ($match_chance > 0.55) {
			while(true) {
				if ($home_team_score <= $away_team_score) {
					$home_team_score++;
				}
				else {
					return $score = array($home_team_score, $away_team_score);
				}
			}
		}
		elseif ($match_chance < 0.45) {
			while(true) {
				if ($home_team_score >= $away_team_score) {
					$away_team_score++;
				}
				else {
					return $score = array($home_team_score, $away_team_score);
				}
			}
		}
	}
}
?>

