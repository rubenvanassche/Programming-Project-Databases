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
	@if($future)
	<!--TODO: These divs are a rather convoluted way to get the bet button somewhere to the center. It probably doesn't work on all resolutions. 
	It should probably be changed to something more elegant, if the button even stays there. -->
	<div class="row">
	<div class="col-md-5" style="margin-top:20px;">
	</div>
	<div class="col-md-3" style="text-align:center;">
	<ul class="nav nav-pills">
		<!--<li><a href={{ action('UserController@betmodal', array('presetHome' => $match->hometeam, 'presetAway' => $match->awayteam, 'presetDate' => $match->date)) }} data-toggle="modal" data-target="#dasModel">Bet</a></li> -->
<li><a href="#" class="btn btn-lg btn-success"
   data-toggle="modal"
   data-target="#basicModal">Bet</a></li>
	</ul>
	</div>
	</div>
	@endif



<?php if (Session::has('bet')) {
	//TODO: Indicate that bet was successful (modal?). Also maybe check if 'bet' is set to match_id of current page?
	Session::forget('bet');
	}
?>



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
<!-- <div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">

<h2>Login</h2>

{{ Form::open(array('url' => 'user/bet')) }}


@if(isset($presetHome))
<div class="form-group">
	{{ Form::hidden('hometeam', $presetHome , array('class'=>'form-control')) }}
</div>

<div class="form-group">
	{{ Form::hidden('awayteam', $presetAway , array('class'=>'form-control')) }}
</div>

<div class="form-group">
	{{ Form::hidden('date', $presetDate, array('class'=>'form-control')) }}
</div>
@else
<div class="form-group">
	{{ Form::hidden('hometeam', Input::old('hometeam') , array('class'=>'form-control')) }}
</div>

<div class="form-group">
	{{ Form::hidden('awayteam', Input::old('awayteam'), array('class'=>'form-control')) }}
</div>

<div class="form-group">
	{{ Form::hidden('date', Input::old('date'), array('class'=>'form-control')) }}
</div>

@endif

<div class="form-group">
	<label>{{ Form::label('hometeamScore', 'Home team score') }}</label>
	{{ Form::text('hometeamScore', Input::old('hometeamScore'), array('class'=>'form-control')) }}
</div>

<div class="form-group">
	<label>{{ Form::label('awayteamScore', 'Away team score') }}</label>
	{{ Form::text('awayteamScore', Input::old('awayteamScore'), array('class'=>'form-control')) }}
</div>


<div class="form-group">
	<label>{{ Form::label('firstGoal', 'First goal') }}</label>
	@if(isset($presetHome))
	{{ Form::select('firstGoal',  array('none' => '', 'home' => $presetHome, 'away' => $presetAway)) }}
    @else
	{{ Form::select('firstGoal',  array('none' => '', 'home' => Input::old('hometeam'), 'away' => Input::old('awayteam'))) }}
	@endif
</div>

<div class="form-group">
	<label>{{ Form::label('hometeamYellows', 'Yellow cards for home team') }}</label>
	{{ Form::text('hometeamYellows', Input::old('hometeamYellows'), array('class'=>'form-control')) }}
</div>

<div class="form-group">
	<label>{{ Form::label('hometeamReds', 'Red cards for home team') }}</label>
	{{ Form::text('hometeamReds', Input::old('hometeamReds'), array('class'=>'form-control')) }}
</div>

<div class="form-group">
	<label>{{ Form::label('awayteamYellows', 'Yellow cards for away team') }}</label>
	{{ Form::text('awayteamYellows', Input::old('awayteamYellows'), array('class'=>'form-control')) }}
</div>

<div class="form-group">
	<label>{{ Form::label('awayteamReds', 'Red cards for away team') }}</label>
	{{ Form::text('awayteamReds', Input::old('awayteamReds'), array('class'=>'form-control')) }}
</div>

{{ Form::submit('Bet', array('class'=>'btn btn-success pull-right')) }}

{{ Form::token() . Form::close() }}
</div> -->

<div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Bet</h4>
            </div>
            <div class="modal-body">
{{ Form::open(array('url' => 'user/bet')) }}



<div class="form-group">
	{{ Form::hidden('hometeam', $match->hometeam , array('class'=>'form-control')) }}
</div>

<div class="form-group">
	{{ Form::hidden('awayteam', $match->awayteam, array('class'=>'form-control')) }}
</div>

<div class="form-group">
	{{ Form::hidden('date', $match->date, array('class'=>'form-control')) }}
</div>



<div class="form-group">
	<label>{{ Form::label('hometeamScore', 'Home team score') }}</label>
	{{ Form::text('hometeamScore', Input::old('hometeamScore'), array('class'=>'form-control')) }}
    {{ $errors->first('hometeamScore', '<label class="error">:message</label>') }}  
</div>

<div class="form-group">
	<label>{{ Form::label('awayteamScore', 'Away team score') }}</label>
	{{ Form::text('awayteamScore', Input::old('awayteamScore'), array('class'=>'form-control')) }}
    {{ $errors->first('awayteamScore', '<label class="error">:message</label>') }}  
</div>


<div class="form-group">
	<label>{{ Form::label('firstGoal', 'First goal') }}</label>
	{{ Form::select('firstGoal',  array('none' => '', 'home' => $match->hometeam, 'away' => $match->awayteam)) }}
    {{ $errors->first('firstGoal', '<label class="error">:message</label>') }}  
</div>

<div class="form-group">
	<label>{{ Form::label('hometeamYellows', 'Yellow cards for home team') }}</label>
	{{ Form::text('hometeamYellows', Input::old('hometeamYellows'), array('class'=>'form-control')) }}
    {{ $errors->first('hometeamYellows', '<label class="error">:message</label>') }}  
</div>

<div class="form-group">
	<label>{{ Form::label('hometeamReds', 'Red cards for home team') }}</label>
	{{ Form::text('hometeamReds', Input::old('hometeamReds'), array('class'=>'form-control')) }}
    {{ $errors->first('hometeamReds', '<label class="error">:message</label>') }}  
</div>

<div class="form-group">
	<label>{{ Form::label('awayteamYellows', 'Yellow cards for away team') }}</label>
	{{ Form::text('awayteamYellows', Input::old('awayteamYellows'), array('class'=>'form-control')) }}
    {{ $errors->first('awayteamYellows', '<label class="error">:message</label>') }}  
</div>

<div class="form-group">
	<label>{{ Form::label('awayteamReds', 'Red cards for away team') }}</label>
	{{ Form::text('awayteamReds', Input::old('awayteamReds'), array('class'=>'form-control')) }}
    {{ $errors->first('awayteamReds', '<label class="error">:message</label>') }}  
</div>

{{ Form::submit('Bet', array('class'=>'btn btn-success pull-right')) }}

{{ Form::token() . Form::close() }}
            </div>

			<div><p/>&nbsp;</div>  <!--makes sure bet button is inside modal-->
    </div>
  </div>
</div>

<div class="modal fade" id="acceptModal" tabindex="-1" role="dialog" aria-labelledby="acceptModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Bet registered!</h4>
            </div>
            <div class="modal-body">
                <h3>Thank you for making a bet!</h3>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </div>
  </div>
</div>
@stop

@section('javascript')
<script>
$(document).ready(function () {
    if ({{ Input::old('autoOpenModal', 'false') }}) {
        $('#basicModal').modal('show');
    }
    if ({{ Input::old('accepted', 'false') }}) {
        $('#acceptModal').modal('show');
    }
});
</script>
@stop
