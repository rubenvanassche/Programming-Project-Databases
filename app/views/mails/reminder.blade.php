<!DOCTYPE html>
<html lang="en">
  <body>
    <h1>Hi, {{$user->username}}!</h1>
    <p>Just a reminder to bet on these upcoming matches:
      <ul>
        @foreach($matches as $match)
          <li><a href="#">{{$match->hometeam}} vs. {{$match->awayteam}}</a></li>
        @endforeach
      </ul>
    </p>
  </body>
</html>
