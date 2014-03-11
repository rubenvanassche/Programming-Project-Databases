<h2>Register!</h2>

{{ Form::open(array('url' => 'user/register')) }}

{{ Form::label('username', 'Username') . Form::text('username', Input::old('username')) }}
{{ $errors->first('username') }}

{{ Form::label('firstname', 'First Name') . Form::text('firstname', Input::old('firstname')) }}
{{ $errors->first('firstname') }}

{{ Form::label('lastname', 'Last Name') . Form::text('lastname', Input::old('lastname')) }}
{{ $errors->first('lastname') }}

{{ Form::label('country', 'Country') . Form::text('country', Input::old('country')) }}
{{ $errors->first('country') }}

{{ Form::label('email', 'Email Adress') . Form::text('email', Input::old('email')) }}
{{ $errors->first('email') }}

{{ Form::label('password', 'Password') . Form::password('password') }}
{{ $errors->first('password') }}

{{ Form::label('passwordagain', 'Password Again') . Form::password('passwordagain') }}
{{ $errors->first('passwordagain') }}

{{ Form::submit('Register!') }}

{{ Form::token() . Form::close() }}