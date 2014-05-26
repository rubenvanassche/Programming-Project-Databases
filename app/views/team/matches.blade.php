<script src="<?php echo asset('js/tablesorter.js'); ?>" ></script>
<script src="<?php echo asset('js/tablesorter_filter.js'); ?>" ></script>

<script type="text/javascript">
jQuery(document).ready(function() {
$("#myTable")
.tablesorter({debug: false, dateFormat: "uk", widgets: ['zebra'], sortList: [[0,1]], headers: {2: {sorter: false}}})
.tablesorterFilter({filterContainer: "#filter-box",
                    filterClearContainer: "#filter-clear-button",
                    filterColumns: [0]}); });
</script>

<table id="myTable" class="tablesorter">
	<thead>
		<tr>
			<th>Date</th>
			<th>Match</th>
			<th>Score</th>
			<th>Competition</th>
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
				<td><a href="{{route('match', array('id'=>$match->match_id))}}">{{ $match->hometeam}} - {{ $match->awayteam }} </a></td>
				<td><?php if (Match::isPlayed($match->match_id)) echo Match::getScore($match->match_id); else echo "? - ?" ?></td>
				<td style="text-align: right;"><a href="{{url('competition/'.$match->competition_id)}}">{{$match->competition}}</a></td>
			</tr>
		@endforeach					
	</tbody>
</table>
