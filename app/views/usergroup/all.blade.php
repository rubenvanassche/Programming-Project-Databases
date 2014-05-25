@extends('layouts.master')

@section('content')
	<div class="row">
		<div class="col-md-12">
			<h1>{{$title}}</h1>
			<a class="btn btn-success pull-right" style="margin-top:-45px;" href="{{url('usergroups/new')}}">New Group</a>
		</div>
		<div class="col-md-12">
			<table class="table table-condensed">
				<thead>
					<tr>
						<th>Name</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($groups as $group)
						<?php if ($group->private == false) { ?>
							<tr>
								<td><a href="{{url('usergroup/'.$group->id)}}">{{$group->name}}</a></td>
							</tr>
						<?php } else {
								if ($group->ismember == false) { ?>
									<tr class="private">
										<td>{{$group->name}}</td>
										<td>0</td>
									</tr>
									<?php } else { ?>
										<tr class="private">
											<td><a href="{{url('usergroup/'.$group->id)}}">{{$group->name}}</a></td>
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
	tr.private {
		background-color:#EEEEEE;
	}
</style>
@stop
