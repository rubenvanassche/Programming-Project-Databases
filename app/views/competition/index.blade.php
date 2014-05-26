@extends('layouts.master')

@section('content')
	<div class="row">
		<div class="col-md-12">
			<ol class="breadcrumb">
				<li><a href="{{ route('home') }}">Home</a></li>
				<li class="active">Competitions</li>
			</ol>
		</div>
	</div>

	<div class="row">
		<div class="col-md-8">
			<h1>Competitons</h1>
		</div>
		<div class="col-md-4">
			
		</div>
		<div class="col-md-12">

			
			<table id="myTable" class="tablesorter">
				<thead>
					<tr>
						<th>Competiton</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($competitions as $competition)
						<tr>
							<td><a href="{{url('competition/'.$competition->id)}}">{{$competition->name}}</a></td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
@stop

