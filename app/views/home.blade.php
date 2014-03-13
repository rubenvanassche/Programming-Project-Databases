@extends('layouts.master')

@section('content')
	<div class="row">
		<div class="col-md-9" >
			<!--  Carousel - consult the Twitter Bootstrap docs at
      http://twitter.github.com/bootstrap/javascript.html#carousel -->
			<div id="this-carousel-id" class="carousel slide"><!-- class of slide for animation -->
			  <div class="carousel-inner">
				<div class="item active"><!-- class of active since it's the first item -->
				  <img src="http://www.highdefinitionwallpapers1080p.com/wp-content/uploads/2013/09/fifa-world-cup-2014-brazil.jpg" alt="" />
				  <div class="carousel-caption">
					<p>mead hop back, krausen scotch ale hydrometer. brew pilsner infusion dextrin mash. terminal gravity final gravity racking squares brewhouse brew kettle? acid rest all-malt, beer copper goblet! bunghole dry stout secondary fermentation dry stout adjunct keg hop back. terminal gravity; scotch ale, bock saccharification anaerobic racking ipa.</p>
				  </div>
				</div>
				<div class="item">
				  <img src="http://placehold.it/1200x480" alt="" />
				  <div class="carousel-caption">
					<p>Caption text here</p>
				  </div>
				</div>
				<div class="item">
				  <img src="http://placehold.it/1200x480" alt="" />
				  <div class="carousel-caption">
					<p>Caption text here</p>
				  </div>
				</div>
				<div class="item">
				  <img src="http://placehold.it/1200x480" alt="" />
				  <div class="carousel-caption">
					<p>Caption text here</p>
				  </div>
				</div>
			  </div><!-- /.carousel-inner -->
			  <!--  Next and Previous controls below
					href values must reference the id for this carousel -->
				<a class="carousel-control left" href="#this-carousel-id" data-slide="prev">&lsaquo;</a>
				<a class="carousel-control right" href="#this-carousel-id" data-slide="next">&rsaquo;</a>
			</div><!-- /.carousel -->
		 	<div style="background-color:yellow;">
		 		<p>test2</p>
		 	</div>
		 </div>
 		<div class="col-md-3" >
 			<div class="matchListDiv">
	 			<h5 class="matchListTitle">Recently Played</h5>
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
							<td>1 - 0</td>
							<td>Russia</td>
							<td><i class="flag-ru"></i></td>
						</tr>
						<tr>
							<td><i class="flag-be"></i></td>
							<td>Belgium</td>
							<td>1 - 0</td>
							<td>Russia</td>
							<td><i class="flag-ru"></i></td>
						</tr>
						<tr>
							<td><i class="flag-be"></i></td>
							<td>Belgium</td>
							<td>1 - 0</td>
							<td>Russia</td>
							<td><i class="flag-ru"></i></td>
						</tr>
						<tr>
							<td><i class="flag-be"></i></td>
							<td>Belgium</td>
							<td>1 - 0</td>
							<td>Russia</td>
							<td><i class="flag-ru"></i></td>
						</tr>
					</tbody>
				</table>
				</div>
				<div class="matchListDiv">
	 			<h5 class="matchListTitle">Upcoming</h5>
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
</style>
@stop

@section('javascript')

@stop
