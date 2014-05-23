@extends('layouts.master')

@section('content')
	<div style="margin-bottom:10px;" class="row">
		<div class="col-md-6">
			<h1>{{$title}}</h1>
			<i><a href="{{url('usergroup/'.$usergroup_id)}}">Back to group</a></i>
		</div>
		<div class="col-md-6">
			<a class="btn btn-success pull-right" style="margin-top:20px;" href="{{url('usergroup/'.$usergroup_id.'/discussion/'.$discussion_id.'/add')}}">New Message</a>
		</div>
	</div>
	
	<div class="row">
		<div class="col-md-12">
			@foreach($content as $item)
				<div class="media">
					<a class="pull-left" href="{{url('profile/'.$item->user_id)}}">
					<img class="media-object" alt="64x64" src="{{$userObj->getPicture($item->user_id)}}" style="width: 64px; height: 64px;">
					</a>
					<div class="media-body">
						<h4 class="media-heading">{{$item->username}}</h4>
						{{$item->content}}
					</div>
				</div>
			@endforeach
		</div>
	</div>

@stop