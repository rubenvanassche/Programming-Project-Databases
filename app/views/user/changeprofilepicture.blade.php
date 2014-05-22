{{ Form::open(['url' => 'user/changeprofilepicture', 'files' => true, 'method' => 'post']) }}


{{ Form::close() }}

<?php
if(Notification::showAll() != '' or $errors->first('image') != ''){
?>
<div class="alert alert-danger alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <strong>Error!</strong> Please check these things:
  <p>{{ Notification::showAll() }}</p>
  <p>{{ $errors->first('image') }}</p>
</div>
<?php
}
?>


{{ Form::open(['url' => 'user/changeprofilepicture', 'files' => true, 'method' => 'post']) }}

<div class="form-group">
    	<label>{{ Form::label('image', 'Profile Picture') }}</label>
    	File should be jpg, png or gif and size should be under 1mb.
     {{ Form::file('image',  array('class'=>'form-control')) }}
</div>

<a href="{{ action('UserController@account') }}" class="btn btn-info pull-left">Back</a>
{{ Form::submit('Change', array('class'=>'btn btn-success pull-right')) }}

{{ Form::token() . Form::close() }}