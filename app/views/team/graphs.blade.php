<html>
  <head>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
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
		google.setOnLoadCallback(drawChart);

	function drawChart () {
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
				'tooltip' : {
				  trigger: 'none'
				},
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




</head>
<body>
    <div id="winloss" style="width: 900px; height: 500px;"></div>
	<div id="colFilter_div"></div>
	<div id="chart2_div"></div>

</body>
</html>
