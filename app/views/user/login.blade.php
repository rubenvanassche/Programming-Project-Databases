
<?php
if(Notification::showAll() != '' or $errors->first('username') != '' or $errors->first('password') != ''){
?>
<div class="alert alert-danger alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <strong>Error!</strong> Please check these things:
  <p>{{ Notification::showAll() }}</p>
  <p>{{ $errors->first('username') }}</p>
  <p>{{ $errors->first('password') }}</p>
</div>
<?php
}
?>

{{ Form::open(array('url' => 'user/login')) }}

<div class="form-group">
	<label>{{ Form::label('username', 'Username') }}</label>
	{{ Form::text('username', Input::old('username'), array('class'=>'form-control')) }}
</div>

<div class="form-group">
	<label>{{ Form::label('password', 'Password') }}</label>
	{{ Form::password('password', array('class'=>'form-control')) }}
</div>

<a href="{{ action('UserController@passwordforgot') }}" class="btn btn-warning pull-left">I Forgot my password</a>
{{ Form::submit('Login', array('class'=>'btn btn-success pull-right')) }}

{{ Form::token() . Form::close() }}