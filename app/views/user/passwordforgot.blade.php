<h2>Forgot Password!</h2>

{{ Notification::showAll() }}

{{ Form::open(array('url' => 'user/passwordforgot')) }}

{{ Form::label('email', 'Email') . Form::text('email', Input::old('email')) }}
{{ $errors->first('email') }}

{{ Form::submit('Send New Password!') }}

{{ Form::token() . Form::close() }}