@extends('layouts.master')

@section('content')
<div class="row row-padded">
<!-- Row that contains current hierarchy -->
	<div class="col-md-10">
		<p><a href="#">Home</a> >> <a href="#">Teams</a> >> <a href="#">International</a> >> <a href="#">{{$playerTeam->name}}</a> >> <a href="#">{{$playerObj->name}}</a></p>
	</div>
	<div class="col-md-2">
	</div>
</div>
<div class="row row-padded">
  <div class="col-md-2">
  	<ul class="nav nav-list">
		<li class="nav-header">{{$playerObj->name}}</li>
		<li class="active">
		<a href={{"team?id=" . $playerTeam->id}}>Current Team</a></li>
		<li class="active"><a href="#">History</a></li>
		<li><a href="#">Matches</a></li>
		<li><a href="#">Stats</a></li>
	</ul>
  </div>
  <div class="col-md-8">
  	<h3>{{$playerObj->name}}</h3>

	<div class="row">
		{{$playerText}}
	</div>
  </div>
  
	<div class="col-md-2">
	<dl>
 		<dd><img class="img-responsive flag" src="{{$playerImageURL}}" alt="" /></dd>
  		<dt>Country</dt>
  		<dd>{{$playerTeam->name}}</dd>
 		<dt>Injured</dt>
  		<dd>
		<?php 
		if ($playerObj->injured == 0) {echo "No";} else { echo "Yes";}; ?>
		</dd>
		<dt>Current Teams</dt>
		<dd>{{$playerTeam->name}}</dd>
	</dl>


	</table>

           
	</div>	
</div>
@stop

@section('css')
	<style>
		.row.row-padded {
			margin-top: 1%;
		}
	
		.img-responsive.flag {
			padding-top:5%;
			padding-bottom:5%;

		}
		
		dt {
			background-color:#006DDB;;
		}
		
		dt, dd {
			text-align:center;
			border-bottom:1px solid black;
		}
		
	</style>
@stop

@section('javascript')
    
@stop
