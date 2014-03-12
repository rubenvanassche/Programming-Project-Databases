<?php
if(Notification::showAll() != '' or $errors->first('email') != ''){
?>
<div class="alert alert-danger alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <strong>Error!</strong> Please check these things:
  <p>{{ Notification::showAll() }}</p>
  <p>{{ $errors->first('email') }}</p>
</div>
<?php
}
?>

{{ Form::open(array('url' => 'user/passwordforgot')) }}


<div class="form-group">
	<label>{{ Form::label('email', 'Your Email Adress') }}</label>
	{{ Form::text('email', Input::old('email'), array('class'=>'form-control')) }}
</div>

{{ Form::submit('Recover Password', array('class'=>'btn btn-success pull-right')) }}

{{ Form::token() . Form::close() }}