@extends('layouts.master')

@section('content')
<div class="row">
	<div class="col-md-12">
		<ol class="breadcrumb">
			<li><a href="{{ route('home') }}">Home</a></li>
			<li><a href="{{ route('teams') }}">Teams</a></li>
			<li><a href="#">International</a></li>
			<li class="active">{{$teamObj->name}}</li>
		</ol>
	</div>
</div>
<div class="row">
	<div class="col-md-2">
		<img class="img-responsive flag" src={{$teamImageURL}} alt="" />
		<h2>{{$teamObj->name}}</h2>
		<p><b>Ranking Points: </b> {{$teamObj->fifapoints}}</p>
	</div>
	<div class="col-md-10">
		<ul class="nav nav-tabs">
			<li class="active"><a href="{{  route('team.information', array('id'=>$teamObj->id)) }}" data-toggle="tabajax">Information</a></li>
			<li><a href="{{  route('team.players', array('id'=>$teamObj->id)) }}" data-toggle="tabajax">Players</a></li>
			<li><a href="{{  route('team.matches', array('id'=>$teamObj->id)) }}"  data-toggle="tabajax">Matches</a></li>
		</ul>
		<div class="tabcontent" style="margin-top:10px;">
			Please wait
		</div>
    </div>
</div>
@stop


@section('javascript')
	<script>
		// Loads a page in the tabcontent box
		function loadPage(url){
			$.get(url, function(data) {
		        $('.tabcontent').html(data)
		    });
		}
		
		// Loads the active page in the tabcontent box
		var initialUrl = $('.nav.nav-tabs li.active a').attr('href');
		loadPage(initialUrl);
	
		$('[data-toggle="tabajax"]').click(function(e) {
		    e.preventDefault()
		    var url = $(this).attr('href')
		    loadPage(url);
		    $('.nav.nav-tabs li.active').removeClass('active');
		    $(this).parent().addClass('active');
		});
	</script>
@stop
