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

   <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
		var data = new google.visualization.DataTable();
		data.addColumn('number', 'Year');
		data.addColumn('number', 'Average goals');
		data.addColumn({type: 'string', role: 'tooltip'});
        data.addRows([
		  <?php foreach($yearlyGoals as $year => $goals) {
					$avg = round($goals["totalScore"] / $goals["matchCount"], 2);
					echo " [";
					echo $year;
					echo ", ";
					echo $avg;
					echo ", \"";
					echo "Average of " . $avg . " goals per match in the year " . $year;
					echo "\"],";
				}
		  ?>
				
        ]);

        var options = {
          title: 'Average goal count',
		  hAxis: {format: '0'}
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('goalsPerMatch'));

	  	var formatter = new google.visualization.NumberFormat(
		  {groupingSymbol: ''});
        formatter.format(data, 0); 

        chart.draw(data, options);
      }
    </script>

  </head>
  <body>
    <div id="winloss" style="width: 900px; height: 500px;"></div>
    <div id="goalsPerMatch" style="width: 900px; height: 500px;"></div>
  </body>
</html>
