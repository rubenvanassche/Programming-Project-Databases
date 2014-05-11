@extends('layouts.master')


@section('content')

<div class="row">
	<div class="col-md-12">
		<ol class="breadcrumb">
			<li><a href="{{ route('home') }}">Home</a></li>
			<li><a href="{{ route('teams') }}">People</a></li> <!--// Need to change route -->
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
					<tr>
						<td><?php echo $group->username; ?></td>
					<tr>
				@endforeach
			</tbody>

		</table>

		
		<h3>Invites</h3>
		<table class="table table-condensed">
			<thead>
				<tr>
					<th>Group</th>
					<th>From</th>
					<th></th>
				</tr>
			</thead>
			<tbody>	
				@foreach ($invites as $invite)
					<tr>
						<td><?php echo 'groupName'; ?></td>
						<td><?php echo 'invitedBy'; ?></td>
						<td>yes/no</td>
					<tr>
				@endforeach
			</tbody>
		</table>
		<h3>Notifications</h3>
		<table class="table table-condensed">
			<tbody>	
				@foreach ($notifications as $notification)
					<tr>
						<td>{{$notification['message']}}</td>
					<tr>
				@endforeach
			</tbody>
		</table>
    </div>
</div>
@stop

