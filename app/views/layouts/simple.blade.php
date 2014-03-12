@extends('layouts.master')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h1>{{{ $title or 'NOTITLE' }}}</h1>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			{{ $content  or ''  }}
		</div>
	</div>
</div>
@stop
