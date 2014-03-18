<?php
if(Notification::showAll() != '' or $errors->first('password') != '' or $errors->first('passwordagain') != ''){
?>
<div class="alert alert-danger alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <strong>Error!</strong> Please check these things:
  <p>{{ Notification::showAll() }}</p>
  <p>{{ $errors->first('password') }}</p>
  <p>{{ $errors->first('passwordagain') }}</p>
</div>
<?php
}
?>


{{ Form::open(array('url' => 'user/changepassword')) }}

<div class="form-group">
	<label>{{ Form::label('password', 'New Password') }}</label>
	{{ Form::password('password', array('class'=>'form-control')) }}
</div>


<div class="form-group">
	<label>{{ Form::label('passwordagain', 'New Password Again') }}</label>
	{{ Form::password('passwordagain', array('class'=>'form-control')) }}
</div>

<a href="{{ action('UserController@account') }}" class="btn btn-info pull-left">Back</a>
{{ Form::submit('Change', array('class'=>'btn btn-success pull-right')) }}

{{ Form::token() . Form::close() }}