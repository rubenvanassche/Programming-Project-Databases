@extends('layouts.master')

@section('content')
<div class="row row-padded">
<!-- Row that contains current hierarchy -->
	<div class="col-md-10">
		<p><a href="#">Home</a> >> <a href="#">Teams</a> >> <a href="#">International</a> >> <a href="#">Belgium</a></p>
	</div>
	<div class="col-md-2">
	</div>
</div>
<div class="row row-padded">
  <div class="col-md-2">
  	<ul class="nav nav-list">
		<li class="nav-header">Vincent Kompany</li>
		<li class="active"><a href="#">Current Team</a></li>
		<li class="active"><a href="#">History</a></li>
		<li><a href="#">Matches</a></li>
		<li><a href="#">Stats</a></li>
	</ul>
  </div>
  <div class="col-md-8">
  	<h3>Vincent Kompany</h3>
 	<!--/w/api.php?action=query&prop=extracts&format=json&exsentences=5&exlimit=10&exintro=&exsectionformat=plain&titles=Vincent%20Kompany -->
 	
 	<?php 
		$jsonurl = "http://en.wikipedia.org/w/api.php?action=query&prop=extracts&format=json&exsentences=5&exlimit=10&exintro=&exsectionformat=plain&titles=Vincent%20Kompany";
		$json = file_get_contents($jsonurl);
		var_dump(json_decode($json, true, JSON_UNESCAPED_UNICODE)); 	
		//$wikiObj['query']->['pages']->['1500332']->['extract'];
 	
 	?>
 	
	<div class="row">

	</div>
  </div>
  
	<div class="col-md-2">
	<dl>
 		<dd><img class="img-responsive flag img-circle" src="http://upload.wikimedia.org/wikipedia/commons/8/8d/Vincent_Kompany_-_Belgium.jpg" alt="" /></dd>
  		<dt>Country</dt>
  		<dd>Belgium</dd>
  		<dt>Age</dt>
  		<dd>27</dd>
  		<dt>Goals</dt>
  		<dd>34</dd>
 		<dt>Injured</dt>
  		<dd>No</dd>
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
