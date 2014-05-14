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
		<p>Country: {{$user->country}}</p>
		<p>Bet score: {{$user->betscore}}</p>
	</div>
	<div class="col-md-10">
		<h3>About Me</h3>
		<a href="#" class="edit" data-toggle="modal" data-target="#aboutMeModal">edit</a>

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

@section('css')
<style>
	.notification:hover {
		background-color:#00BFFF;
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

	a.edit {
		font-size:12px;
	}
</style>


		<div class="modal fade" id="aboutMeModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
			<div class="modal-dialog">
					<div class="modal-content">
							<div class="modal-header">
							<h4 class="modal-title" id="myModalLabel">Edit profile</h4>
							</div>
							<div class="modal-body">
								{{ Form::open(array('url' => 'user/editProfile')) }}

									<div class="form-group">
										<label>{{ Form::label('aboutme', 'About Me') }}</label>
										{{ Form::text('aboutme', Input::old('aboutme'), array('class'=>'form-control', 'placeholder'=>'Tell me something about yourself!')) }}
									</div>

								{{ Form::submit('edit', array('class'=>'btn btn-success pull-right')) }}
								{{ Form::token() . Form::close() }}
							</div>
				<div><p/>&nbsp;</div>  <!--makes sure bet button is inside modal-->
			</div>
		</div>
	</div>

	<!-- This is the modal used when a bet was accepted -->
	<div class="modal fade" id="acceptModal" tabindex="-1" role="dialog" aria-labelledby="acceptModal" aria-hidden="true">
			<div class="modal-dialog">
					<div class="modal-content">
							<div class="modal-header">
							<h4 class="modal-title" id="myModalLabel">Profile updated!</h4>
							</div>
							<div class="modal-body">
									<h3>Thank you for updating your profile. We appreciate it!</h3>
							</div>
							<div class="modal-footer">
									<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
			</div>
		</div>
	</div>

@stop

@section('javascript')
<!-- Open bet modal if input contains 'autoOpenModal', open accept modal if input contains 'accepted' -->
<script>
$(document).ready(function () {
		if ({{ Input::old('autoOpenModal', 'false') }}) {
				$('#betModal').modal('show');
		}
		if ({{ Input::old('accepted', 'false') }}) {
				$('#acceptModal').modal('show');
		}
});
</script>
@stop
