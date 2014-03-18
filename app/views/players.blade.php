@extends('layouts.master')

@section('content')
<div class="row row-padded">
<!-- Row that contains current hierarchy -->
	<div class="col-md-10">
		<p><a href=<?php chdir(".."); echo getcwd();?>>Home</a> >> <a href="#">Teams</a> >> <a href="#">International</a> >> <a href={{"team?id=" . $team->id}}>{{$team->name}}</a> >> <a href="{{"players?id=" . $team->id}}">Players</a></p>
	</div>
	<div class="col-md-2">
	</div>
</div>
<div class="row row-padded">
  <div class="col-md-2">
  	<ul class="nav nav-list">
		<li class="nav-header">{{$team->name}}</li>
		<li class="active"><a href="#">Players</a></li>
		<li><a href="#">Matches</a></li>
		<li><a href="#">Stats</a></li>
		<li class="nav-header">World Cup</li>
		<li><a href="#">Ranking</a></li>
		<li><a href="#">Played Matches</a></li>
		<li><a href="#">Future Matches</a></li>
		<li><a href="#">Chances of winning</a></li>
	</ul>
  </div>
  <div class="col-md-8">
  	<h3>{{$team->name . " - Players"}}</h3>
		<table class="table table-condensed">
			<thead>
				<tr>
					<th>Name</th>
					<th>Injured</th>
					<th>Goals</th>
				</tr>
			</thead>
			<tbody>	
				@foreach ($playerBase as $player)
					<tr class='clickableRow' href={{ route('player', array('name'=>urlencode($player[0]->name))) }}>
						<td>{{$player[0]->name}}</i></td>
						<td>
							<?php 
								if ($player[0]->injured == 0) {
									echo "No";
								} 
								else{ 
									echo "Yes";
								}; 
							?>
						</td>
						<td>--</td>
					</tr>
				@endforeach					
			</tbody>
		</table>
  </div>
	<div class="col-md-2">
	<dl>
 		<dd><img class="img-responsive flag" src="{{$teamImageURL}}" alt="" /></dd>
  		<dt>Country</dt>
  		<dd>{{$team->name}}</dd>
	</dl>


	</table>

           
	</div>	
</div>
@stop

@section('css')
	<style>
		.row.row-padded {
			margin-top: 1%;
		}
	
		.img-responsive.flag {
			padding-top:5%;
			padding-bottom:5%;

		}
		
		dt {
			background-color:#007fff;;
		}
		
		dt, dd {
			text-align:center;
			border-bottom:1px solid black;
		}
		
		tr.clickableRow {
			cursor: pointer; 
		}
	
		tr.clickableRow:hover {
			background-color:#42ACFF;
		}
	</style>
@stop

@section('javascript')
    <script type="text/javascript">
	jQuery(document).ready(function($) {
      $(".clickableRow").click(function() {
            window.document.location = $(this).attr("href");
      });
	});
	</script>
@stop
