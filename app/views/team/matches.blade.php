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
				<td>{{ $match->date }}</td>
				<td><a href="{{ $match->match_id}}">{{ $match->hometeam}} - {{ $match->awayteam }} </a></td>
				<td><?php echo Match::getScore($match->match_id); ?></td>
			</tr>
		@endforeach					
	</tbody>
</table>
