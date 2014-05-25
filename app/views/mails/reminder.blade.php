<!DOCTYPE html>
<html lang="en">
  <head>

  </head>
  <body>
    <h1>Hi, {{$user->username}}!</h1>
    <p>Just a reminder that you haven't bet yet on these matches:</p>
    <a href="{{url('optout')}}" style="font-size:10px">Don't want to recieve email reminders anymore?</a>
      <div class="row">
        <div class="col-md-12">
          <h1>Upcoming matches</h1>
        </div>
        <div class="col-md-12">
          <table class="table table-condensed center">
            <thead class="center">
              <tr>
                <th>Date</th>
                <th>Home</th>
                <th>vs.</th>
                <th>Away</th>
                <th>Check match</th>
              </tr>
            </thead>
            <tbody>
                  @foreach($matches as $match)
                      <tr class="mark">
                        <td><?php $date = new DateTime($match->date);
								  echo $date->format('d-m-Y H:i');

							?>
						</td>
                        <td><a href="{{route('team', array('id'=>$match->hometeam_id))}}">{{$match->hometeam}}</a></td>
                        <td> - </td>
                        <td><a href="{{route('team', array('id'=>$match->awayteam_id))}}">{{$match->awayteam}}</a></td>
                        <td><a href="{{route('match', array('id'=>$match->id))}}"}}><button type="button" class="btn btn-default">Go!</button></a></td>
                      </tr>
                  @endforeach
            </tbody>
          </table>
        </div>
      </div>
  </body>
</html>
