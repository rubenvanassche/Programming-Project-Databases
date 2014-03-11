<h2>Login!</h2>

{{ Form::open(array('url' => 'user/login')) }}

{{ Form::label('username', 'Username') . Form::text('username', Input::old('username')) }}
{{ $errors->first('username') }}

{{ Form::label('password', 'Password') . Form::password('password') }}
{{ $errors->first('password') }}

{{ Form::submit('Login!') }}

{{ Form::token() . Form::close() }}