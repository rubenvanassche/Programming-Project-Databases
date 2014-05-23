@extends('layouts.master')

@section('content')
	<div class="row">
		<div class="col-md-12">
			<h1>Teams</h1>
			<h3>International</h3>
		</div>
		<div class="col-md-12">

			Search: <input name="filter" id="filter-box" value="" maxlength="30" size="30" type="text" placeholder="Name or Continent">
    		<input id="filter-clear-button" type="submit" value="Clear"/>
			<table id="myTable" class="tablesorter">
				<thead>
					<tr>
						<th>Country</th>
						<th>Name</th>
						<th>Continent</th>
						<th>Fifa Points</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($teams as $team)
						<?php
							$flag = "flag-" . $team->abbreviation;
						?>
						<tr>
							<td><i class={{$flag}}></td>
							<td><a href="{{ route('team', array('id'=>$team->id)) }}">{{$team->name}}</a></td>
							<td>{{$team->continent}}</td>
							<td>{{$team->fifapoints}}</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
@stop

@section('css')
	<style>
		.row.row-padded {
			margin-top: 1%;
		}

		dt {
			background-color:#006DDB;;
		}

		dt, dd {
			text-align:center;
			border-bottom:1px solid black;
		}

		.shadowbox {
			-webkit-border-radius: 5px;
			-moz-border-radius: 5px;
			border-radius: 5px;
			margin-top:1.5%;
		}

		.rounded {
			border-radius: 4px;
		}

		.hackity {
			margin-top:-2%;
		}
	</style>
@stop

@section('javascript')

	<script src="<?php echo asset('js/tablesorter.js'); ?>" ></script>
	<script src="<?php echo asset('js/tablesorter_filter.js'); ?>" ></script>

	<script type="text/javascript">
		jQuery(document).ready(function() {
        $("#myTable")
        .tablesorter({debug: false, widgets: ['zebra'], sortList: [[2,0], [1, 0]], headers: {0: {sorter: false}}})
        .tablesorterFilter({filterContainer: "#filter-box",
                            filterClearContainer: "#filter-clear-button",
                            filterColumns: [1, 2]}); });
	</script>


@stop
