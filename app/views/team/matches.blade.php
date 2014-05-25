<script src="<?php echo asset('js/tablesorter.js'); ?>" ></script>
<script src="<?php echo asset('js/tablesorter_filter.js'); ?>" ></script>

<script type="text/javascript">
jQuery(document).ready(function() {
$("#myTable")
.tablesorter({debug: false, widgets: ['zebra'], sortList: [[0,0]], headers: {2: {sorter: false}}})
.tablesorterFilter({filterContainer: "#filter-box",
                    filterClearContainer: "#filter-clear-button",
                    filterColumns: [0]}); });
</script>

<table id="myTable" class="tablesorter" style="text-align: center;">
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
				<td><?php $date = new DateTime($match->date);
								  echo date_format($date, 'd-m-Y H:i');
						?></td>
				<td><a href="{{route('match', array('id'=>$match->match_id))}}">{{ $match->hometeam}} - {{ $match->awayteam }} </a></td>
				<td><?php if (Match::isPlayed($match->match_id)) echo Match::getScore($match->match_id); else echo "? - ?" ?></td>
			</tr>
		@endforeach					
	</tbody>
</table>
