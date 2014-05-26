@extends('layouts.master')

@section('content')
<div class="row">
	<div class="col-md-12">
		<ol class="breadcrumb">
			<li><a href="{{ route('home') }}">Home</a></li>
			<li><a href="{{ url('competitions') }}">Competitions</a></li>
			<li class="active">{{$competition->name}}</li>
		</ol>
	</div>
</div>
	<div class="row">
		<div class="col-md-12">
			<h1>{{$competition->name}}</h1>
		</div>
		<div class="col-md-6">
			<table id="myTable" class="tablesorter">
				<thead>
					<tr>
						<th></th>
						<th>Team</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($teams as $team)
						<tr>
							<td><i class="flag-{{$team->abbreviation}}"></i></td>
							<td><a href="{{url('team/'.$team->teamid)}}">{{$team->name}}</a></td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		<div class="col-md-6">
			<table id="myTable2" class="tablesorter">
				<thead>
					<tr>
						<th>Date</th>
						<th>Hometeam</th>
						<th></th>
						<th style="text-align:right;">Awayteam</th>
						<th style="text-align:right;">Phase</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($matches as $match)
						<?php
							$matchinfo = Match::get($match->id);
							?>
						<tr>
							<td><a href="{{url('match/'.$match->id)}}"><?php if($matchinfo->date == "0000-00-00 00:00:00") 
										echo "date unknown"; 
						  			  else {
										$date = new DateTime($matchinfo->date);
  									    echo date_format($date, 'd-m-Y H:i');
									  }
							?></a></td>
							<td><a href="{{url('team/'.$match->hometeam_id)}}">{{$matchinfo->hometeam}}</a></td>
							<td>{{$matchinfo->hometeam_score}} - {{$matchinfo->awayteam_score}}</td>
							<td style="text-align:right;"><a href="{{url('team/'.$match->awayteam_id)}}">{{$matchinfo->awayteam}}</a></td>
							<td style="text-align:right;">{{$match->phase . ' ' . $match->group_nr}}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
@stop

@section('javascript')
  <script src="<?php echo asset('js/tablesorter.js'); ?>" ></script>
  <script src="<?php echo asset('js/tablesorter_filter.js'); ?>" ></script>

  <script type="text/javascript">
    jQuery(document).ready(function() {
        $("#myTable2")
        .tablesorter({debug: false, dateFormat: "uk", widgets: ['zebra'], sortList: [[0, 0]]})
        .tablesorterFilter({filterContainer: "#filter-box",
                            filterClearContainer: "#filter-clear-button",
                            filterColumns: [0]}); });
  </script>

    <script type="text/javascript">
    jQuery(document).ready(function() {
        $("#myTable")
        .tablesorter({debug: false, widgets: ['zebra'], sortList: [[1, 0]] , headers: {0: {sorter: false}}})
        .tablesorterFilter({filterContainer: "#filter-box",
                            filterClearContainer: "#filter-clear-button",
                            filterColumns: [0, 1, 2]}); });
  </script>
@stop
