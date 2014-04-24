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

<!--If someone can figure out how to do this with the if-else clause to avoid some code duplication, feel free to change.
	Maybe splitting up into two separate forms is better? -->

@if(isset($presetHome))
<div class="form-group">
	<label>{{ Form::label('hometeam', 'Home team') }}</label>
	{{ Form::text('hometeam', $presetHome , array('class'=>'form-control')) }}
</div>

<div class="form-group">
	<label>{{ Form::label('awayteam', 'Away team') }}</label>
	{{ Form::text('awayteam', $presetAway , array('class'=>'form-control')) }}
</div>

<div class="form-group">
	<label>{{ Form::label('date', 'Date') }}</label>
	{{ Form::text('date', $presetDate, array('class'=>'form-control')) }}
</div>
@else
<div class="form-group">
	<label>{{ Form::label('hometeam', 'Home team') }}</label>
	{{ Form::text('hometeam', Input::old('hometeam') , array('class'=>'form-control')) }}
</div>

<div class="form-group">
	<label>{{ Form::label('awayteam', 'Away team') }}</label>
	{{ Form::text('awayteam', Input::old('awayteam'), array('class'=>'form-control')) }}
</div>

<div class="form-group">
	<label>{{ Form::label('date', 'Date') }}</label>
	{{ Form::text('date', Input::old('date'), array('class'=>'form-control')) }}
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
	{{ Form::text('firstGoal', Input::old('firstGoal'), array('class'=>'form-control')) }}
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
