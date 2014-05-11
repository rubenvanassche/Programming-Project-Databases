@extends('layouts.master')

@section('content')
	<div class="row">
		<div class="col-md-12">
			<h1>{{$title}}</h1>
			<?php
			$user = new User;
			if(UserGroup::isMember($user->ID(), $id)) {
			?>	
						{{ Form::open(array('url' => 'usergroup/'.$id.'')) }}
						{{ Form::text('invitee_name', Input::old('invitee_name'), array('class'=>'form-control')) }}
						{{Form::submit('Invite User', array('class'=>'btn btn-success '))}}
						{{ Form::token() . Form::close() }}

			<?php
			}else{
			?>
				<a class="btn btn-success pull-right" style="margin-top:-45px;" href="{{url('usergroup/'.$id.'/addMe')}}">Join Group</a>
			<?php
			}
			?>
		</div>
		<div class="col-md-12">
			<table class="table table-condensed">
				<thead>
					<tr>
						<th>Username</th>
					</tr>
				</thead>
				<tbody>	
					@foreach ($users as $user)
						<tr>
							<td>{{$user->username}}</a></td>
						</tr>
					@endforeach					
				</tbody>
			</table>
		</div>
	</div>
@stop
