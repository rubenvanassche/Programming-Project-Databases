@extends('layouts.master')


@section('content')
<?php
	function cardColorToImg($color){
		if($color == 'red'){
			return "<img src='". asset('img/redcard.png') ."' style='height:16px;' />";
		}else if($color == 'yellow'){
			return "<img src='". asset('img/yellowcard.png') ."' style='height:16px;' />";
		}
	}
?>


<div class="row">
	<div class="col-md-12">
		<ol class="breadcrumb">
			<li><a href="{{ route('home') }}">Home</a></li>
		    <li><a href="{{ route('team', array('id'=>$playerTeam->id)) }}">{{$playerTeam->name}}</a></p>
			<li class="active">{{$playerObj->name}}</li>
		</ol>
	</div>
</div>
<div class="row">
	<div class="col-md-2">
		<img class="img-responsive flag" src="{{$playerImageURL}}" alt="" />
		<h2>{{$playerObj->name}}</h2>
		<p><b>Team: </b> <a href="{{ route('team', array('id'=>$playerTeam->id)) }}">{{$playerTeam->name}}</a></p>
		<p><b>Goals: </b> <?php echo Player::countGoals($playerObj->id); ?></p>
		<p><b>Cards: </b> <?php echo Player::countYellowCards($playerObj->id); ?><img style="height:16px; margin-bottom:7px;" src="{{asset('img/yellowcard.png')}}"> - <?php echo Player::countRedCards($playerObj->id); ?><img style="height:16px;  margin-bottom:7px;" src="{{asset('img/redcard.png')}}"></p>
	</div>
	<div class="col-md-10">
		<h3>Information</h3>
		<p>{{$playerText}}</p>
		<h3>Goals</h3>
		<table id="myTable" class="tablesorter">
			<thead>
				<tr>
					<th>Date</th>
					<th>Time</th>
					<th>Match</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($goals as $goal)
					<tr>
						<td><?php $date = new DateTime($goal->date);
								  echo date_format($date, 'd-m-Y H:i');
						?></td>
						<td><?php echo $goal->time; ?></td>
						<td><a href="<?php echo route('match', array('id'=>$goal->match_id)); ?>">{{$goal->hometeam}} - {{$goal->awayteam}} </a></td>
					<tr>
				@endforeach
			</tbody>
		</table>
		<h3>Cards</h3>
		<table id="myTable2" class="tablesorter">
			<thead>
				<tr>
					<th>Date</th>
					<th>Time</th>
					<th>Match</th>
					<th>Color</th>
				</tr>
			</thead>
			<tbody>	
				@foreach ($cards as $card)
					<tr>
						<td><?php $date = new DateTime($card->date);
								  echo date_format($date, 'd-m-Y H:i');
						?></td>
						<td><?php echo $card->time; ?></td>
						<td><a href="<?php echo route('match', array('id'=>$card->match_id)); ?>">{{$card->hometeam}} - {{$card->awayteam}} </a></td>
						<td><?php echo cardColorToImg($card->color);?></td>
					<tr>
				@endforeach
			</tbody>
		</table>
		<h3>Matches</h3>
		<table id="myTable3" class="tablesorter">
			<thead>
				<tr>
					<th>Date</th>
					<th>Match</th>
					<th>Score</th>
				</tr>
			</thead>
			<tbody>	
				@foreach ($matches as $match)
					<tr>
						<td><?php if($match->date == "0000-00-00 00:00:00") 
							echo "date unknown"; 
						  else {
							$date = new DateTime($match->date);
  						    echo date_format($date, 'd-m-Y H:i');
						  }
						?></td>
						<td><a href="{{route('match', array('id'=>$match->id))}}">{{ $match->hometeam}} - {{ $match->awayteam }} </a></td>
						<td><?php if (Match::isPlayed($match->id)) echo Match::getScore($match->id); else echo "? - ?" ?></td>
					<tr>
				@endforeach
			</tbody>
		</table>
    <div id="winloss" style="width: 900px; height: 500px;"></div>
	<div style="width: 100%; overflow: hidden;"><div id="chart2_div" style="width: 600px; height: 500px; float: left"></div>
	<div id="colFilter_div"style="margin-left: 620px; width: 200px; height: 200px;"></div></div>
    </div>
</div>
@stop

@section('javascript')
  <script src="<?php echo asset('js/tablesorter.js'); ?>" ></script>
  <script src="<?php echo asset('js/tablesorter_filter.js'); ?>" ></script>

  <script type="text/javascript">
    jQuery(document).ready(function() {
        $("#myTable3")
        .tablesorter({debug: false, dateFormat: "uk", widgets: ['zebra'], sortList: [[0, 1]]})
        .tablesorterFilter({filterContainer: "#filter-box",
                            filterClearContainer: "#filter-clear-button",
                            filterColumns: [0, 1, 2]}); });
  </script>
  <script type="text/javascript">
    jQuery(document).ready(function() {
        $("#myTable2")
        .tablesorter({debug: false, widgets: ['zebra'], sortList: [[0, 1]]})
        .tablesorterFilter({filterContainer: "#filter-box",
                            filterClearContainer: "#filter-clear-button",
                            filterColumns: [0, 1, 2]}); });
  </script>

    <script type="text/javascript">
    jQuery(document).ready(function() {
        $("#myTable")
        .tablesorter({debug: false, widgets: ['zebra'], sortList: [[0, 1]]})
        .tablesorterFilter({filterContainer: "#filter-box",
                            filterClearContainer: "#filter-clear-button",
                            filterColumns: [0, 1, 2]}); });
  </script>

   <script src="http://www.google.com/jsapi?key=ABCDE"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});

      google.setOnLoadCallback(drawChart1);



	function drawChart1() {
        var data = google.visualization.arrayToDataTable([
          ['Outcome', 'Times'],
          ['Wins',     <?php echo $outcomes["wins"] ?>],
          ['Losses',     <?php echo $outcomes["losses"] ?>],
          ['Ties',     <?php echo $outcomes["ties"] ?>]
        ]);

        var options = {
          title: 'Win/loss',
          is3D: true,
        };

        var chart = new google.visualization.PieChart(document.getElementById('winloss'));
        chart.draw(data, options);
      }
    </script>

	<script>

		google.load('visualization', '1', {packages: ['controls']});
        google.setOnLoadCallback(drawChart2);                                                   



	function drawChart2 () {
		var data = new google.visualization.DataTable();
		data.addColumn('string', 'Year');
		data.addColumn('number', 'Average goals');
		data.addColumn('number', 'Average yellow cards');
		data.addColumn('number', 'Average red cards');
		data.addRows([
			  <?php foreach($yearlyGoalsCards as $year => $stats) {
						$avgYellows = round($stats["totalYellows"] / $stats["matchCount"], 2);
						$avgReds = round($stats["totalReds"] / $stats["matchCount"], 2);
						$avgGoals = round($stats["totalScore"] / $stats["matchCount"], 2);
						echo " [\"";
						echo $year;
						echo "\", ";
						echo $avgGoals;
						echo ", ";
						echo $avgYellows;
						echo ", ";
						echo $avgReds;
						echo "], ";

					
					}
			  ?>
		]);

		//Column select found on http://jsfiddle.net/asgallant/WaUu2/
		//Mention license on page?

		var columnsTable = new google.visualization.DataTable();
		columnsTable.addColumn('number', 'colIndex');
		columnsTable.addColumn('string', 'colLabel');
		var initState= {selectedValues: []};
		// put the columns into this data table (skip column 0)
		for (var i = 1; i < data.getNumberOfColumns(); i++) {
		    columnsTable.addRow([i, data.getColumnLabel(i)]);
		    // you can comment out this next line if you want to have a default selection other than the whole list
		    initState.selectedValues.push(data.getColumnLabel(i));
		}
		// you can set individual columns to be the default columns (instead of populating via the loop above) like this:
		// initState.selectedValues.push(data.getColumnLabel(4));
		
		var chart = new google.visualization.ChartWrapper({
		    chartType: 'ColumnChart',
		    containerId: 'chart2_div',
		    dataTable: data,
		    options: {
		        title: 'Foobar',
		        width: 600,
		        height: 400,
				colors: ['#A5F2A6', '#1FDB22', '#126614']
			}
		});
		
		var columnFilter = new google.visualization.ControlWrapper({
		    controlType: 'CategoryFilter',
		    containerId: 'colFilter_div',
		    dataTable: columnsTable,
		    options: {
		        filterColumnLabel: 'colLabel',
		        ui: {
		            label: 'Columns',
		            allowTyping: false,
		            allowMultiple: true,
		            allowNone: false,
		            selectedValuesLayout: 'belowStacked'
		        }
		    },
		    state: initState
		});


		
		function setChartView () {
		    var state = columnFilter.getState();
		    var row;
		    var view = {
		        columns: [0]
		    };
		    for (var i = 0; i < state.selectedValues.length; i++) {
		        row = columnsTable.getFilteredRows([{column: 1, value: state.selectedValues[i]}])[0];
		        view.columns.push(columnsTable.getValue(row, 0));
		    }
		    // sort the indices into their original order
		    view.columns.sort(function (a, b) {
		        return (a - b);
		    });
		    chart.setView(view);
		    chart.draw();
		}
		google.visualization.events.addListener(columnFilter, 'statechange', setChartView);
		
		setChartView();
		columnFilter.draw();

	}
	</script>
@stop

