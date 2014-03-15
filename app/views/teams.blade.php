@extends('layouts.master')

@section('content')
<div class="row row-padded">
<!-- Row that contains current hierarchy -->

	<div class="col-md-10">
		<p><a href="home">Home</a> >> <a href="#">Teams</a></p>
	</div>
	<div class="col-md-2">
	</div>
</div>
	<div class="row row-padded">
		<div class="col-md-2">
			<ul class="nav nav-list">
				<li class="nav-header">Countries</li>
				<li class="active">
				<select class="form-control rounded">
				  <option>Belgium</option>
				  <option>Russia</option>
				  <option>Italy</option>
				  <option>Germany</option>
				  <option>France</option>
				</select>
				</li>
			</ul>
		</div>
			<div class="col-md-10 shadowbox">				
				<div class="col-md-1">
					<img class="img-responsive flag" src="http://upload.wikimedia.org/wikipedia/commons/thumb/6/65/Flag_of_Belgium.svg/125px-Flag_of_Belgium.svg.png" alt="" />
				</div>
				<div class="col-md-2" style="text-align:center;">
					<h4>Belgium</h4>

				</div>
						<div class="col-md-9">
							<select class="form-control rounded">
							  <option>National Team</option>
							  <option>Russia</option>
							  <option>Italy</option>
							  <option>Germany</option>
							  <option>France</option>
							</select>
						</div>	
			</div>
  

</div>
	<div class="row row-padded">
		<div class="col-md-12" style="height:50%;">
			<div id="chart_div" style="size:50%;">
			</div>
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
			box-shadow:3px 3px 10px 1px #c1c1c1;
			margin-top:1.5%;
		}
		
		.rounded {
			border-radius: 4px;
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
          ['']
          
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
