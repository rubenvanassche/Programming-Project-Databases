@extends('layouts.master')

@section('content')
	<div class="row" style="margin-top:40px">
		{{ Form::open(array('url' => 'search', 'class'=>'form-inline')) }}
		<div class="col-md-10">
			{{ Form::text('input', Input::old('input'), array('class'=>'form-control', 'style' => 'width:100%;')) }}
		</div>
		<div class="col-md-2">
			{{ Form::submit('Search', array('class'=>'btn btn-info pull-right')) }}
			
			{{ Form::token() . Form::close() }}
		</div>
		<div class="col-md-12 visible-md visible-lg">
			<hr />
		</div>
	</div>
	<div class="row">
		@if (empty($teams) == false)
			<div class="col-md-12">
				<h3>Teams</h3>
			</div>
			@foreach ($teams as $team)
				<div class="col-md-2">
					<a href="{{ route('team', array('id'=>$team->id))}}"><i class='flag-<?php echo $team->abbreviation; ?>'></i> {{ $team->name }}</a>
				</div>
			@endforeach
		@endif

		@if (empty($players) == false)
			<div class="col-md-12">
				<h3>Teams</h3>
			</div>
			@foreach ($players as $player)
				<div class="col-md-2">
					<a href="{{ route('team', array('id'=>$player->id))}}"></i> {{ $player->name }}</a>
				</div>
			@endforeach
		@endif
	</div>
@stop
