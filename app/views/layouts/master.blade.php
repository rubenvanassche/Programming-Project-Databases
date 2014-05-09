<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<title>{{{ $title or 'NOTITLE' }}} - Coach Center</title>
		<link href="<?php echo asset('css/bootstrap.min.css'); ?>"  rel="stylesheet" type="text/css">
		<link href="<?php echo asset('css/flags.css'); ?>"  rel="stylesheet" type="text/css">
		<link href="<?php echo asset('css/style.css'); ?>"  rel="stylesheet" type="text/css">
		@yield('css')
	</head>
	
	<body>
		<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="<?php echo url('/'); ?>">Coach Center</a>
				</div>
				<div class="collapse navbar-collapse">
					
					{{ Form::open(array('url' => 'search', 'class'=>'navbar-form navbar-right')) }}
						<div class="form-group">
							{{ Form::text('input', '', array('class'=>'form-control', 'id'=>'searchbar', 'style' => 'width:100%;', 'placeholder'=>'Type searchterm here')) }}
						</div>
						<button type="submit" id="searchbutton" class="btn btn-primary"><i class="glyphicon glyphicon-search"> </i></button>
					{{ Form::token() . Form::close() }}
					<ul class="nav navbar-nav navbar-left">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-user"> </i> <b class="caret"></b></a>
							<ul class="dropdown-menu">
							<?php
							$user = new User;
							if($user->loggedIn()){
							?>
								<li><a href="{{ url('usergroups') }}">User Groups</a></li>
								<li><a href="{{ action('BetController@index') }}">View bets</a></li>
								<li><a href="{{ action('UserController@account') }}">Preferences</a></li>
								<li class="divider"></li>
								<li><a href="{{ action('UserController@logout') }}">Logout</a></li>
							<?php
							}else{
							?>
								<li><a href="{{ action('UserController@loginmodal') }}" data-toggle="modal" data-target="#dasModel">Login</a></li>
								<li><a href="{{ action('UserController@register') }}">New Account</a></li>
							<?php
							}
							?>
							</ul>
						</li>
					</ul>
				</div><!--/.nav-collapse -->
			</div>
		</div>
		
		<div class="container">
			<?php
				if(isset($view) == true){
					// Show a View
					echo $view;
				}else{
			?>
		@yield('content')
			<?php
				}
			?>
		</div><!-- /.container -->
		
		<!--
		<div id="bottom" >
			&copy; CoachCenter 2014
		</div><!-- End Bottom -->
			
		<!-- Modal -->
		<div class="modal fade" id="dasModel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel">Modal title</h4>
				</div>
				<div class="modal-body">
					...
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary">Save changes</button>
				</div>
				</div>
			</div>
		</div>
		
		
		
		<!-- Bootstrap core JavaScript
		================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->
		<script src="<?php echo asset('js/jquery.min.js'); ?>" ></script>
		<script src="<?php echo asset('js/bootstrap.min.js'); ?>" ></script>
		@yield('javascript')
	</body>
</html>
