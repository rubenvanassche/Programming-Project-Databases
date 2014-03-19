<?php

function predictOutcome($matchID) {
	
	$hometeam_points = 0;
	$awayteam_points = 0;
	
	// Connect to the database.
	$con=mysqli_connect("localhost","CoachCenter","xSN2asvRPVU3Lrsa","coachcenter");

    $matches = DB::select('SELECT hometeam_id, awayteam_id FROM match WHERE id = ?', array($matchID));
	
	// Get the team id's.
	$hometeam_id = $matches[0]->hometeam_id;
	$awayteam_id = $matches[0]->awayteam_id;
	
	//$hometeams = DB::select('SELECT * FROM team WHERE id = ?', array($hometeam_id));
	//$awayteams = DB::select('SELECT * FROM team WHERE id = ?', array($awayteam_id));
	
	// Get all matches with same setup.
	$same_lineup_matches = DB::select('SELECT score_home, score_away FROM match WHERE hometeam_id = ? AND awayteam_id = ?', array($hometeam_id, $awayteam_id);
	
	foreach ($same_lineup_matches as $match) {
		if ($match->score_home > $match->score_away) {
			$hometeam_points += 1;
		}
		elseif ($match->score_home < $match->score_away) {
			$awayteam_points += 1;
		}
 	}
	
	// Get all matches with reverse setup.
	$reverse_lineup_matches = DB::select('SELECT score_home, score_away FROM match WHERE hometeam_id = ? AND awayteam_id = ?', array($awayteam_id, $hometeam_id);
	
	foreach ($reverse_lineup_matches as $match) {
		if ($match->score_home > $match->score_away) {
			$hometeam_points += 0.75;
		}
		elseif ($match->score_home < $match->score_away) {
			$awayteam_points += 0.75;
		}
	}
	
	// Calculate average win/loss hometeam @ home
	$matches_played = 0;
	$matches_won = 0;
	$matches_hometeam_at_home = DB::select('SELECT score_home, score_away FROM match WHERE hometeam_id = ?', array($hometeam_id));
	
	foreach ($matches_hometeam_at_home as $match) {
		$matches_played++;
		if ($match->score_home > $match->score_away) {
			$matches_won++;
		}
	}
	
	// add average to the score.
	$hometeam_points += $matches_won / $matches_played;
	
	// Calculate average win/loss hometeam @ away
	$matches_played = 0;
	$matches_won = 0;
	$matches_hometeam_at_away = DB::select('SELECT score_home, score_away FROM match WHERE awayteam_id = ?', array($hometeam_id));
	
	foreach ($matches_hometeam_at_away as $match) {
		$matches_played++;
		if ($match->score_home < $match->score_away) {
			$matches_won++;
		}
	}
	
	// add average multiplied by factor to the score.
	$hometeam_points += ($matches_won / $matches_played) * 0.75;
	
	// Calculate average win/loss awayteam @ away
	$matches_played = 0;
	$matches_won = 0;
	$matches_awayteam_at_away = DB::select('SELECT score_home, score_away FROM match WHERE awayteam_id = ?', array($awayteam_id));
	
	foreach ($matches_awayteam_at_away as $match) {
		$matches_played++;
		if ($match->score_home < $match->score_away) {
			$matches_won++;
		}
	}
	
	// add average to the score.
	$awayteam_points += $matches_won / $matches_played;
	
	// Calculate average win/loss awayteam @ home
	$matches_played = 0;
	$matches_won = 0;
	$matches_awayteam_at_home = DB::select('SELECT score_home, score_away FROM match WHERE hometeam_id = ?', array($awayteam_id));
	
	foreach ($matches_awayteam_at_home as $match) {
		$matches_played++;
		if ($match->score_home > $match->score_away) {
			$matches_won++;
		}
	}
	
	// add average multiplied by factor to the score.
	$awayteam_points += ($matches_won / $matches_played) * 0.75;
	
	// Make up the chances
	
	$totalpoints = $hometeam_points + $awayteam_points;
	
	$chance_hometeam_wins = $hometeam_points / $totalpoints;
	
	return $chance_hometeam_wins;
	
}

function predictScore($matchID)
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

	// Connect to the database.
	$con=mysqli_connect("localhost","CoachCenter","xSN2asvRPVU3Lrsa","coachcenter");

    $matches = DB::select('SELECT hometeam_id, awayteam_id FROM match WHERE id = ?', array($matchID));
	
	// Get the team id's.
	$hometeam_id = $matches[0]->hometeam_id;
	$awayteam_id = $matches[0]->awayteam_id;
	
	//$hometeams = DB::select('SELECT * FROM team WHERE id = ?', array($hometeam_id));
	//$awayteams = DB::select('SELECT * FROM team WHERE id = ?', array($awayteam_id));
	
	// Get all matches with same setup.
	$same_lineup_matches = DB::select('SELECT score_home, score_away FROM match WHERE hometeam_id = ? AND awayteam_id = ?', array($hometeam_id, $awayteam_id);

	$goals_scored_home = 0;
	$goals_scored_away = 0;
	$matches_played = 0;
	
	foreach ($same_lineup_matches as $match) {
		$matches_played++;
		$goals_scored_home += $match->score_home;
		$goals_scored_away += $match->score_away;
 	}

 	$avg_same_setup_home_score = $goals_scored_home / $matches_played;
 	$avg_same_setup_away_score = $goals_scored_away / $matches_played;
	
	// Get all matches with reverse setup.
	$reverse_lineup_matches = DB::select('SELECT score_home, score_away FROM match WHERE hometeam_id = ? AND awayteam_id = ?', array($awayteam_id, $hometeam_id);

	$goals_scored_home = 0;
	$goals_scored_away = 0;
	$matches_played = 0;
	
	foreach ($reverse_lineup_matches as $match) {
		$matches_played++;
		$goals_scored_home += $match->score_away;
		$goals_scored_away += $match->score_home;
	}

	$avg_reversed_setup_home_score = $goals_scored_home / $matches_played;
	$avg_reversed_setup_away_score = $goals_scored_away / $matches_played;
	
	// Calculate average win/loss hometeam @ home
	$matches_hometeam_at_home = DB::select('SELECT score_home, score_away FROM match WHERE hometeam_id = ?', array($hometeam_id));

	$goals_scored_home = 0;
	$matches_played = 0;
	
	foreach ($matches_hometeam_at_home as $match) {
		$matches_played++;
		$goals_scored_home += $match->score_home;
	}
	
	// add average to the score.
	$avg_home_at_home_score = $goals_scored_home / $matches_played;
	
	// Calculate average win/loss hometeam @ away
	$matches_hometeam_at_away = DB::select('SELECT score_home, score_away FROM match WHERE awayteam_id = ?', array($hometeam_id));
	
	$goals_scored_home = 0;
	$matches_played = 0;
	
	foreach ($matches_hometeam_at_home as $match) {
		$matches_played++;
		$goals_scored_home += $match->score_away;
	}
	
	// add average to the score.
	$avg_home_at_away_score = $goals_scored_home / $matches_played;
	
	// Calculate average win/loss awayteam @ away
	$matches_awayteam_at_away = DB::select('SELECT score_home, score_away FROM match WHERE awayteam_id = ?', array($awayteam_id));

	$goals_scored_away = 0;
	$matches_played = 0;
	
	foreach ($matches_awayteam_at_away as $match) {
		$matches_played++;
		$goals_scored_away += $match->score_away;
	}
	
	// add average to the score.
	$avg_away_at_away_score += $goals_scored_away / $matches_played;
	
	// Calculate average win/loss awayteam @ home
	$matches_awayteam_at_home = DB::select('SELECT score_home, score_away FROM match WHERE hometeam_id = ?', array($awayteam_id));
	
	$goals_scored_away = 0;
	$matches_played = 0;
	
	foreach ($matches_awayteam_at_away as $match) {
		$matches_played++;
		$goals_scored_away += $match->score_home;
	}
	
	// add average to the score.
	$avg_away_at_home_score += $goals_scored_away / $matches_played;
	
	$home_team_score = floor(($avg_same_setup_home_score + ($avg_reversed_setup_home_score * 0.9) + ($avg_home_at_home_score * 0.7) + ($avg_home_at_away_score * 0.5)) / 4);
	$away_team_score = floor(($avg_same_setup_away_score + ($avg_reversed_setup_away_score * 0.9) + ($avg_away_at_home_score * 0.7) + ($avg_away_at_away_score * 0.5)) / 4);

	$match_chance = predictOutcome($matchID);

	if ($match_chance == 0.5) {
		while(true) {
			if ($home_team_score < $away_team_score) {
				$home_team_score++;
			}
			elseif ($away_team_score < $away_team_score) {
				$away_team_score++;
			}
			else {
				return $score = array($home_team_score, $away_team_score);
			}
		}
	}
	elseif ($match_chance > 0.5) {
		while(true) {
			if ($home_team_score <= $away_team_score) {
				$home_team_score++;
			else {
				return $score = array($home_team_score, $away_team_score);
			}
		}
	}
	elseif ($match_chance < 0.5) {
		while(true) {
			if ($home_team_score >= $away_team_score) {
				$away_team_score++;
			else {
				return $score = array($home_team_score, $away_team_score);
			}
		}
	}
}
?>

