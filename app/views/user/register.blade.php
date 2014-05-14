<?php
if(Notification::showAll() != '' or $errors->first('username') != '' or $errors->first('firstname') != '' or $errors->first('lastname') != '' or $errors->first('country') != '' or $errors->first('email') != '' or $errors->first('password') != '' or $errors->first('passwordagain') != ''){
?>
<div class="alert alert-danger alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <strong>Error!</strong> Please check these things:
  <p>{{ Notification::showAll() }}</p>
  <p>{{ $errors->first('username') }}</p>
  <p>{{ $errors->first('country') }}</p>
  <p>{{ $errors->first('firstname') }}</p>
  <p>{{ $errors->first('lastname') }}</p>
  <p>{{ $errors->first('email') }}</p>
  <p>{{ $errors->first('password') }}</p>
  <p>{{ $errors->first('passwordagain') }}</p>
</div>
<?php
}
?>

{{ Form::open(array('url' => 'user/register')) }}

<div class="form-group">
	<label>{{ Form::label('username', 'Username') }}</label>
	{{ Form::text('username', Input::old('username'), array('class'=>'form-control')) }}
</div>

<div class="form-group">
	<label>{{ Form::label('firstname', 'First Name') }}</label>
	{{ Form::text('firstname', Input::old('firstname'), array('class'=>'form-control')) }}
</div>

<div class="form-group">
	<label>{{ Form::label('lastname', 'Last Name') }}</label>
	{{ Form::text('lastname', Input::old('lastname'), array('class'=>'form-control')) }}
</div>

<div class="form-group">
	<label>{{ Form::label('country', 'Country') }}</label>
	{{ Form::select('country',  $countries, array('class'=>'form-control')) }}
</div>

<div class="form-group">
	<label>{{ Form::label('email', 'Email Adress') }}</label>
	{{ Form::text('email', Input::old('email'), array('class'=>'form-control')) }}
</div>

<div class="form-group">
	<label>{{ Form::label('password', 'Password') }}</label>
	{{ Form::password('password', array('class'=>'form-control')) }}
</div>

<div class="form-group">
	<label>{{ Form::label('passwordagain', 'Password Again') }}</label>
	{{ Form::password('passwordagain', array('class'=>'form-control')) }}
</div>

{{ Form::submit('Register', array('class'=>'btn btn-success pull-right')) }}

{{ Form::token() . Form::close() }}
