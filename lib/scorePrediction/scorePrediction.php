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
	// Connect to the database.
	$con=mysqli_connect("localhost","CoachCenter","xSN2asvRPVU3Lrsa","coachcenter");

    $sql="SELECT * FROM match WHERE id = '$matchID'";
    $result = mysqli_query($con,$sql);
    $match = mysqli_fetch_array($result);

	// Holds info about hometeam
	$sql = "SELECT * FROM team WHERE id = '$match["hometeam_id"]'";
	$result = mysqli_query($con, $sql);
	$homeTeam = mysqli_fetch_array($result);
	
	// Holds info about awayteam
	$sql = "SELECT * FROM team WHERE id = '$match["awayteam_id"]'";
	$result = mysqli_query($con, $sql);
	$awayTeam = mysqli_fetch_array($result);

	$winner;
	$homeTeamScore = 0;
	$awayTeamScore = 0;

	// Check all variables and add points to the teamscores accordingly.

	// win/loss ratio

	// rank

	// home away
	
	// Compare teamscores and return result.
	if ($homeTeamScore > $awayTeamScore) {
		$winner = $homeTeam;
	}
	else if ($homeTeamScore === $awayTeamScore) {
		$winner = "tie";
	}
	else {
		$winner = $awayTeam;
	}

	// How big is the difference? Calculate score on the difference. -> call other function that calculates this.
	
}
?>

