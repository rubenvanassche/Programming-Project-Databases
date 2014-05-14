<?php
if(Notification::showAll() != '' or $errors->first('name') != ''){
?>
<div class="alert alert-danger alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <strong>Error!</strong> Please check these things:
  <p>{{ Notification::showAll() }}</p>
  <p>{{ $errors->first('name') }}</p>
</div>
<?php
}
?>


{{ Form::open(array('url' => 'usergroups/new')) }}

<div class="form-group">
	<label>{{ Form::label('name', 'Name') }}</label>
	{{ Form::text('name', Input::old('name'), array('class'=>'form-control')) }}
	<div class="checkbox">
		<label>
			{{ Form::checkbox('private', 'true') }} Private Group
		</label>
	</div>
</div>

{{ Form::submit('Add', array('class'=>'btn btn-success pull-right')) }}

{{ Form::token() . Form::close() }}
