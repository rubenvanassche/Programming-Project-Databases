<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>{{{ $title or 'NOTITLE' }}} - Coach Center</title>
		<link href="<?php echo asset('css/bootstrap.min.css'); ?>"  rel="stylesheet" type="text/css">
		<link href="<?php echo asset('css/flags.css'); ?>"  rel="stylesheet" type="text/css">
		<link href="<?php echo asset('css/font-awesome.min.css'); ?>"  rel="stylesheet" type="text/css">
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
							{{ Form::text('input', '', array('class'=>'form-control', 'id'=>'searchbar', 'style' => 'width:100%; padding:0.35em; ', 'placeholder'=>'Type searchterm here')) }}
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
								<li><a href="{{url('profile')}}">My Profile</a></li>
								<li><a href="{{ action('BetController@index') }}">Bets</a></li>
								<li><a href="{{ action('UserController@account') }}">Preferences</a></li>
								<li class="divider"></li>
								<li><a href="{{ action('UserController@logout') }}">Logout</a></li>
							<?php
							}else{
							?>
								<li><a href="" data-toggle="modal" data-target="#loginModal">Login</a></li>
								<li><a href="{{ action('UserController@register') }}">New Account</a></li>
							<?php
							}
							?>
							</ul>
						</li>
					</ul>
					<?php
					if($user->loggedIn()) {
						if (count($notifications) > 0) {
					?>
					<ul class="nav navbar-nav navbar-left">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-star"><sup>{{count($notifications)}}</sup></i></a>
							<ul class="dropdown-menu">
								@foreach ($notifications as $notification)
									<?php $id = $notification["id"]?>
									<li><a href="{{route('notification', array('id'=>$id))}}">{{$notification['message']}}</a></li>
								@endforeach
							</ul>
						</li>

					<?php
						}else{
					?>
					<ul class="nav navbar-nav navbar-left">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-star"></i></a>
							<ul class="dropdown-menu">
									<li><a href="{{url('profile')}}">No new notifications</a></li>
							</ul>
						</li>
					<?php
						}
					?>
						<li><a href="{{url('usergroups')}}"><i class="glyphicon glyphicon-tower"></i></a></li>
						<li><a href="{{url('users')}}"><i class="fa fa-users"></i></a></li>
						<li><a href="{{url('upcoming')}}"><i class="glyphicon glyphicon-euro"></i></a></li>
					</ul>
					<?php
					}
					else {?>
						<ul class="nav navbar-nav navbar-left">
							<li><a href="{{url('users')}}"><i class="fa fa-users"></i></a></li>
							<li><a href="{{url('upcoming')}}"><i class="glyphicon glyphicon-euro"></i></a></li>
						</ul>
					<?php } ?>

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
		<script src="http://code.jquery.com/jquery-migrate-1.2.1.js"></script>
		<script src="<?php echo asset('js/bootstrap.min.js'); ?>" ></script>


		<!-- This script makes sure login and logout modals appear on any page -->
		<script>
		$(document).ready(function () {
			if ({{ Input::old('autoOpenLoginModal', 'false') }}) {
				$('#loginModal').modal('show');
			}
			if ({{ Input::old('loggedOut', 'false') }}) {
				$('#logoutModal').modal('show');
			}
		});
		</script>

		@yield('javascript')
	</body>
</html>

<!-- This is the  modal that appears once a user has logged out-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Logged out!</h4>
            </div>
            <div class="modal-body">
                <h3>Most of our content is still available to logged out users!</h3>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </div>
  </div>
</div>

<!-- This is the modal for logging in -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Bet</h4>
            </div>
            <div class="modal-body">

				<?php
				if(Notification::showAll() != '' or $errors->first('username') != '' or $errors->first('password') != ''){
				?>
				<div class="alert alert-danger alert-dismissable">
				  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
				  <strong>Error!</strong> Please check these things:
				  <p>{{ Notification::showAll() }}</p>
				  <p>{{ $errors->first('username') }}</p>
				  <p>{{ $errors->first('password') }}</p>
				</div>
				<?php
				}
				?>

				{{ Form::open(array('url' => 'user/login')) }}

				<div class="form-group">
					<label>{{ Form::label('username', 'Username') }}</label>
					{{ Form::text('username', Input::old('username'), array('class'=>'form-control')) }}
				</div>

				<div class="form-group">
					<label>{{ Form::label('password', 'Password') }}</label>
					{{ Form::password('password', array('class'=>'form-control')) }}
				</div>

				<a href="{{ action('UserController@passwordforgot') }}" class="btn btn-warning pull-left">Recover Password</a>
				<a href="{{ url('user/facebooklogin') }}" class="btn btn-primary pull-right">Facebook Login</a>
				{{ Form::submit('Login', array('class'=>'btn btn-success pull-right')) }}

				{{ Form::token() . Form::close() }}
			<div><p/>&nbsp;</div>  <!--makes sure login button is inside modal-->
    	</div>
  	</div>
</div>
