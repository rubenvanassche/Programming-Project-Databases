@extends('layouts.master')

@section('content')
	<div class="row">
		<div class="col-md-9" >
			<!--  Carousel - consult the Twitter Bootstrap docs at
			http://twitter.github.com/bootstrap/javascript.html#carousel -->
			<div id="this-carousel-id" class="carousel slide hero"><!-- class of slide for animation -->
			  <div class="carousel-inner">
				<div class="item active"><!-- class of active since it's the first item -->
				  <img src="{{$photos[0]}}" alt="" />
				  <div class="carousel-caption">
					<p>World Cup 2014 Brazil</p>
				  </div>
				</div>
				<?php 	for ($i = 1; $i < 5; $i++): ?>
						<div class="item">
							<img src="{{$photos[$i]}}" alt="" />
							<div class="carousel-caption">
								<p>Fifa World Cup 2014 RSS feed</p>
							</div>
						</div>
				<?php endfor;?>
			  </div><!-- /.carousel-inner -->
			  <!--  Next and Previous controls below
					href values must reference the id for this carousel -->
				<a class="carousel-control left" href="#this-carousel-id" data-slide="prev">&lsaquo;</a>
				<a class="carousel-control right" href="#this-carousel-id" data-slide="next">&rsaquo;</a>
			</div><!-- /.carousel -->
		</div>
 		<div class="col-md-3" >
 			<button type="button" class="btn btn-primary btn-lg btn-block buttonMarg">Find Team</button>
			<input type="text" class="form-control" placeholder="Team Name">

 			<button type="button" class="btn btn-primary btn-lg btn-block buttonMarg">Find Player</button>
			<input type="text" class="form-control" placeholder="Player Name">

 			<button type="button" class="btn btn-primary btn-lg btn-block buttonMarg">Find Competition</button>
			<input type="text" class="form-control" placeholder="Competition Name">
			
			<button type="button" class="btn btn-primary btn-lg btn-block buttonMarg">Find Match</button>
			<input type="text" class="form-control" placeholder="Hometeam Name - Awayteam Name">

 		</div>
	</div>
	<div class="row">
		<div class="col-md-9 news">
		<h2>Latest News</h2>
		<?php foreach ($articles as $article):?>
			<h3><a href="{{$article->get_permalink();}}">{{$article->get_title();}}</a></h3>
			<p><?php echo $article->get_description(); ?></p>
			<hr>
		<?php endforeach; ?>
		</div>
		<div class="col-md-3">
			<div class="matchListDiv">
	 			<h5 class="matchListTitle">Played Matches</h5>
	 			<table class="table table-condensed">
					<thead>
						<tr>
							<th></th>
							<th>Home</th>
							<th>-</th>
							<th>Away</th>
							<th></th>
						</tr>
					</thead>
					<tbody>	
						<?php 
							$i = -1;
						?>
						@foreach ($recentMatches as $recentMatch)
							<tr>
								<?php $i++;
									$scoreString = $matchGoals[$i] . " - " . $matchGoals[$i + 1];
									$hFlag = "flag-" . $countryFlags[$i][0]->abbreviation;
									$aFlag = "flag-" . $countryFlags[$i+1][0]->abbreviation;
								?>
								<td><i class={{$hFlag}}></i></td>
								<td>{{$recentTeamMatches[$i][0]->name}}</td>
								<td>{{$scoreString}}</td>
								<?php $i++;?>
								<td>{{$recentTeamMatches[$i][0]->name}}</td>
								<td><i class={{$aFlag}}></i></td>
							</tr>
						@endforeach					
					</tbody>
				</table>
				</div>
				<div class="matchListDiv">
	 			<h5 class="matchListTitle">Upcoming Matches</h5>
				<table class="table table-condensed">
				  <thead>
					<tr>
						<th></th>
						<th>Home</th>
						<th>-</th>
						<th>Away</th>
						<th></th>
					</tr>
					</thead>
					<tbody>
						<tr>
							<td><i class="flag-be"></i></td>
							<td>Belgium</td>
							<td>08/06</td>
							<td>Russia</td>
							<td><i class="flag-ru"></i></td>
						</tr>
						<tr>
							<td><i class="flag-be"></i></td>
							<td>Belgium</td>
							<td>08/06</td>
							<td>Russia</td>
							<td><i class="flag-ru"></i></td>
						</tr>
						<tr>
							<td><i class="flag-be"></i></td>
							<td>Belgium</td>
							<td>08/06</td>
							<td>Russia</td>
							<td><i class="flag-ru"></i></td>
						</tr>
						<tr>
							<td><i class="flag-be"></i></td>
							<td>Belgium</td>
							<td>08/06</td>
							<td>Russia</td>
							<td><i class="flag-ru"></i></td>
						</tr>
					</tbody>
				</table>
			</div>
 		</div>
	</div>

@stop

@section('css')
<style>


.matchListDiv thead tr  {
	text-align:center;
}

.matchListDiv tr {
	text-align:center;
	background-color:white;
}

.matchListDiv th{
	text-align:center;
	color:black;
}

.matchListDiv {
	background-color:#007FFF;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px;
	box-shadow:3px 3px 10px 1px #c1c1c1;
}

.matchListTitle {
	text-align:center;
	font-weight:bold;
	color:white;
	vertical-align:bottom;
	padding-top:3%;
}

.buttonMarg {
	margin-top:5%;
	-webkit-border-top-left-radius: 5px;
-webkit-border-top-right-radius: 5px;
-moz-border-radius-topleft: 5px;
-moz-border-radius-topright: 5px;
border-top-left-radius: 5px;
border-top-right-radius: 5px;
}

.marketingArea {
	background-color:#007fff;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px;
	box-shadow:3px 3px 10px 1px #c1c1c1;
}

.hero {
	margin-top:1.5%;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px;
	box-shadow: 3px 3px 10px 1px #c1c1c1;
}

.news {
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px;
}

hr {
	margin: 2px 0;
	border-color: #EEEEEE -moz-use-text-color #FFFFFF;
	border-style: solid none;
	border-width: 2px 0;
}

</style>
@stop

@section('javascript')

@stop
