@extends('layouts.master')


@section('content')

<div class="row">
	<div class="col-md-12">
		<ol class="breadcrumb">
			<li><a href="{{ route('home') }}">Home</a></li>
			<li><a href="{{ url('users') }}">People</a></li> <!--// Need to change route -->
			<li class="active">{{$user->username}}</li>
		</ol>
	</div>
</div>
<div class="row">
	<div class="col-md-2">
		<img class="img-responsive flag" src="{{$avatar}}" alt="" /> <!-- Optional -->
		<h2>{{$user->username}}</h2>
	</div>
	<div class="col-md-10">
		<h3>About Me</h3>
		<p>{{$text}}</p>
	
		<h3>My Groups</h3>
		<table class="table table-condensed">
			<tbody>
				@foreach ($groups as $group)
						
						<tr class="notification">
							<td><a href="{{url('usergroup/'.$group->id)}}">{{$group->name}}</a></td>
						</tr>
						
				@endforeach
			</tbody>
		</table>
    </div>
</div>
@stop

@section('css')
<style>
	.notification:hover {
		background-color:#006ddb;
	}
	
	th {
		text-align:left;
	}
</style>
@stop

