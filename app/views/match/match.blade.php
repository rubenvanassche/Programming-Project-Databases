@extends('layouts.master')

<?php
	function cardColorToImg($color){
		if($color == 1){
			return "<img src='". asset('img/redcard.png') ."' style='height:16px;' />";
		}else if($color == 0){
			return "<img src='". asset('img/yellowcard.png') ."' style='height:16px;' />";
		}
	}
?>
@section('content')

	<div class="row">
		<div class="col-md-1" style="margin-top:20px;">
			<img style="width:100%;" src="<?php echo Team::getTeamImageURL($match->hometeam); ?>" />
		</div>
		<div class="col-md-4">
			<h1>{{ $match->hometeam }}</h1>
		</div>
		<div class="col-md-2">
			<h1>{{ $match->hometeam_score }} - {{ $match->awayteam_score }}</h1>
		</div>
		<div class="col-md-4">
			<h1 class="pull-right">{{ $match->awayteam }}</h1>
		</div>
		<div class="col-md-1" style="margin-top:20px;">
			<img style="width:100%;" src="<?php echo Team::getTeamImageURL($match->awayteam); ?>" />
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<a href="{{route('team', array('id'=>$match->hometeam_id))}}">Go to the team</a>
			<h3>Goals</h3>
			<table class="table table-condensed">
				<thead>
					<tr>
						<th>Time</th>
						<th>Name</th>
					</tr>
				</thead>
				<tbody>	
					@foreach ($goalshometeam as $goalhometeam)
						<tr>
							<td><?php echo $goalhometeam->time; ?></td>
							<td><?php echo $goalhometeam->player; ?></td>
						<tr>
					@endforeach
				</tbody>
			</table>
			<h3>Cards</h3>
			<table class="table table-condensed">
				<thead>
					<tr>
						<th>Time</th>
						<th>Player</th>
						<th>Color</th>
					</tr>
				</thead>
				<tbody>	
					@foreach ($cardshometeam as $cardhometeam)
						<tr>
							<td><?php echo $cardhometeam->time; ?></td>
							<td>{$cardhometeam->player}</td>
							<td><?php echo cardColorToImg($cardhometeam->color); ?></td>
						<tr>
					@endforeach
				</tbody>
			</table>
		</div>
		<div class="col-md-6">
			<a class="pull-right" href="{{route('team', array('id'=>$match->awayteam_id))}}">Go to the team</a>
			<h3>Goals</h3>
			<table class="table table-condensed">
				<thead>
					<tr>
						<th>Time</th>
						<th>Name</th>
					</tr>
				</thead>
				<tbody>	
					@foreach ($goalsawayteam as $goalawayteam)
						<tr>
							<td><?php echo $goalawayteam->time; ?></td>
							<td><?php echo $goalawayteam->player; ?></td>
						<tr>
					@endforeach
				</tbody>
			</table>
			<h3>Cards</h3>
			<table class="table table-condensed">
				<thead>
					<tr>
						<th>Time</th>
						<th>Player</th>
						<th>Color</th>
					</tr>
				</thead>
				<tbody>	
					@foreach ($cardshometeam as $cardhometeam)
						<tr>
							<td><?php echo $cardawayteam->time; ?></td>
							<td>{$cardawayteam->player}</td>
							<td><?php echo cardColorToImg($cardawayteam->color); ?></td>
						<tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
@stop

@section('css')

@stop

@section('javascript')

@stop