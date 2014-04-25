@extends('layouts.master')

@section('content')

<table class="table table-condensed">
	<thead>
		<tr>
			<th>Home team</th>
			<th>Away team</th>
			<th>Date</th>
			<th>Home team score</th>
			<th>Away team score</th>
			<th>First goal</th>
			<th>Home team yellow cards</th>
			<th>Home team red cards</th>
			<th>Away team yellow cards</th>
			<th>Away team red cards</th>
		</tr>
	</thead>
	<tbody>	
		@foreach ($futureBets as $bet)
			<tr>
				<td><a href="{{ route('team', array('hometeam'=>urlencode($futureBetsMatches[0]->hometeam_id))) }}">{{$futureBetsMatches[0]->hometeam}}</a></td>
				<td><a href="{{ route('team', array('awayteam'=>urlencode($futureBetsMatches[0]->awayteam_id))) }}">{{$futureBetsMatches[0]->awayteam}}</a></td>
				<td><a href="{{ route('match', array('date'=>urlencode($bet->match_id))) }}">{{$futureBetsMatches[0]->date}}</a></td>
				<td> <?php echo $bet->hometeam_score ?></td>
				<td> <?php echo $bet->awayteam_score ?></td>
				<td> <?php if ($bet->first_goal == 0) echo "/";
							else if ($bet->first_goal == $futureBetsMatches[0]->hometeam_id) echo $futureBetsMatches[0]->hometeam;
							else echo $futureBetsMatches[0]->awayteam; 
					 ?>
				<td>
				<td> <?php if ($bet->hometeam_yellows != -1) echo $bet->hometeam_yellows; else echo "/"; ?></td>
				<td> <?php if ($bet->hometeam_reds != -1)echo $bet->hometeam_reds; else echo "/"; ?></td>
				<td> <?php if ($bet->awayteam_yellows != -1)echo $bet->awayteam_yellows; else echo "/"; ?></td>
				<td> <?php if ($bet->awayteam_reds != -1)echo $bet->awayteam_reds; else echo "/"; ?></td>

			</tr>
		<?php array_shift($futureBetsMatches); //pops first element in array ?> 
		@endforeach		
 	</tbody>
</table>

<table class="table table-condensed">
	<thead>
		<tr>
			<th>Home team</th>
			<th>Away team</th>
			<th>Date</th>
			<th>Home team score</th>
			<th>Away team score</th>
			<th>First goal</th>
			<th>Home team yellow cards</th>
			<th>Home team red cards</th>
			<th>Away team yellow cards</th>
			<th>Away team red cards</th>
		</tr>
	</thead>
	<tbody>	
		@foreach ($pastBets as $bet)
			<tr>
				<td><a href="{{ route('team', array('hometeam'=>urlencode($pastBetsMatches[0]->hometeam_id))) }}">{{$pastBetsMatches[0]->hometeam}}</a></td>
				<td><a href="{{ route('team', array('awayteam'=>urlencode($pastBetsMatches[0]->awayteam_id))) }}">{{$pastBetsMatches[0]->awayteam}}</a></td>
				<td><a href="{{ route('match', array('date'=>urlencode($bet->match_id))) }}">{{$pastBetsMatches[0]->date}}</a></td>
				<td> <?php echo $bet->hometeam_score." (".Match::getScore2($bet->match_id)[0].")";  ?></td>
				<td> <?php echo $bet->awayteam_score." (".Match::getScore2($bet->match_id)[1].")"; ?></td>
				<td> <?php
					  if (Match::getFirstGoalTeam($bet->match_id) != NULL)
						$firstGoalTeamName =  Team::getTeambyID(Match::getFirstGoalTeam($bet->match_id))[0]->name; //translates team_id of actual first goal to name
					  else
						$firstGoalTeamName = "/";  
					  if ($bet->first_goal == 0) echo "/";
						else if ($bet->first_goal == $pastBetsMatches[0]->hometeam_id) echo $pastBetsMatches[0]->hometeam;
						else echo $pastBetsMatches[0]->awayteam; 
					  echo " (".$firstGoalTeamName.")";
					 ?>
				</td>
				<?php $cardCounts = Match::getCardCounts($bet->match_id); ?>
				<td> <?php 
						if ($bet->hometeam_yellows != -1) echo $bet->hometeam_yellows; else echo "/"; 
						echo " (".$cardCounts[0].")";
					 ?>
				</td>
				<td> <?php 
						if ($bet->hometeam_reds != -1)echo $bet->hometeam_reds; else echo "/"; 
						echo " (".$cardCounts[1].")";
					 ?>
				</td>
				<td> <?php 
						if ($bet->awayteam_yellows != -1)echo $bet->awayteam_yellows; else echo "/"; 
						echo " (".$cardCounts[2].")";
					 ?>
				</td>
				<td> <?php 
						if ($bet->awayteam_reds != -1)echo $bet->awayteam_reds; else echo "/"; 
						echo " (".$cardCounts[3].")";
					 ?>
				</td>

			</tr>
		@endforeach		
 	</tbody>
</table>
