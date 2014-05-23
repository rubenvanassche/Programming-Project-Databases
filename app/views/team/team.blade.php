@extends('layouts.master')

@section('content')
@if($teamBackground != '')
		<div id="teambg">
		</div>
@endif



<div class="row">
	<div class="col-md-12">
		<ol class="breadcrumb">
			<li><a href="{{ route('home') }}">Home</a></li>
			<li><a href="{{ route('teams') }}">Teams</a></li>
			<li><a href="#">International</a></li>
			<li class="active">{{$teamObj->name}}</li>
		</ol>
	</div>
</div>
<div class="row">
	<div class="col-md-2">
		<img class="img-responsive flag" src={{$teamImageURL}} alt="" />
		<h2>{{$teamObj->name}}</h2>
		<p><b>Ranking Points: </b> {{$teamObj->fifapoints}}</p>
		<p></p>
	</div>
	<div class="col-md-10">
		<ul class="nav nav-tabs">
			<li class="active"><a href="{{  route('team.information', array('id'=>$teamObj->id)) }}" data-toggle="tabajax">Information</a></li>
			<li><a href="{{  route('team.players', array('id'=>$teamObj->id)) }}" data-toggle="tabajax">Players</a></li>
			<li><a href="{{  route('team.matches', array('id'=>$teamObj->id)) }}"  data-toggle="tabajax">Matches</a></li>
			@if ($hasNews)
			<li><a href="{{  route('team.news', array('id'=>$teamObj->id)) }}"  data-toggle="tabajax">News</a></li>
			@endif
			@if ($teamObj->twitterAccount != '')
				<li><a href="{{  route('team.twitter', array('id'=>$teamObj->id)) }}"  data-toggle="tabajax">Twitter</a></li>
			@endif
			<li><a id=graphs href="{{  route('team.graphs', array('id'=>$teamObj->id)) }}"  data-toggle="tabajax">Graphs</a></li>
		</ul>
		<div class="tabcontent" style="margin-top:10px;">
			Please wait
		</div>
    </div>
</div>

@stop

@section('css')
	@if($teamBackground != '')
	<style>
		#teambg{
			background-image: url("{{$teamBackground}}");
			background-size: cover;
			height: 200px;
			box-sizing: content-box;
			width: 100%;	
		}
	</style>
	@endif
@stop


@section('javascript')
	<script>
		// Loads a page in the tabcontent box
		function loadPage(url){
			$.get(url, function(data) {
		        $('.tabcontent').html(data)
		    });
		}
		
		// Loads the active page in the tabcontent box
		var initialUrl = $('.nav.nav-tabs li.active a').attr('href');
		loadPage(initialUrl);
	
		$('[data-toggle="tabajax"]').click(function(e) {
		    e.preventDefault()
		    var url = $(this).attr('href')
		    loadPage(url);
		    $('.nav.nav-tabs li.active').removeClass('active');
		    $(this).parent().addClass('active');
		});
	</script>

    <script src="http://www.google.com/jsapi?key=ABCDE"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});

	$('#graphs').on('click',function(){               

		$.ajax({
	
		    data: "",
		    success: function(resultData){
		        google.setOnLoadCallback(drawChart1(resultData));                                                   
		    }
		});     
	});





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
	$('#graphs').on('click',function(){               

		$.ajax({
	
		    data: "",
		    success: function(resultData){
		        google.setOnLoadCallback(drawChart2(resultData));                                                   
		    }
		});     
	});


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
