@extends('layouts.master')

@section('content')
	<div class="row">
		<div class="col-md-9" >
			<!--  Carousel - consult the Twitter Bootstrap docs at
      http://twitter.github.com/bootstrap/javascript.html#carousel -->
			<div id="this-carousel-id" class="carousel slide hero"><!-- class of slide for animation -->
			  <div class="carousel-inner">
				<div class="item active"><!-- class of active since it's the first item -->
				  <img src="http://www.fifa.com/mm/photo/tournament/trophytour/02/29/72/40/2297240_big-lnd.jpg" alt="" />
				  <div class="carousel-caption">
					<p>World Cup 2014 Brazil</p>
				  </div>
				</div>
				<div class="item">
				  <img src="http://www.fifa.com/mm/photo/tournament/trophytour/02/29/68/60/2296860_big-lnd.jpg" alt="" />
				  <div class="carousel-caption">
					<p>Fifa World Cup 2014 RSS feed</p>
				  </div>
				</div>
				<div class="item">
				  <img src="http://www.fifa.com/mm/photo/tournament/trophytour/02/29/68/59/2296859_big-lnd.jpg" alt="" />
				  <div class="carousel-caption">
					<p>Fifa World Cup 2014 RSS feed</p>
				  </div>
				</div>
			  </div><!-- /.carousel-inner -->
			  <!--  Next and Previous controls below
					href values must reference the id for this carousel -->
				<a class="carousel-control left" href="#this-carousel-id" data-slide="prev">&lsaquo;</a>
				<a class="carousel-control right" href="#this-carousel-id" data-slide="next">&rsaquo;</a>
			</div><!-- /.carousel -->
		 	<div style="background-color:grey;">
				<div class="col-md-3">
					<div class="matchListDiv">
						<h5 class="matchListTitle">Group A</h5>
						<table class="table table-condensed">
							<thead>
								<tr>
									<th></th>
									<th>Country</th>
									<th>Score</th>
								</tr>
							</thead>
							<tbody>				
								<tr>
									<td><i class="flag-be"></i></td>
									<td>Belgium</td>
									<td>3</td>
								</tr>
								<tr>
									<td><i class="flag-ru"></i></td>
									<td>Russia</td>
									<td>1</td>
								</tr>
								<tr>
									<td><i class="flag-be"></i></td>
									<td>Belgium</td>
									<td>3</td>
								</tr>
								<tr>
									<td><i class="flag-ru"></i></td>
									<td>Russia</td>
									<td>1</td>
								</tr>
								<tr>
									<td><i class="flag-ru"></i></td>
									<td>Russia</td>
									<td>1</td>
								</tr>
							</tbody>
						</table>
					</div>
						<div class="matchListDiv">
						<h5 class="matchListTitle">Group A</h5>
						<table class="table table-condensed">
							<thead>
								<tr>
									<th></th>
									<th>Country</th>
									<th>Score</th>
								</tr>
							</thead>
							<tbody>				
								<tr>
									<td><i class="flag-be"></i></td>
									<td>Belgium</td>
									<td>3</td>
								</tr>
								<tr>
									<td><i class="flag-ru"></i></td>
									<td>Russia</td>
									<td>1</td>
								</tr>
								<tr>
									<td><i class="flag-be"></i></td>
									<td>Belgium</td>
									<td>3</td>
								</tr>
								<tr>
									<td><i class="flag-ru"></i></td>
									<td>Russia</td>
									<td>1</td>
								</tr>
								<tr>
									<td><i class="flag-ru"></i></td>
									<td>Russia</td>
									<td>1</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="col-md-3">
					<div class="matchListDiv">
						<h5 class="matchListTitle">Group A</h5>
						<table class="table table-condensed">
							<thead>
								<tr>
									<th></th>
									<th>Country</th>
									<th>Score</th>
								</tr>
							</thead>
							<tbody>				
								<tr>
									<td><i class="flag-be"></i></td>
									<td>Belgium</td>
									<td>3</td>
								</tr>
								<tr>
									<td><i class="flag-ru"></i></td>
									<td>Russia</td>
									<td>1</td>
								</tr>
								<tr>
									<td><i class="flag-be"></i></td>
									<td>Belgium</td>
									<td>3</td>
								</tr>
								<tr>
									<td><i class="flag-ru"></i></td>
									<td>Russia</td>
									<td>1</td>
								</tr>
								<tr>
									<td><i class="flag-ru"></i></td>
									<td>Russia</td>
									<td>1</td>
								</tr>
							</tbody>
						</table>
					</div>
						<div class="matchListDiv">
						<h5 class="matchListTitle">Group A</h5>
						<table class="table table-condensed">
							<thead>
								<tr>
									<th></th>
									<th>Country</th>
									<th>Score</th>
								</tr>
							</thead>
							<tbody>				
								<tr>
									<td><i class="flag-be"></i></td>
									<td>Belgium</td>
									<td>3</td>
								</tr>
								<tr>
									<td><i class="flag-ru"></i></td>
									<td>Russia</td>
									<td>1</td>
								</tr>
								<tr>
									<td><i class="flag-be"></i></td>
									<td>Belgium</td>
									<td>3</td>
								</tr>
								<tr>
									<td><i class="flag-ru"></i></td>
									<td>Russia</td>
									<td>1</td>
								</tr>
								<tr>
									<td><i class="flag-ru"></i></td>
									<td>Russia</td>
									<td>1</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				</div>
				<div class="col-md-3">
					<div class="matchListDiv">
						<h5 class="matchListTitle">Group A</h5>
						<table class="table table-condensed">
							<thead>
								<tr>
									<th></th>
									<th>Country</th>
									<th>Score</th>
								</tr>
							</thead>
							<tbody>				
								<tr>
									<td><i class="flag-be"></i></td>
									<td>Belgium</td>
									<td>3</td>
								</tr>
								<tr>
									<td><i class="flag-ru"></i></td>
									<td>Russia</td>
									<td>1</td>
								</tr>
								<tr>
									<td><i class="flag-be"></i></td>
									<td>Belgium</td>
									<td>3</td>
								</tr>
								<tr>
									<td><i class="flag-ru"></i></td>
									<td>Russia</td>
									<td>1</td>
								</tr>
								<tr>
									<td><i class="flag-ru"></i></td>
									<td>Russia</td>
									<td>1</td>
								</tr>
							</tbody>
						</table>
					</div>
						<div class="matchListDiv">
						<h5 class="matchListTitle">Group A</h5>
						<table class="table table-condensed">
							<thead>
								<tr>
									<th></th>
									<th>Country</th>
									<th>Score</th>
								</tr>
							</thead>
							<tbody>				
								<tr>
									<td><i class="flag-be"></i></td>
									<td>Belgium</td>
									<td>3</td>
								</tr>
								<tr>
									<td><i class="flag-ru"></i></td>
									<td>Russia</td>
									<td>1</td>
								</tr>
								<tr>
									<td><i class="flag-be"></i></td>
									<td>Belgium</td>
									<td>3</td>
								</tr>
								<tr>
									<td><i class="flag-ru"></i></td>
									<td>Russia</td>
									<td>1</td>
								</tr>
								<tr>
									<td><i class="flag-ru"></i></td>
									<td>Russia</td>
									<td>1</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="col-md-3">
					<div class="matchListDiv">
						<h5 class="matchListTitle">Group A</h5>
						<table class="table table-condensed">
							<thead>
								<tr>
									<th></th>
									<th>Country</th>
									<th>Score</th>
								</tr>
							</thead>
							<tbody>				
								<tr>
									<td><i class="flag-be"></i></td>
									<td>Belgium</td>
									<td>3</td>
								</tr>
								<tr>
									<td><i class="flag-ru"></i></td>
									<td>Russia</td>
									<td>1</td>
								</tr>
								<tr>
									<td><i class="flag-be"></i></td>
									<td>Belgium</td>
									<td>3</td>
								</tr>
								<tr>
									<td><i class="flag-ru"></i></td>
									<td>Russia</td>
									<td>1</td>
								</tr>
								<tr>
									<td><i class="flag-ru"></i></td>
									<td>Russia</td>
									<td>1</td>
								</tr>
							</tbody>
						</table>
					</div>
						<div class="matchListDiv">
						<h5 class="matchListTitle">Group A</h5>
						<table class="table table-condensed">
							<thead>
								<tr>
									<th></th>
									<th>Country</th>
									<th>Score</th>
								</tr>
							</thead>
							<tbody>				
								<tr>
									<td><i class="flag-be"></i></td>
									<td>Belgium</td>
									<td>3</td>
								</tr>
								<tr>
									<td><i class="flag-ru"></i></td>
									<td>Russia</td>
									<td>1</td>
								</tr>
								<tr>
									<td><i class="flag-be"></i></td>
									<td>Belgium</td>
									<td>3</td>
								</tr>
								<tr>
									<td><i class="flag-ru"></i></td>
									<td>Russia</td>
									<td>1</td>
								</tr>
								<tr>
									<td><i class="flag-ru"></i></td>
									<td>Russia</td>
									<td>1</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
		 	</div>
 		<div class="col-md-3" >
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
</style>
@stop

@section('javascript')

@stop
