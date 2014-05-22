@extends('layouts.master')

@section('content')
	<div class="row">
		<div class="col-md-12">
			<h1>Teams</h1>
			<h3>International</h3>
		</div>
		<div class="col-md-12">
			<table id="myTable" class="tablesorter">
				<thead>
					<tr>
						<th>Country</th>
						<th>Name</th>
						<th>Continent</th>
						<th>Fifa Points</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($teams as $team)
						<?php
							$flag = "flag-" . $team->abbreviation;
						?>
						<tr>
							<td><i class={{$flag}}></td>
							<td><a href="{{ route('team', array('id'=>$team->id)) }}">{{$team->name}}</a></td>
							<td>{{$team->continent}}</td>
							<td>{{$team->fifapoints}}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
@stop

@section('css')
	<style>
		.row.row-padded {
			margin-top: 1%;
		}

		dt {
			background-color:#006DDB;;
		}

		dt, dd {
			text-align:center;
			border-bottom:1px solid black;
		}

		.shadowbox {
			-webkit-border-radius: 5px;
			-moz-border-radius: 5px;
			border-radius: 5px;
			margin-top:1.5%;
		}

		.rounded {
			border-radius: 4px;
		}

		.hackity {
			margin-top:-2%;
		}
	</style>
@stop

@section('javascript')
	<script src="<?php echo asset('js/jquery-1-3-2.js'); ?>" ></script>
	<script src="<?php echo asset('js/tablesorter.js'); ?>" ></script>
	<script src="<?php echo asset('js/tablesorter_filter.js'); ?>" ></script>

	<script type="text/javascript">
		jQuery(document).ready(function() {
        $("#myTable")
        .tablesorter({debug: false, widgets: ['zebra'], sortList: [[2,0], [1, 0]]})
        .tablesorterFilter({filterContainer: "#filter-box",
                            filterClearContainer: "#filter-clear-button",
                            filterColumns: [0]}); });
	</script>

    <script type='text/javascript' src='https://www.google.com/jsapi'></script>
    <script type='text/javascript'>
     google.load('visualization', '1', {'packages': ['geochart']});
     google.setOnLoadCallback(drawRegionsMap);

      function drawRegionsMap() {
        var data = google.visualization.arrayToDataTable([
          ['Country'],
          ['Belgium']

        ]);

        var options = {
        	legend: 'none',
			dataMode: 'regions'
        };

        var chart = new google.visualization.GeoChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    };

		// Won't run correctly if not hosted on server appareantly.
		google.visualization.events.addListener(
		globalGeomap, 'regionClick', function(e) {
		   //doSomething(e['region']);
		   alert("ayo");
		});

		google.visualization.events.addListener(geomap, 'select', function() {
		alert('Select event called, selected row is ' +
			geomap.getSelection()[0].row);
		});
    </script>
@stop
