@extends('layouts.master')

@section('content')

<ul id="myTab" class="nav nav-tabs">
      <li class="active"><a href="#future" data-toggle="tab">Future Matches</a></li>
      <li class=""><a href="#played" data-toggle="tab">Played Matches</a></li>
    </ul>
<div id="myTabContent" class="tab-content">
      <div class="tab-pane fade active in" id="future">
		<?php $matchIndex = 0; ?>
		@foreach ($futureBets as $bet)
			<div class="panel panel-primary" style="margin-top:10px;">
				<div class="panel-heading">
					<h3 class="panel-title"><b>{{$bet->hometeam_score}}</b> <a href="{{route('match', array('id'=>$bet->match_id))}}">{{$futureBetsMatches[$matchIndex]->hometeam}} - {{$futureBetsMatches[$matchIndex]->awayteam}} </a> <b>{{$bet->awayteam_score}}</b><span class="pull-right">{{$futureBetsMatches[$matchIndex]->date}}</span></h3>
				</div>
				<div class="panel-body">
					<p><a href="{{ route('team', array('hometeam'=>urlencode($futureBetsMatches[$matchIndex]->hometeam_id))) }}">{{$futureBetsMatches[$matchIndex]->hometeam}}</a>: <?php if ($bet->hometeam_reds != -1)echo $bet->hometeam_reds; else echo "/"; ?><img style="height:16px; margin-bottom:7px;" src="{{asset('img/redcard.png')}}"/> <?php if ($bet->hometeam_yellows != -1)echo $bet->hometeam_yellows; else echo "/"; ?><img style="height:16px; margin-bottom:7px;" src="{{asset('img/yellowcard.png')}}"/></p>
					<p><a href="{{ route('team', array('awayteam'=>urlencode($futureBetsMatches[$matchIndex]->awayteam_id))) }}">{{$futureBetsMatches[$matchIndex]->awayteam}}</a>: <?php if ($bet->awayteam_reds != -1)echo $bet->awayteam_reds; else echo "/"; ?><img style="height:16px; margin-bottom:7px;" src="{{asset('img/redcard.png')}}"/> <?php if ($bet->awayteam_yellows != -1)echo $bet->awayteam_yellows; else echo "/"; ?><img style="height:16px; margin-bottom:7px;" src="{{asset('img/yellowcard.png')}}"/></p>
					<p><i class="fa fa-circle"></i> First Goal:  <?php if ($bet->first_goal == 0) echo "/";
									else if ($bet->first_goal == $futureBetsMatches[$matchIndex]->hometeam_id) echo $futureBetsMatches[$matchIndex]->hometeam;
									else echo $futureBetsMatches[$matchIndex]->awayteam; 
					?></p>
				</div>
			</div>
		<?php $matchIndex = $matchIndex + 1; ?>
		@endforeach
      </div>
      <div class="tab-pane fade" id="played">
		<?php $matchIndex = 0; ?>
      	@foreach ($pastBets as $bet)
			<div class="panel panel-primary" style="margin-top:10px;">
				<div class="panel-heading">
					<h3 class="panel-title"><b>{{$bet->hometeam_score}}</b> <a href="{{route('match', array('id'=>$bet->match_id))}}">{{$pastBetsMatches[$matchIndex]->hometeam}} - {{$pastBetsMatches[$matchIndex]->awayteam}} </a><b>{{$bet->awayteam_score}}</b><span class="pull-right">{{$pastBetsMatches[$matchIndex]->date}}</span></h3>
				</div>
				<div class="panel-body">
					<p><a href="{{ route('team', array('hometeam'=>urlencode($pastBetsMatches[$matchIndex]->hometeam_id))) }}">{{$pastBetsMatches[$matchIndex]->hometeam}}</a>: <?php if ($bet->hometeam_reds != -1)echo $bet->hometeam_reds; else echo "/"; ?><img style="height:16px; margin-bottom:7px;" src="{{asset('img/redcard.png')}}"/> <?php if ($bet->hometeam_yellows != -1)echo $bet->hometeam_yellows; else echo "/"; ?><img style="height:16px; margin-bottom:7px;" src="{{asset('img/yellowcard.png')}}"/></p>
					<p><a href="{{ route('team', array('awayteam'=>urlencode($pastBetsMatches[$matchIndex]->awayteam_id))) }}">{{$pastBetsMatches[$matchIndex]->awayteam}}</a>: <?php if ($bet->awayteam_reds != -1)echo $bet->awayteam_reds; else echo "/"; ?><img style="height:16px; margin-bottom:7px;" src="{{asset('img/redcard.png')}}"/> <?php if ($bet->awayteam_yellows != -1)echo $bet->awayteam_yellows; else echo "/"; ?><img style="height:16px; margin-bottom:7px;" src="{{asset('img/yellowcard.png')}}"/></p>
					<p><i class="fa fa-circle"></i> First Goal:  <?php if ($bet->first_goal == 0) echo "/";
									else if ($bet->first_goal == $pastBetsMatches[$matchIndex]->hometeam_id) echo $pastBetsMatches[$matchIndex]->hometeam;
									else echo $pastBetsMatches[$matchIndex]->awayteam; 
					?></p>
				</div>
			</div>
		@endforeach 
      </div>
    </div>

