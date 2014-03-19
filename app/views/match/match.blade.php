@extends('layouts.master')

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
		</div>
		<div class="col-md-6">
			<a class="pull-right" href="{{route('team', array('id'=>$match->awayteam_id))}}">Go to the team</a>
		</div>
	</div>
@stop

@section('css')

@stop

@section('javascript')

@stop