@extends('layouts.master')

@section('content')
	<div class="row">
		<div class="col-md-9" >
			<div class="hero-unit" style="background-color:green;">
				<h1>Marketing stuff!</h1>
			 
				<p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
			 
				<a href="#" class="btn btn-large btn-success">Get Started</a>
		 	</div>
		 	<div style="background-color:yellow;">
		 		<p>test2</p>
		 	</div>
		 </div>
 		<div class="col-md-3" >
 			<div class="matchListDiv">
	 			<h5 class="matchListTitle">Recently Played</h5>
	 			<table class="table table-condensed">
					<thead>
						<tr>
							<th></th>
							<th>Home</th>
							<th>-</th>
							<th>Away</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><i class="flag-be"></i></td>
							<td>Belgium</td>
							<td>1 - 0</td>
							<td>Russia</td>
							<td><i class="flag-ru"></i></td>
						</tr>
						<tr>
							<td><i class="flag-be"></i></td>
							<td>Belgium</td>
							<td>1 - 0</td>
							<td>Russia</td>
							<td><i class="flag-ru"></i></td>
						</tr>
						<tr>
							<td><i class="flag-be"></i></td>
							<td>Belgium</td>
							<td>1 - 0</td>
							<td>Russia</td>
							<td><i class="flag-ru"></i></td>
						</tr>
						<tr>
							<td><i class="flag-be"></i></td>
							<td>Belgium</td>
							<td>1 - 0</td>
							<td>Russia</td>
							<td><i class="flag-ru"></i></td>
						</tr>
					</tbody>
				</table>
				</div>
				<div class="matchListDiv">
	 			<h5 class="matchListTitle">Upcoming</h5>
				<table class="table table-condensed">
				  <thead>
					<tr>
						<th></th>
						<th>Home</th>
						<th>-</th>
						<th>Away</th>
						<th></th>
					</tr>
					</thead>
					<tbody>
						<tr>
							<td><i class="flag-be"></i></td>
							<td>Belgium</td>
							<td>08/06</td>
							<td>Russia</td>
							<td><i class="flag-ru"></i></td>
						</tr>
						<tr>
							<td><i class="flag-be"></i></td>
							<td>Belgium</td>
							<td>08/06</td>
							<td>Russia</td>
							<td><i class="flag-ru"></i></td>
						</tr>
						<tr>
							<td><i class="flag-be"></i></td>
							<td>Belgium</td>
							<td>08/06</td>
							<td>Russia</td>
							<td><i class="flag-ru"></i></td>
						</tr>
						<tr>
							<td><i class="flag-be"></i></td>
							<td>Belgium</td>
							<td>08/06</td>
							<td>Russia</td>
							<td><i class="flag-ru"></i></td>
						</tr>
					</tbody>
				</table>
			</div>
 		</div>
	</div>
@stop

@section('css')
<style>


.matchListDiv thead tr  {
	text-align:center;
}

.matchListDiv tr {
	text-align:center;
	background-color:white;
}

.matchListDiv th{
	text-align:center;
	color:black;
}

.matchListDiv {
	background-color:#007FFF;
	-webkit-border-radius: 5px;
	-moz-border-radius: 5px;
	border-radius: 5px;
	box-shadow:3px 3px 10px 1px #c1c1c1;
}

.matchListTitle {
	text-align:center;
	font-weight:bold;
	color:white;
	vertical-align:bottom;
	padding-top:3%;

}
</style>
@stop

@section('javascript')

@stop
