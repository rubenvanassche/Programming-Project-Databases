@extends('layouts.master')

@section('css')
	<style>
		.widepicture{
			background-image: url('{{{ $widepicture or '' }}}');
		}
	</style>

@stop

@section('content')

<div class="widepicture">

</div>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<h1 class="widepicturetitle">{{{ $title or 'NOTITLE' }}}</h1>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			{{{ $content  or ''  }}}
		</div>
	</div>
</div>

@stop
