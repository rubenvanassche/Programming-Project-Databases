<?php
if(Notification::showAll() != '' or $errors->first('title') != '' or $errors->first('content') != ''){
?>
<div class="alert alert-danger alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <strong>Error!</strong> Please check these things:
  <p>{{ Notification::showAll() }}</p>
  <p>{{ $errors->first('title') }}</p>
  <p>{{ $errors->first('content') }}</p>
</div>
<?php
}
?>


{{ Form::open(array('url' => 'usergroup/'.$usergroup_id.'/discussion/'.$discussion_id.'/add')) }}

<div class="form-group">
	<label>{{ Form::label('content', 'Content') }}</label>
	{{ Form::textarea('content', Input::old('content'), array('class'=>'form-control')) }}
</div>

{{ Form::submit('Add', array('class'=>'btn btn-success pull-right')) }}

{{ Form::token() . Form::close() }}