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
						<th>Score</th>
					</tr>
				</thead>
				<tbody>	
					@foreach ($groups as $group)
						<tr>
							<td><a href="">{{$group->name}}</a></td>
						</tr>
					@endforeach					
				</tbody>
			</table>
		</div>
	</div>
@stop