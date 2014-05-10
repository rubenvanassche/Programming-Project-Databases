@extends('layouts.master')

@section('content')
	<div class="row">
		<div class="col-md-12">
			<h1>{{$title}}</h1>
			<?php
			$user = new User;
			$invitee_id = User::getID("Kion");
			if(UserGroup::isMember($user->ID(), $id)) {
			?>	
						<!--{{ Form::open(array('url' => 'search', 'class'=>'navbar-form navbar-right')) }}
						<div class="form-group">
							{{ Form::text('input', '', array('class'=>'form-control', 'id'=>'searchbar', 'style' => 'width:100%;', 'placeholder'=>'Type searchterm here')) }}
						</div>
						<button type="submit" id="searchbutton" class="btn btn-primary"><i class="glyphicon glyphicon-search"> </i></button>-->
						<a class="btn btn-success pull-right" type="submit" style="margin-top:-45px;" href="{{url('usergroup/'.$id.'/'.$invitee_id.'/inviteUser')}}">Invite</a>
						<!--{{ Form::token() . Form::close() }}-->

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
