<?php
if(Notification::showAll() != '' or $errors->first('username') != '' or $errors->first('firstname') != '' or $errors->first('lastname') != '' or $errors->first('country') != '' or $errors->first('email') != '' or $errors->first('about') != '' or $errors->first('age') != ''){
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
  <p>{{ $errors->first('about') }}</p>
  <p>{{ $errors->first('age') }}</p>
</div>
<?php
}
?>


{{ Form::open(array('url' => 'user/account')) }}

<div class="form-group">
	<label>{{ Form::label('username', 'Username') }}</label>
	{{ Form::text('username', trim(Input::old('username')) != '' ? Input::old('username') : $user->username, array('class'=>'form-control', 'disabled'=> 'disabled')) }}
</div>

<?php
	$userClass = new User;
?>
@if ($userClass->facebookOnlyUser($user->id) == false)
<div class="form-group">
	<label>Password</label>
	<a href="{{ action('UserController@changepassword') }}" class="btn btn-danger form-control">Change Password</a>
</div>

<div class="form-group">
	<label>Profile Picture</label>
	<a href="{{ action('UserController@changeprofilepicture') }}" class="btn btn-warning form-control">Change Profile Picture</a>
</div>
@endif

<div class="form-group">
  <label>Email opt out / opt in</label>
  <a href="{{ action('UserController@optoutin') }}" class="btn btn-success form-control">Toggle receiving emails</a>
</div>

<div class="form-group">
	<label>{{ Form::label('firstname', 'First Name') }}</label>
	{{ Form::text('firstname', trim(Input::old('firstname')) != '' ? Input::old('firstname') : $user->firstname, array('class'=>'form-control')) }}
</div>

<div class="form-group">
	<label>{{ Form::label('lastname', 'Last Name') }}</label>
	{{ Form::text('lastname', trim(Input::old('lastname')) != '' ? Input::old('lastname') : $user->lastname, array('class'=>'form-control')) }}
</div>

<div class="form-group">
	<label>{{ Form::label('age', 'Age') }}</label>
	{{ Form::text('age', trim(Input::old('age')) != '' ? Input::old('age') : $user->age, array('class'=>'form-control')) }}
</div>

<div class="form-group">
	<label>{{ Form::label('country', 'Country') }}</label>
	{{ Form::select('country',  $countries, trim(Input::old('country')) != '' ? Input::old('country') : $user->country_id, array('class'=>'form-control')) }}
</div>

<div class="form-group">
	<label>{{ Form::label('email', 'Email Adress') }}</label>
	{{ Form::text('email', trim(Input::old('email')) != '' ? Input::old('email') : $user->email, array('class'=>'form-control')) }}
</div>

<div class="form-group">
	<label>{{ Form::label('about', 'About Me') }}</label>
	{{ Form::textarea('about', trim(Input::old('about')) != '' ? Input::old('about') : $user->about, array('class'=>'form-control')) }}
</div>

{{ Form::submit('Change', array('class'=>'btn btn-success pull-right')) }}

{{ Form::token() . Form::close() }}
