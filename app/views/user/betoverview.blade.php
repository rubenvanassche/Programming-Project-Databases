@extends('layouts.master')

@section('content')

<ul id="myTab" class="nav nav-tabs">
      <li class="active"><a href="#future" data-toggle="tab">Future Matches</a></li>
      <li class=""><a href="#played" data-toggle="tab">Played Matches</a></li>
      <li class=""><a href="#stats" data-toggle="tab">Statistics</a></li>
    </ul>
<div id="myTabContent" class="tab-content">
      <div class="tab-pane fade active in" id="future">
		@foreach ($futureBets as $bet)
			<div class="panel panel-primary" style="margin-top:10px;">
				<div class="panel-heading">
					<h3 class="panel-title"><b>{{$bet->hometeam_score}}</b> {{$futureBetsMatches[0]->hometeam}} - {{$futureBetsMatches[0]->awayteam}} <b>{{$bet->awayteam_score}}</b><span class="pull-right">{{$futureBetsMatches[0]->date}}</span></h3>
				</div>
				<div class="panel-body">
					<p><a href="{{ route('team', array('hometeam'=>urlencode($futureBetsMatches[0]->hometeam_id))) }}">{{$futureBetsMatches[0]->hometeam}}</a>: <?php if ($bet->hometeam_reds != -1)echo $bet->hometeam_reds; else echo "0"; ?><img style="height:16px; margin-bottom:7px;" src="{{asset('img/redcard.png')}}"/> <?php if ($bet->hometeam_yellows != -1)echo $bet->hometeam_yellows; else echo "0"; ?><img style="height:16px; margin-bottom:7px;" src="{{asset('img/yellowcard.png')}}"/></p>
					<p><a href="{{ route('team', array('awayteam'=>urlencode($futureBetsMatches[0]->awayteam_id))) }}">{{$futureBetsMatches[0]->awayteam}}</a>: <?php if ($bet->awayteam_reds != -1)echo $bet->awayteam_reds; else echo "0"; ?><img style="height:16px; margin-bottom:7px;" src="{{asset('img/redcard.png')}}"/> <?php if ($bet->awayteam_yellows != -1)echo $bet->awayteam_yellows; else echo "0"; ?><img style="height:16px; margin-bottom:7px;" src="{{asset('img/yellowcard.png')}}"/></p>
					<p><i class="fa fa-circle"></i> First Goal:  <?php if ($bet->first_goal == 0) echo "/";
									else if ($bet->first_goal == $futureBetsMatches[0]->hometeam_id) echo $futureBetsMatches[0]->hometeam;
									else echo $futureBetsMatches[0]->awayteam; 
					?></p>
				</div>
			</div>
		@endforeach
      </div>
      <div class="tab-pane fade" id="played">
      	@foreach ($pastBets as $bet)
			<div class="panel panel-primary" style="margin-top:10px;">
				<div class="panel-heading">
					<h3 class="panel-title"><b>{{$bet->hometeam_score}}</b> {{$pastBetsMatches[0]->hometeam}} - {{$pastBetsMatches[0]->awayteam}} <b>{{$bet->awayteam_score}}</b><span class="pull-right">{{$pastBetsMatches[0]->date}}</span></h3>
				</div>
				<div class="panel-body">
					<p><a href="{{ route('team', array('hometeam'=>urlencode($pastBetsMatches[0]->hometeam_id))) }}">{{$pastBetsMatches[0]->hometeam}}</a>: <?php if ($bet->hometeam_reds != -1)echo $bet->hometeam_reds; else echo "0"; ?><img style="height:16px; margin-bottom:7px;" src="{{asset('img/redcard.png')}}"/> <?php if ($bet->hometeam_yellows != -1)echo $bet->hometeam_yellows; else echo "0"; ?><img style="height:16px; margin-bottom:7px;" src="{{asset('img/yellowcard.png')}}"/></p>
					<p><a href="{{ route('team', array('awayteam'=>urlencode($pastBetsMatches[0]->awayteam_id))) }}">{{$pastBetsMatches[0]->awayteam}}</a>: <?php if ($bet->awayteam_reds != -1)echo $bet->awayteam_reds; else echo "0"; ?><img style="height:16px; margin-bottom:7px;" src="{{asset('img/redcard.png')}}"/> <?php if ($bet->awayteam_yellows != -1)echo $bet->awayteam_yellows; else echo "0"; ?><img style="height:16px; margin-bottom:7px;" src="{{asset('img/yellowcard.png')}}"/></p>
					<p><i class="fa fa-circle"></i> First Goal:  <?php if ($bet->first_goal == 0) echo "/";
									else if ($bet->first_goal == $pastBetsMatches[0]->hometeam_id) echo $pastBetsMatches[0]->hometeam;
									else echo $pastBetsMatches[0]->awayteam; 
					?></p>
				</div>
			</div>
		@endforeach 
      </div>
      <div class="tab-pane fade" id="stats">
        TODO
      </div>
    </div>

