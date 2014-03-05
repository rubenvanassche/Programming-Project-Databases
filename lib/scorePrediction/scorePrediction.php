<?php
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

	// How big is the difference? Calculate score on the difference.
	
}
?>

