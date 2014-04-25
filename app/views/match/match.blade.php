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
	<!--These divs are a rather convoluted way to get the bet button somewhere to the center. It probably doesn't work on all resolutions. 
	It should probably be changed to something more elegant, if the button even stays there. -->
	<div class="row">
	<div class="col-md-5" style="margin-top:20px;">
	</div>
	<div class="col-md-3" style="text-align:center;">
	<ul class="nav nav-pills">
	  <li class="active"><a href={{ action('UserController@bet', array("presetHome" => $match->hometeam, "presetAway" => $match->awayteam, "presetDate" => $match->date)) }}>   Bet   </a></li>
	</ul>
	</div>
	</div>


	<div class="row">
		<div class="col-md-1" style="margin-top:20px;">
			<img style="width:100%;" src="<?php echo Team::getTeamImageURL($match->hometeam); ?>" />
		</div>
		<div class="col-md-4">
			<h1>{{ $match->hometeam }}</h1>
		</div>
		<div class="col-md-2" style="text-align:center;">
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
		<div class="col-md-5">
			<a href="{{route('team', array('id'=>$match->hometeam_id))}}">Go to the team</a>
		</div>
		<div class="col-md-2" style="text-align:center;">
			<p>{{$match->date}}</p>
		</div>
		<div class="col-md-5">
			<a class="pull-right" href="{{route('team', array('id'=>$match->awayteam_id))}}">Go to the team</a>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
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
							<td><a href="{{route('player', array('name'=>urlencode($goalhometeam->player)))}}">{{$goalhometeam->player}}</a></td>
						<tr>
					@endforeach
				</tbody>
			</table>
		</div>
		<div class="col-md-6">
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
							<td><a href="{{route('player', array('name'=>urlencode($goalawayteam->player)))}}">{{$goalawayteam->player}}</a></td>
						<tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
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
							<td><a href="{{route('player', array('name'=>urlencode($cardhometeam->player)))}}">{{$cardhometeam->player}}</a></td>
							<td><?php echo cardColorToImg($cardhometeam->color); ?></td>
						<tr>
					@endforeach
				</tbody>
			</table>		
		</div>
		<div class="col-md-6">
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
					@foreach ($cardsawayteam as $cardawayteam)
						<?php
							if($cardawayteam->player == ''){
								continue;
							}
						?>
						<tr>
							<td><?php echo $cardawayteam->time; ?></td>
							<td><a href="{{route('player', array('name'=>urlencode($cardawayteam->player)))}}">{{$cardawayteam->player}}</a></td>
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
