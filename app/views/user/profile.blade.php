@extends('layouts.master')


@section('content')

<div class="row">
	<div class="col-md-12">
		<ol class="breadcrumb">
			<li><a href="{{ route('home') }}">Home</a></li>
			<li><a href="{{ url('users') }}">Users</a></li>
			<li class="active">{{$user->username}}</li>
		</ol>
	</div>
</div>
<div class="row">
	<div class="col-md-2">
		<img class="img-responsive flag" src="{{$profilepicture}}" alt="" /> <!-- Optional -->
		<h2>{{$user->username}}</h2>
		<p><b>Country:</b> {{Country::getCountry($user->country_id)[0]->name}}</p>
		<p><b>Bet score:</b> {{$user->betscore}}</p>
		@if ($user->age != 0 and $user->age != '' and $user->age != NULL and $user->age != '0')
			<p><b>Age:</b> {{$user->age}}</p>
		@endif
	</div>
	<div class="col-md-10">
		<h3>About Me
			@if($personal == true)
				<a href="{{url('user/account')}}"><i class="glyphicon glyphicon-pencil"></i></a>
			@endif
		</h3>

		@if ($user->about == '')
			<p><i>I still have to write this!</i></p>
		@else
		<p>{{$user->about}}</p>
		@endif

		@if  ($personal == false)
			<h4>My Groups</h4>
			@if(empty($groups))
		      	<p><i>No Groups</i></p>
		    @endif
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
		@else
			<ul id="myTab" class="nav nav-tabs">
		      <li class="active"><a href="#notifications" data-toggle="tab">Notifications</a></li>
		      <li><a href="#groups" data-toggle="tab">My Groups</a></li>
		      <li><a href="#invitations" data-toggle="tab">Invitations</a></li>
		    </ul>

		    <div id="myTabContent" class="tab-content">
		      <div class="tab-pane fade in active" id="notifications">
						@if(empty($notifications))
							<p>No notifications</p>
						@endif
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
		      <div class="tab-pane fade" id="groups">
		      @if(empty($groups))
									<p>No Groups</p>
								@endif
							<table class="table table-condensed">
								<tbody>
									@foreach ($groups as $group)
										<?php if ($group->private == false) { ?>
											<tr class="notification">
												<td><a href="{{url('usergroup/'.$group->id)}}">{{$group->name}}</a></td>
											</tr>
										<?php } else { ?>

											<tr class="private notification">
												<td><a href="{{url('usergroup/'.$group->id)}}">{{$group->name}}</a></td>
											</tr>
													<?php
												} ?>
									@endforeach
								</tbody>
							</table>
		      </div>
		      <div class="tab-pane fade" id="invitations">
		      	@if(empty($invites))
		      		<p>No invites</p>
		      	@else
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
				@endif
		      </div>
		    </div>
		@endif
    </div>
</div>
@stop
