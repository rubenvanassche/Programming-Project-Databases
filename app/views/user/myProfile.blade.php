@extends('layouts.master')


@section('content')

<div class="row">
	<div class="col-md-12">
		<ol class="breadcrumb">
			<li><a href="{{ route('home') }}">Home</a></li>
			<li><a href="{{ url('users') }}">People</a></li>
			<li class="active">{{$user->username}}</li>
		</ol>
	</div>
</div>
<div class="row">
	<div class="col-md-2">
		<img class="img-responsive flag" src="{{$profilepicture}}" alt="" /> <!-- Optional -->
		<h2>{{$user->username}}</h2>
		<p><b>Country:</b> {{$user->country}}</p>
		<p><b>Bet score:</b> {{$user->betscore}}</p>
		@if ($user->age != 0 or $user->age != '' or $user->age != NULL)
			<p><b>Age:</b> {{$user->age}}</p>
		@endif
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
					<?php } else { ?>

						<tr class="private notification">
							<td><a href="{{url('usergroup/'.$group->id)}}">{{$group->name}}</a></td>
							<td>0</td>
						</tr>
								<?php
							} ?>
				@endforeach
			</tbody>

		</table>


		<h3>Invites</h3>
		<table class="table table-condensed">
			<thead>
				<tr>
					<th>Group</th>
					<th>From</th>
					<th>Time</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				@foreach ($invites as $invite)
					<tr class="notification">
						<td>{{$invite->name}}</td>
						<td>{{$invite->username}}</td>
						<td>{{$invite->created_date}}</td>
						<td><a href="{{url('myProfile/'.$invite->notif_id.'/'.$invite->ug_id.'/acceptInvite')}}">accept</a>/<a href="{{url('myProfile/'.$invite->notif_id.'/declineInvite')}}">decline</a></td>
					<tr>
				@endforeach
			</tbody>
		</table>
		<h3>Notifications</h3>
		<table class="table table-condensed">
			<tbody>
				@foreach ($notifications as $notification)
					<tr class="notification">
						<td>{{$notification['message']}}</td>
					<tr>
				@endforeach
			</tbody>
		</table>
    </div>
</div>
@stop
