@extends('layouts.master')

@section('content')
<div class="row">
	<div class="col-md-12">
		<ol class="breadcrumb">
			<li><a href="{{ route('home') }}">Home</a></li>
			<li><a href="{{ route('teams') }}">Players</a></li>
			<li class="active">{{$playerObj->name}}</li>
		</ol>
	</div>
</div>
<div class="row">
	<div class="col-md-2">
		<img class="img-responsive flag" src="{{$playerImageURL}}" alt="" />
		<h2>{{$playerObj->name}}</h2>
		<p><b>Team: </b> <a href="{{ route('team', array('id'=>$playerTeam->id)) }}">{{$playerTeam->name}}</a></p>
		<p><b>Injured: </b> <?php if ($playerObj->injured == 0) {echo "No";} else { echo "Yes";}; ?></p>
	</div>
	<div class="col-md-10">
		<h3>Information</h3>
		<p>{{$playerText}}</p>
		<h3>Goals</h3>
		<table class="table table-condensed">
			<thead>
				<tr>
					<th>Date</th>
					<th>Match</th>
					<th>Time</th>
				</tr>
			</thead>
			<tbody>	
				@foreach ($goals as $goal)
					<tr>
						<td><?php echo $goal->id; ?></td>
					<tr>
				@endforeach
			</tbody>
		</tabel>
    </div>
</div>
@stop

