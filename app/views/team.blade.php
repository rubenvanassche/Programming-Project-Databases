@extends('layouts.master')

@section('content')
<div class="row row-padded">
<!-- Row that contains current hierarchy -->

	<div class="col-md-10">
		<p><a href="#">Home</a> >> <a href="#">Teams</a> >> <a href="#">International</a> >> <a href="{{"team?id=" . $teamObj->id}}">{{$teamObj->name}}</a></p>
	</div>
	<div class="col-md-2">
	</div>
</div>
	<div class="row row-padded">
		<div class="col-md-2">
			<ul class="nav nav-list">
				<li class="nav-header">{{$teamObj->name}}</li>
				<li class="active"><a href={{"players?id=" . $teamObj->id}}>Players</a></li>
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
			<h3>{{$teamObj->name}}</h3>
			{{$teamText}}
			<div class="row">
				<div id="chart_div">
				</div>
			</div>
		</div>
  
		<div class="col-md-2">
		<dl>
			<dd ><img class="img-responsive flag" src={{$teamImageURL}} alt="" /></dd>
			<dt>Country</dt>
			<dd>{{$teamObj->name}}</dd>
			<dt>Win/loss</dt>
			<dd>--</dd>
			<dt>Ranking</dt>
			<dd>--</dd>
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
			background-color:#006DDB;;
		}
		
		dt, dd {
			text-align:center;
			border-bottom:1px solid black;
		}
		
		dl { 
			-webkit-border-radius: 5px;
			-moz-border-radius: 5px;
			border-radius: 5px;
			box-shadow:3px 3px 10px 1px #c1c1c1;
		}
	</style>
@stop

@section('javascript')
    <script type='text/javascript' src='https://www.google.com/jsapi'></script>
    <script type='text/javascript'>
     google.load('visualization', '1', {'packages': ['geochart']});
     google.setOnLoadCallback(drawRegionsMap);

      function drawRegionsMap() {
        var data = google.visualization.arrayToDataTable([
          ['Country'],
          ['{{$teamObj->name}}']
          
        ]);

        var options = {
        	legend: 'none',
        	height: '5%'
        };

        var chart = new google.visualization.GeoChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    };
    </script>
@stop
