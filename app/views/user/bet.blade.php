<?php
if(Notification::showAll() != '' or $errors->first('hometeam') != '' or $errors->first('awayteam') != '' or $errors->first('date') != '' or $errors->first('hometeamScore') != '' or $errors->first('awayteamScore') != '' or $errors->first('firstGoal') != '' or $errors->first('hometeamYellows') != '' or $errors->first('hometeamReds') != '' or $errors->first('awayteamYellows') != '' or $errors->first('awayteamReds') != ''){
?>
<div class="alert alert-danger alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <strong>Error!</strong> Please check these things:
  <p>{{ Notification::showAll() }}</p>
  <p>{{ $errors->first('hometeam') }}</p>
  <p>{{ $errors->first('awayteam') }}</p>
  <p>{{ $errors->first('date') }}</p>
  <p>{{ $errors->first('hometeamScore') }}</p>
  <p>{{ $errors->first('awayteamScore') }}</p>
  <p>{{ $errors->first('firstGoal') }}</p>
  <p>{{ $errors->first('hometeamYellows') }}</p>
  <p>{{ $errors->first('hometeamReds') }}</p>
  <p>{{ $errors->first('awayteamYellows') }}</p>
  <p>{{ $errors->first('awayteamReds') }}</p>
</div>
<?php
}
?>

{{ Form::open(array('url' => 'user/bet')) }}

<!-- TODO: These hidden form fields are used to store the match information. This should probably be done another way though.
	       Perhaps through the Session? It was done this way because it was adapted from the form where users could change/fill in those fields s-->

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
