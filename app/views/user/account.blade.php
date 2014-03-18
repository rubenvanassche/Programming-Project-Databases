<?php
if(Notification::showAll() != '' or $errors->first('username') != '' or $errors->first('firstname') != '' or $errors->first('lastname') != '' or $errors->first('country') != '' or $errors->first('email') != ''){
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
</div>
<?php
}
?>


{{ Form::open(array('url' => 'user/account')) }}

<div class="form-group">
	<label>{{ Form::label('username', 'Username') }}</label>
	{{ Form::text('username', Input::old('username'), array('class'=>'form-control', 'disabled'=> 'disabled')) }}
</div>

<div class="form-group">
	<label>Password</label>
	<a href="{{ action('UserController@changepassword') }}" class="btn btn-danger form-control">Change Password</a>
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
	{{ Form::text('country', Input::old('country'), array('class'=>'form-control')) }}
</div>

<div class="form-group">
	<label>{{ Form::label('email', 'Email Adress') }}</label>
	{{ Form::text('email', Input::old('email'), array('class'=>'form-control')) }}
</div>


{{ Form::submit('Change', array('class'=>'btn btn-success pull-right')) }}

{{ Form::token() . Form::close() }}