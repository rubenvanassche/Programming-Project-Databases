@extends('layouts.master')

@section('content')
	<div class="row">
		<div class="col-md-12">
			<h1>Users</h1>
		</div>
		<div class="col-md-12">
			<table id="myTable" class="tablesorter">
				<thead>
					<tr>
						<th>Username</th>
					</tr>
				</thead>
				<tbody>	
					@foreach ($users as $user)
						<tr>
							<td><a href="{{url('profile/'.$user->id)}}">{{$user->username}}</a></td>
						</tr>
					@endforeach					
				</tbody>
			</table>
		</div>
	</div>
@stop



@section('javascript')
	<script src="<?php echo asset('js/jquery-1-3-2.js'); ?>" ></script>
	<script src="<?php echo asset('js/tablesorter.js'); ?>" ></script>
	<script src="<?php echo asset('js/tablesorter_filter.js'); ?>" ></script>

	<script type="text/javascript">
		jQuery(document).ready(function() {
        $("#myTable")
        .tablesorter({debug: false, widgets: ['zebra'], sortList: [[2,0], [1, 0]]})
        .tablesorterFilter({filterContainer: "#filter-box",
                            filterClearContainer: "#filter-clear-button",
                            filterColumns: [0]}); });
	</script>
@stop
