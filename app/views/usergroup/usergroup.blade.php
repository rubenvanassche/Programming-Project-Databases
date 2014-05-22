@extends('layouts.master')

@section('content')
	<div class="row">
		<div class="col-md-6">
			<h1>{{$title}}</h1>
		</div>
		<div class="col-md-6">
			<?php
			$user = new User;
			if(UserGroup::isMember($user->ID(), $id)) {
			?>	
						<a class="btn btn-danger pull-right" style="margin-top:20px;" href="{{url('usergroup/'.$id.'/leave')}}">Leave Group</a>
						<a class="btn btn-warning pull-right" style="margin-top:20px;" href="{{url('usergroup/'.$id.'/invite')}}">Invite users</a><a class="btn btn-success pull-right" style="margin-top:20px;" href="{{url('usergroup/'.$id.'/addmessage')}}">New Message</a>
						
			<?php
			}else{
			?>
				<a class="btn btn-success pull-right" style="margin-top:20px;" href="{{url('usergroup/'.$id.'/addMe')}}">Join Group</a>
			<?php
			}
			?>
		</div>
	</div>
	<div class="row">
		
		
			@foreach ($users as $user)
				<div class="col-md-3">
					<a href="{{url('profile/'.$user->id)}}"><i class="glyphicon glyphicon-user"></i> {{$user->username}}</a>
				</div>
			@endforeach
			
	</div>
	<div class="row">
		<hr />
	</div>
	<?php
	$user = new User;
	?>
	@if(UserGroup::isMember($user->ID(), $id))
		<div class="row">
			<div class="col-md-12">
				@if(empty($messages))
					<p>No messages, <a href="{{url('usergroup/'.$id.'/addmessage')}}">create a new one</a>.
				@endif
				<ul class="list-group">
				  @foreach($messages as $message)
				  <li class="list-group-item">
				    <span class="badge">14</span>
				    Cras justo odio
				  </li>
				  @endforeach
				</ul>
			</div>
		</div>
		
		<div class="row">
			<hr />
		</div>
	@endif	
	
	<ul class="timeline">
		<?php
			$ticktock = 0;
		?>
		@foreach($timeline as $item)
			<?php
				if($ticktock == 1){
					$ticktock = 0;
					echo '<li class="timeline-inverted">';
				}else{
					$ticktock = 1;
					echo '<li>';
				}
			?>
				<div class="timeline-badge {{$item['color']}}"><i class="glyphicon {{$item['icon']}}"></i></div>
				<div class="timeline-panel">
					<div class="timeline-heading">
						<h4 class="timeline-title">{{$item['title']}}</h4>
						<p><small class="text-muted"><i class="glyphicon glyphicon-time"></i> {{$item['date']}}</small></p>
					</div>
					<div class="timeline-body">
						{{$item['content']}}
					</div>
				</div>
			</li>
		@endforeach
	</ul>
@stop

@section('css')
	<link href="<?php echo asset('css/timeline.css'); ?>"  rel="stylesheet" type="text/css">
@stop