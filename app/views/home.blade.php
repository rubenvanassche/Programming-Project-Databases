@extends('layouts.master')
@section('content')
	<div class="row">
		<div class="col-md-4">
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
							$i = 0;
						?>
						@foreach ($playedMatchInfo as $pmi)
								<tr>
									<?php
										$scoreString = $pmi[3]->hometeam_score . " - " . $pmi[3]->awayteam_score; //count($pmi[0][0]) . " - " . count($pmi[0][1]);
										$hFlag = "flag-" . $pmi[1][0][0]->abbreviation;
										$aFlag = "flag-" . $pmi[1][1][0]->abbreviation;
									?>
									<td><i class={{$hFlag}}></i></td>
									<td>{{$pmi[2][0][0]->name}}</td>
									<td><a href="{{route('match', array('id'=>$pmi[4]))}}">{{$scoreString}}</a></td>
									<td>{{$pmi[2][1][0]->name}}</td>
									<td><i class={{$aFlag}}></i></td>
								</tr>
						@endforeach					
					</tbody>
				</table>
			</div>
		</div>
		<div class="col-md-4">
			<div class="matchListDiv">
	 			<h5 class="matchListTitle">Upcoming matches</h5>
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
						@foreach ($futureMatchInfo as $fmi)
                                                                <tr>
                                                                        <?php
                                                                                $hFlag = "flag-" . $fmi[1][0][0]->abbreviation;
                                                                                $aFlag = "flag-" . $fmi[1][1][0]->abbreviation;
                                                                                $start_date = $fmi[3]->date;
                                                                                $date = substr($start_date, 0, 10);
                                                                                $today = date("Y-m-d H:i:s"); 
                                                                                $today = substr($today, 0, 10);
                                                                                if ($today == $date) {
                                                                                	$date = substr($start_date, 11, 5);
                                                                                }
                                                                                else {
                                                                                	$date = substr($date, 8, 2) . "-" . substr($date, 5, 2) . "-" . substr($date, 0, 4);
                                                                                }
                                                                        ?>
                                                                        <td><i class={{$hFlag}}></i></td>
                                                                        <td>{{$fmi[2][0][0]->name}}</td>
                                                                        <td><a href="{{route('match', array('id'=>$fmi[4]))}}">{{$date}}</a></td>
									<td>{{$fmi[2][1][0]->name}}</td>
                                                                        <td><i class={{$aFlag}}></i></td>
                                                                </tr>
                                                @endforeach
					</tbody>
				</table>
			</div>
		</div>
		<div class="col-md-4">
			<div class="matchListDiv">
	 			<h5 class="matchListTitle">World Cup Ranking</h5>
	 			<table class="table table-condensed">
				  <thead>
					<tr>
						<th></th>
						<th>Country</th>
						<th>Points</th>
					</tr>
					</thead>
					<tbody>
						@foreach ($topteams as $topteam)
							<tr>
								<td><i class="flag-<?php echo $topteam->abbreviation; ?>"></i></td>
								<td><a href="{{route('team', array('id'=>$topteam->id))}}"><?php echo $topteam->name; ?></td>
								<td><?php echo $topteam->fifapoints; ?></td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			<a href=" {{ route('teams') }}">More Teams</a>
		</div>

		<div class="col-md-12">
			<div class="page-header">
				<h1>News</h1>
			</div>
		</div>
		<div class="col-md-12">
			<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
				<div class="carousel-inner">
					<?php 
					$counter = 0;
					foreach ($articles as $article):
						if($counter == 5){
							break;
						}
						$enclosures =  $article->get_enclosures();
						$picture = $enclosures[0]->link;
						$picture = substr($picture, 0, -9);
						$picture = $picture . "big-lnd.jpg";
					?>
						<div class="item <?php if($counter==0){echo 'active';} ?>"><!-- class of active since it's the first item -->
							<img src="<?php echo $picture; ?>" width='100%' />
							<div class="carousel-caption" style="background: rgba(0,0,0,0.5);">
								<h3><?php echo $article->get_title(); ?></h3>
								<p><?php echo $article->get_description(); ?></p>
								<p><a href="<?php echo $article->get_permalink(); ?>">Read More</a></p>
							</div>
						</div>
				 
						<?php 
						$counter++;
						endforeach; 
						?>
				</div>
				<a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
					<span class="glyphicon glyphicon-chevron-left"></span>
				</a>
				<a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
					<span class="glyphicon glyphicon-chevron-right"></span>
				</a>
			</div>
		</div>
		<div class="col-md-12">
			<a class="pull-right" href="{{ route('news') }}">More news</a>
		</div>
		<div class="col-md-12">
			<div class="page-header">
				<h1>World Ranking Map</h1>
			    <div id="chart_div" style="width: 900px; height: 500px;"></div>
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
	background-color:#007F0F;
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
<script type='text/javascript' src='https://www.google.com/jsapi'></script>
<script type='text/javascript'>
     google.load('visualization', '1', {'packages': ['geochart']});

     var chart; 
     var data;
     var options;   

     google.setOnLoadCallback(drawRegionsMap);

      function drawRegionsMap() {
		data = new google.visualization.DataTable();
		data.addColumn('string', 'Country');
		data.addColumn('number', 'FIFA points');
		data.addColumn('number', 'id');
		data.addColumn({type:'string', role:'tooltip'});  // Will make sure only FIFA points and not id is shown in tooltip
        data.addRows(
				//Create the Country/FIFA points table in PHP, as Javascript has no access to these codes
				<?php 
				echo "[";
				foreach($fifaPoints as $points) {
					echo "[\"";
					echo $points["name"];
					echo "\", ";
					echo $points["points"];
					echo ", ";
					echo $points["id"];
					echo ", \"";
					echo "FIFA points: " . $points["points"];
					echo "\"], ";
				}
				echo "]";

				?>);


        options =   {};

        chart = new google.visualization.GeoChart(document.getElementById('chart_div'));
        chart.draw(data, options);
   		google.visualization.events.addListener(chart, 'regionClick', selectHandler);
		google.visualization.events.addListener(chart, 'select', toPage);
    };



	function selectHandler(e) {  //Allows user to zoom in on Great Britain

		  var selection = e['region'];
			if (selection == "GB") {
		      options['resolution'] = 'provinces';
		      options['region'] = selection;
		      chart.draw(data, options);
		      document.getElementById('goback').style.display='block';
			}

		
    };

	function toPage() {  //Allows user click on country to go to its national team
	
	  var rowIndex = chart.getSelection()[0].row;
	  var teamID = data.getValue(rowIndex, 2);
	  window.open('{{route('teamNoIndex')}}/' + teamID, '_self'); //Add teamID in js

		
    };

    </script>
@stop
