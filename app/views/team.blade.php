@extends('layouts.master')

@section('content')
<div class="row row-padded">
<!-- Row that contains current hierarchy -->

	<div class="col-md-10">
		<p><a href="#">Home</a> >> <a href="#">Teams</a> >> <a href="#">International</a> >> <a href="#">Belgium</a></p>
	</div>
	<div class="col-md-2">
	</div>
</div>
	<div class="row row-padded">
  <div class="col-md-2">
  	<ul class="nav nav-list">
		<li class="nav-header">Belgium</li>
		<li class="active"><a href="#">Home</a></li>
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
  	<h3>Belgium in the media</h3>
 
		<p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.</p>
		 
		<p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui.</p>
		 
	<div class="row">
		<div id="chart_div">
		</div>
	</div>
  </div>
  
	<div class="col-md-2">
	<dl>
	  		<dd ><img class="img-responsive flag" src="https://encrypted-tbn1.gstatic.com/images?q=tbn:ANd9GcQdn-D9-f13oC1PI3ucgZj4q4HiFjMhgb1aFzOZbBJSzwDNiYiN" alt="" /></dd>
  		<dt>Country</dt>
  		<dd>Belgium</dd>
  		<dt>Win/loss</dt>
  		<dd>0.84</dd>
  		<dt>Ranking</dt>
  		<dd>4th</dd>
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
	</style>
@stop

@section('javascript')
    <script type='text/javascript' src='https://www.google.com/jsapi'></script>
    <script type='text/javascript'>
     google.load('visualization', '1', {'packages': ['geochart']});
     google.setOnLoadCallback(drawRegionsMap);

      function drawRegionsMap() {
        var data = google.visualization.arrayToDataTable([
          ['Country', 'Found it?'],
          ['Belgium', 9001],
          
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
