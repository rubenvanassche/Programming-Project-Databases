@extends('layouts.master')

<?php
	function cardColorToImg($color){
		if($color == 'red'){
			return "<img src='". asset('img/redcard.png') ."' style='height:16px;' />";
		}else if($color == 'yellow'){
			return "<img src='". asset('img/yellowcard.png') ."' style='height:16px;' />";
		}
	}
?>
@section('content')


	
	<?php $autoOpenBetModal = 0;
		  if (isset($_GET["openBet"]) && $bet)
			$autoOpenBetModal = true;
	?>
	<div class="row">
		<div class="col-md-1" style="margin-top:20px;">
			<img style="width:100%;" src="<?php echo Team::getTeamImageURL($match->hometeam); ?>" />
		</div>
		<div class="col-md-4">
			<h1>{{ $match->hometeam }}</h1>
		</div>
		<div class="col-md-2" style="text-align:center;">
			@if ($inFuture)
			<h1>? - ?</h1>
			@else
			<h1>{{ $match->hometeam_score }} - {{ $match->awayteam_score }}</h1>
			@endif
		</div>
		<div class="col-md-4">
			<h1 class="pull-right">{{ $match->awayteam }}</h1>
		</div>
		<div class="col-md-1" style="margin-top:20px;">
			<img style="width:100%;" src="<?php echo Team::getTeamImageURL($match->awayteam); ?>" />
		</div>
	</div>
	<div class="row">
		<div class="col-md-5">
			<a href="{{route('team', array('id'=>$match->hometeam_id))}}">Go to the team</a>
		</div>
		<div class="col-md-2" style="text-align:center;">
			@if($bet)
			<div style="text-align:center;">
				<a href="#" class="btn btn-lg btn-success btn-sm"data-toggle="modal" data-target="#betModal">Bet</a>
			</div>
			@endif

			<?php if($match->date == "0000-00-00 00:00:00") 
						echo "date unknown"; 
					  else {
						$date = new DateTime($match->date);
						echo date_format($date, 'd-m-Y H:i');
					  }
					?>
		</div>
		<div class="col-md-5">
			<a class="pull-right" href="{{route('team', array('id'=>$match->awayteam_id))}}">Go to the team</a>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div style="text-align:center;">
				<p>{{$phase}}</p>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			@if($inFuture)
			<div style="text-align:center;">
				<p>Predictions:</p>
				<p><h2>{{ $predictedScores[0] }} - {{ $predictedScores[1] }}</h2></p>
			</div>
			<div class="progress" style="height:20px;">	
			  <div class="progress-bar progress-bar-success" style="width: {{100 * $predictedOutcome}}%">
				<span>{{$match->hometeam}}: {{100 * $predictedOutcome}}%</span>
			  </div>
			  <div class="progress-bar progress-bar-warning" style="width: {{100 * (1 - $predictedOutcome)}}%">
				<span>{{$match->awayteam}}: {{100 * (1 - $predictedOutcome)}}%</span>
			  </div>
			</div>
			@endif
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<h3>Goals</h3>
			<table id="myTable" class="tablesorter">
				<thead>
					<tr>
						<th>Time</th>
						<th>Name</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($goalshometeam as $goalhometeam)
						<tr>
							<td><?php echo $goalhometeam->time; ?></td>
							<td><a href="{{route('player', array('id'=>$goalhometeam->player_id))}}">{{$goalhometeam->player}}</a></td>
						<tr>
					@endforeach
				</tbody>
			</table>
		</div>
		<div class="col-md-6">
			<h3>Goals</h3>
			<table id="myTable2" class="tablesorter">
				<thead>
					<tr>
						<th>Time</th>
						<th>Name</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($goalsawayteam as $goalawayteam)
						<tr>
							<td><?php echo $goalawayteam->time; ?></td>
							<td><a href="{{route('player', array('id'=>$goalawayteam->player_id))}}">{{$goalawayteam->player}}</a></td>
						<tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<h3>Cards</h3>
			<table id="myTable3"class="tablesorter">
				<thead>
					<tr>
						<th>Time</th>
						<th>Player</th>
						<th>Color</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($cardshometeam as $cardhometeam)
						<tr>
							<td><?php echo $cardhometeam->time; ?></td>
							<td><a href="{{route('player', array('id'=>$cardhometeam->player_id))}}">{{$cardhometeam->player}}</a></td>
							<td><?php echo cardColorToImg($cardhometeam->color); ?></td>
						<tr>
					@endforeach
				</tbody>
			</table>
		</div>
		<div class="col-md-6">
			<h3>Cards</h3>
			<table id="myTable4" class="tablesorter">
				<thead>
					<tr>
						<th>Time</th>
						<th>Player</th>
						<th>Color</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($cardsawayteam as $cardawayteam)
						<?php
							if($cardawayteam->player == ''){
								continue;
							}
						?>
						<tr>
							<td><?php echo $cardawayteam->time; ?></td>
							<td><a href="{{route('player', array('id'=>$cardawayteam->player_id))}}">{{$cardawayteam->player}}</a></td>
							<td><?php echo cardColorToImg($cardawayteam->color); ?></td>
						<tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<h3>Transfers</h3>
			<table id="myTable5" class="tablesorter">
				<thead>
					<tr>
						<th>Time</th>
						<th>Player</th>
						<th>In/Out</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($transfershometeam as $transferhometeam)
						<?php
						if($transferhometeam->intime != '' and $transferhometeam->outtime != ''){
							echo '<tr>';
							echo '<td>'.$transferhometeam->intime.'</td>';
							echo '<td><a href="'.url('player/'.$transferhometeam->player_id).'">'.$transferhometeam->name.'</a></td>';
							echo '<td>In</td>';
							echo '<tr>';
							echo '<tr>';
							echo '<td>'.$transferhometeam->outtime.'</td>';
							echo '<td><a href="'.url('player/'.$transferhometeam->player_id).'">'.$transferhometeam->name.'</a></td>';
							echo '<td>Out</td>';
							echo '<tr>';																		
						}else if($transferhometeam->intime == '' and $transferhometeam->outtime != ''){
							echo '<tr>';
							echo '<td>'.$transferhometeam->outtime.'</td>';
							echo '<td><a href="'.url('player/'.$transferhometeam->player_id).'">'.$transferhometeam->name.'</a></td>';
							echo '<td>Out</td>';
							echo '<tr>';							
						}else if($transferhometeam->intime != '' and $transferhometeam->outtime == ''){
							echo '<tr>';
							echo '<td>'.$transferhometeam->intime.'</td>';
							echo '<td><a href="'.url('player/'.$transferhometeam->player_id).'">'.$transferhometeam->name.'</a></td>';
							echo '<td>In</td>';
							echo '<tr>';
						}else{
							// do nothing
						}
						?>
					@endforeach
				</tbody>
			</table>
		</div>
		<div class="col-md-6">
			<h3>Transfers</h3>
			<table id="myTable6" class="tablesorter">
				<thead>
					<tr>
						<th>Time</th>
						<th>Player</th>
						<th>In/Out</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($transfersawayteam as $transferawayteam)
						<?php
						if($transferawayteam->intime != '' and $transferawayteam->outtime != ''){
							echo '<tr>';
							echo '<td>'.$transferawayteam->intime.'</td>';
							echo '<td><a href="'.url('player/'.$transferawayteam->player_id).'">'.$transferawayteam->name.'</a></td>';
							echo '<td>In</td>';
							echo '<tr>';
							echo '<tr>';
							echo '<td>'.$transferawayteam->outtime.'</td>';
							echo '<td><a href="'.url('player/'.$transferawayteam->player_id).'">'.$transferawayteam->name.'</a></td>';
							echo '<td>Out</td>';
							echo '<tr>';																		
						}else if($transferawayteam->intime == '' and $transferawayteam->outtime != ''){
							echo '<tr>';
							echo '<td>'.$transferawayteam->outtime.'</td>';
							echo '<td><a href="'.url('player/'.$transferawayteam->player_id).'">'.$transferawayteam->name.'</a></td>';
							echo '<td>Out</td>';
							echo '<tr>';							
						}else if($transferawayteam->intime != '' and $transferawayteam->outtime == ''){
							echo '<tr>';
							echo '<td>'.$transferawayteam->intime.'</td>';
							echo '<td><a href="'.url('player/'.$transferawayteam->player_id).'">'.$transferawayteam->name.'</a></td>';
							echo '<td>In</td>';
							echo '<tr>';
						}else{
							// do nothing
						}
						?>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
@stop

@section('css')
<!-- This is the modal for betting -->
<div class="modal fade" id="betModal" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Bet</h4>
            </div>
            <div class="modal-body">
				<!-- TODO: check if there isn't a way to put this form in a separate file without breaking all of the Redirects -->
				{{ Form::open(array('url' => 'user/bet')) }}

				<!--These hidden fields are used to remember teams and date throughout form validation -->
				<div class="form-group">
					{{ Form::hidden('hometeam', $match->hometeam , array('class'=>'form-control')) }}
				</div>

				<div class="form-group">
					{{ Form::hidden('awayteam', $match->awayteam, array('class'=>'form-control')) }}
				</div>

				<div class="form-group">
					{{ Form::hidden('date', $match->date, array('class'=>'form-control')) }}
				</div>



				<div class="form-group">
					<label>{{ Form::label('hometeamScore', 'Home team score (we predict: ' . $predictedScores[0] . ')') }}</label>
					{{ Form::text('hometeamScore', Input::old('hometeamScore'), array('class'=>'form-control')) }}
					{{ $errors->first('hometeamScore', '<label class="error">:message</label>') }}
				</div>

				<div class="form-group">
					<label>{{ Form::label('awayteamScore', 'Away team score (we predict: ' . $predictedScores[1] . ')') }}</label>
					{{ Form::text('awayteamScore', Input::old('awayteamScore'), array('class'=>'form-control')) }}
					{{ $errors->first('awayteamScore', '<label class="error">:message</label>') }}
				</div>


				<div class="form-group">
					<label>{{ Form::label('firstGoal', 'First goal (optional)') }}</label>
					{{ Form::select('firstGoal',  array('none' => '', 'home' => $match->hometeam, 'away' => $match->awayteam)) }}
					{{ $errors->first('firstGoal', '<label class="error">:message</label>') }}
				</div>

				<div class="form-group">
					<label>{{ Form::label('hometeamYellows', 'Yellow cards for home team (optional)') }}</label>
					{{ Form::text('hometeamYellows', Input::old('hometeamYellows'), array('class'=>'form-control')) }}
					{{ $errors->first('hometeamYellows', '<label class="error">:message</label>') }}
				</div>

				<div class="form-group">
					<label>{{ Form::label('hometeamReds', 'Red cards for home team (optional)') }}</label>
					{{ Form::text('hometeamReds', Input::old('hometeamReds'), array('class'=>'form-control')) }}
					{{ $errors->first('hometeamReds', '<label class="error">:message</label>') }}
				</div>

				<div class="form-group">
					<label>{{ Form::label('awayteamYellows', 'Yellow cards for away team (optional)') }}</label>
					{{ Form::text('awayteamYellows', Input::old('awayteamYellows'), array('class'=>'form-control')) }}
					{{ $errors->first('awayteamYellows', '<label class="error">:message</label>') }}
				</div>

				<div class="form-group">
					<label>{{ Form::label('awayteamReds', 'Red cards for away team (optional)') }}</label>
					{{ Form::text('awayteamReds', Input::old('awayteamReds'), array('class'=>'form-control')) }}
					{{ $errors->first('awayteamReds', '<label class="error">:message</label>') }}
				</div>

				{{ Form::submit('Bet', array('class'=>'btn btn-success pull-right')) }}

				{{ Form::token() . Form::close() }}
            </div>

			<div><p/>&nbsp;</div>  <!--makes sure bet button is inside modal-->
    </div>
  </div>
</div>

<!-- This is the modal used when a bet was accepted -->
<div class="modal fade" id="acceptModal" tabindex="-1" role="dialog" aria-labelledby="acceptModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel">Bet registered!</h4>
            </div>
            <div class="modal-body">
                <h3>Thank you for making a bet!</h3>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </div>
  </div>
</div>
@stop

@section('javascript')
<!-- Open bet modal if input contains 'autoOpenModal' or URL openBet, open accept modal if input contains 'accepted' -->
<script>
$(document).ready(function () {
    if ({{$autoOpenBetModal}}) {
        $('#betModal').modal('show');
    }
    if ({{ Input::old('autoOpenBetModal', 'false') }}) {
        $('#betModal').modal('show');
    }
    if ({{ Input::old('accepted', 'false') }}) {
        $('#acceptModal').modal('show');
    }
});
</script>



  <script src="<?php echo asset('js/tablesorter.js'); ?>" ></script>
  <script src="<?php echo asset('js/tablesorter_filter.js'); ?>" ></script>

  <script type="text/javascript">
    jQuery(document).ready(function() {
        $("#myTable6")
        .tablesorter({debug: false, widgets: ['zebra'], sortList: [[0, 0]]})
        .tablesorterFilter({filterContainer: "#filter-box",
                            filterClearContainer: "#filter-clear-button",
                            filterColumns: [0, 1, 2]}); });
  </script>
  <script type="text/javascript">
    jQuery(document).ready(function() {
        $("#myTable5")
        .tablesorter({debug: false, widgets: ['zebra'], sortList: [[0, 0]]})
        .tablesorterFilter({filterContainer: "#filter-box",
                            filterClearContainer: "#filter-clear-button",
                            filterColumns: [0, 1, 2]}); });
  </script>

    <script type="text/javascript">
    jQuery(document).ready(function() {
        $("#myTable4")
        .tablesorter({debug: false, widgets: ['zebra'], sortList: [[0, 0]]})
        .tablesorterFilter({filterContainer: "#filter-box",
                            filterClearContainer: "#filter-clear-button",
                            filterColumns: [0, 1, 2]}); });
  </script>


  <script type="text/javascript">
    jQuery(document).ready(function() {
        $("#myTable3")
        .tablesorter({debug: false, widgets: ['zebra'], sortList: [[0, 0]]})
        .tablesorterFilter({filterContainer: "#filter-box",
                            filterClearContainer: "#filter-clear-button",
                            filterColumns: [0, 1, 2]}); });
  </script>
  <script type="text/javascript">
    jQuery(document).ready(function() {
        $("#myTable2")
        .tablesorter({debug: false, widgets: ['zebra'], sortList: [[0, 0]]})
        .tablesorterFilter({filterContainer: "#filter-box",
                            filterClearContainer: "#filter-clear-button",
                            filterColumns: [0, 1]}); });
  </script>

    <script type="text/javascript">
    jQuery(document).ready(function() {
        $("#myTable")
        .tablesorter({debug: false, widgets: ['zebra'], sortList: [[0, 0]]})
        .tablesorterFilter({filterContainer: "#filter-box",
                            filterClearContainer: "#filter-clear-button",
                            filterColumns: [0, 1]}); });
  </script>


@stop
