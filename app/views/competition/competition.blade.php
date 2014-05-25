@extends('layouts.master')

@section('content')
	<div class="row">
		<div class="col-md-12">
			<h1>{{$competition->name}}</h1>
			<i><a href="{{url('competitions')}}">Back to competitions</a></i>
		</div>
		<div class="col-md-6">
			<table id="myTable" class="tablesorter">
				<thead>
					<tr>
						<th></th>
						<th>Team</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($teams as $team)
						<tr>
							<td><i class="flag-{{$team->abbreviation}}"></i></td>
							<td><a href="{{url('team/'.$team->teamid)}}">{{$team->name}}</a></td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		<div class="col-md-6">
			<table id="myTable" class="tablesorter">
				<thead>
					<tr>
						<th>Date</th>
						<th>Hometeam</th>
						<th></th>
						<th style="text-align:right;">Awayteam</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($matches as $match)
						<?php
							$matchinfo = Match::get($match->id);
							?>
						<tr>
							<td><a href="{{url('match/'.$match->id)}}"><?php if($matchinfo->date == "0000-00-00 00:00:00") 
										echo "date unknown"; 
						  			  else {
										$date = new DateTime($matchinfo->date);
  									    echo date_format($date, 'd-m-Y H:i');
									  }
							?></a></td>
							<td><a href="{{url('team/'.$match->hometeam_id)}}">{{$matchinfo->hometeam}}</a></td>
							<td>{{$matchinfo->hometeam_score}} - {{$matchinfo->awayteam_score}}</td>
							<td style="text-align:right;"><a href="{{url('team/'.$match->awayteam_id)}}">{{$matchinfo->awayteam}}</a></td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
@stop
