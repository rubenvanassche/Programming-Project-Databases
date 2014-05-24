<script src="<?php echo asset('js/tablesorter.js'); ?>" ></script>
<script src="<?php echo asset('js/tablesorter_filter.js'); ?>" ></script>

<script type="text/javascript">
jQuery(document).ready(function() {
$("#myTable")
.tablesorter({debug: false, widgets: ['zebra'], sortList: [[0,0]]})
.tablesorterFilter({filterContainer: "#filter-box",
                    filterClearContainer: "#filter-clear-button",
                    filterColumns: [0]}); });
</script>
<table id="myTable" class="table table-condensed">
	<thead>
		<tr>
			<th>Name</th>
			<th>Position</th>
			<th>Goals</th>
		</tr>
	</thead>
	<tbody>	
		@foreach ($playerBase as $player)
			<tr>
				<td><a href="{{ route('player', array('name'=>$player->id)) }}">{{$player->name}}</a></td>
				<td>
					{{$player->position}}
				</td>
				<td><?php echo Player::countGoals($player->id); ?></td>
			</tr>
		@endforeach					
	</tbody>
</table>
