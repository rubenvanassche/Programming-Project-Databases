<!DOCTYPE html>
<html lang="en">
  <body>
    <h1>Hi, {{$username}}!</h1>
    <p>Please click the following link to activate your account
      <ul>
        <li><a href= "{{route('user/activate', array('username'=> $username, 'registrationcode' => $registrationcode))}}">Validate email</a></li>
      </ul>
    </p>
  </body>
</html>
