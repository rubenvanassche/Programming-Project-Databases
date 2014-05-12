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
		<p>Country: {{$user->country}}</p>
		<p>Bet score: {{$user->betscore}}</p>
	</div>
	<div class="col-md-10">
		<h3>About Me</h3>
		<p>{{$user->about}}</p>

		<h3>My Groups</h3>
		<table class="table table-condensed">
			<tbody>
				@foreach ($groups as $group)
					<?php if ($group->private == false) { ?>
						<tr class="notification">
							<td><a href="{{url('usergroup/'.$group->id)}}">{{$group->name}}</a></td>
							<td>0</td>
						</tr>
					<?php } else {
							if ($group->ismember == false) { ?>
								<tr class="private notification">
									<td>{{$group->name}}</td>
									<td>0</td>
								</tr>
								<?php } else { ?>
									<tr class="private notification">
										<td><a href="{{url('usergroup/'.$group->id)}}">{{$group->name}}</a></td>
										<td>0</td>
									</tr>
								<?php }
							} ?>
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

	tr.private {
		background-color:#EEEEEE;
	}

	tr.private.notification:hover {
		background-color:#DDDDDD;
	}
</style>
@stop
