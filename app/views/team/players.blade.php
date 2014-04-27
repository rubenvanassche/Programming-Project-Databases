<table class="table table-condensed">
	<thead>
		<tr>
			<th>Name</th>
			<th>Injured</th>
			<th>Goals</th>
		</tr>
	</thead>
	<tbody>	
		@foreach ($playerBase as $player)
			<tr>
				<td><a href="{{ route('player', array('name'=>urlencode($player[0]->id))) }}">{{$player[0]->name}}</a></td>
				<td>
					<?php 
						if ($player[0]->injured == 0) {
							echo "No";
						} 
						else{ 
							echo "Yes";
						}; 
					?>
				</td>
				<td><?php echo Player::countGoals($player[0]->id); ?></td>
			</tr>
		@endforeach					
	</tbody>
</table>
