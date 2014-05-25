<table class="table table-condensed">
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
								  echo date_format($date, 'F jS Y g:ia');
						?></td>
				<td><a href="{{route('match', array('id'=>$match->match_id))}}">{{ $match->hometeam}} - {{ $match->awayteam }} </a></td>
				<td><?php if (Match::isPlayed($match->match_id)) echo Match::getScore($match->match_id); else echo "? - ?" ?></td>
			</tr>
		@endforeach					
	</tbody>
</table>
