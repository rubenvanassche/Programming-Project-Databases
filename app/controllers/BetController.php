<?php

class BetController extends BaseController {

	public function index(){
		$user = new User;
		if ($user->loggedIn()) {
			$pastBets = Bet::getPastBetsByUserID($user->ID());
			$futureBets = Bet::getFutureBetsByUserID($user->ID());
			$pastBetsMatches = array();
			$futureBetsMatches = array();
			foreach ($pastBets as $bet) {
				array_push($pastBetsMatches, Match::get($bet->match_id));
			}
			foreach ($futureBets as $bet) {
				array_push($futureBetsMatches, Match::get($bet->match_id));
			}
			
			$data['title'] = 'Bets';
			$data['pastBets'] = $pastBets;
			$data['futureBets'] = $futureBets;
			$data['pastBetsMatches'] = $pastBetsMatches;
			$data['futureBetsMatches'] = $futureBetsMatches;
			
			return View::make('layouts.simple', $data)->nest('content', 'user.betoverview', $data);
		}
		else {
	    	$data['title'] = 'Not logged in';
	        return View::make('layouts.simple', $data)->nest('content', 'user.nologin', $data);
		}
		

	}

	//Note that $presetValues if supplied should contain keys presetHome, presetAway and presetDate
	function bet(){
		/*TODO: Laravel probably provides a better way to fetch variables from a Match page after a bet page was pressed there than through $_GET
		They are passed through the URL now, maybe that can be circumvented too.
		If anyone knows how, please tell me (Jakob) or feel free to change it yourselves.
		Also note if one of the three parameters is provided (presetHome/Away/Date), all three should be.
		UPDATE: as this goes through modal now, URL is invisible for user */
		if (isset($_GET["presetHome"]))
			$presetValues = array("presetHome" =>  $_GET["presetHome"], "presetAway" => $_GET["presetAway"], "presetDate" => $_GET["presetDate"]);
		else
			$presetValues = array();

		// Work On the Form
		$rules = array(
		        'hometeam' => array('required'),
		        'awayteam' => array('required'),
		        'date' => array('required'),
		        'hometeamScore' => array('integer', 'between:0,100', 'required'),
		        'awayteamScore' => array('integer', 'between:0,100', 'required'),
		        'firstGoal' => array(),
		        'hometeamYellows' => array('integer', 'between:0,100'),
		        'hometeamReds' => array('integer', 'between:0,100'),
		        'awayteamYellows' => array('integer', 'between:0,100'),
		        'awayteamReds' => array('integer', 'between:0,100')
		);

		$validation = Validator::make(Input::all(), $rules);

		if($validation->fails()) {
			// Problem so show the user error messages
			$input = Input::all();//Get all the old input.
			$input['autoOpenBetModal'] = 'true';//Add the auto open indicator flag as an input.
			return Redirect::back()
				->withErrors($validation)
				->withInput($input);//Passing the old input and the flag.
			//return Redirect::to('user/bet')->withInput()->withErrors($validation);
		}else{
			// Start working on this data
			$hometeam = Input::get('hometeam');
			$awayteam = Input::get('awayteam');
			$date = Input::get('date');
			$hometeam_score = Input::get('hometeamScore');
			$awayteam_score = Input::get('awayteamScore');
			$firstGoal = Input::get('firstGoal');
			$hometeam_yellows = Input::get('hometeamYellows');
			$hometeam_reds = Input::get('hometeamReds');
			$awayteam_yellows = Input::get('awayteamYellows');
			$awayteam_reds = Input::get('awayteamReds');
			$hometeamIDs = Team::getIDsByName($hometeam);
			$awayteamIDs = Team::getIDsByName($awayteam);
			$hometeamID = $hometeamIDs[0]->id;
			$awayteamID = $awayteamIDs[0]->id;
			if ($firstGoal == "none")
				$firstGoal_id = NULL;
			if ($firstGoal == "home")
				$firstGoal_id = $hometeamID;
			if ($firstGoal == "away")
				$firstGoal_id = $awayteamID;
			//save blank guesses as NULL
			if ($hometeam_yellows == "")
				$hometeam_yellows = NULL;
			if ($hometeam_reds == "")
				$hometeam_reds = NULL;
			if ($awayteam_yellows == "")
				$awayteam_yellows = NULL;
			if ($awayteam_reds == "")
				$awayteam_reds = NULL;

			$match = Match::getMatchByTeamsAndDate($hometeamID, $awayteamID, $date);
			$user = new User;
			$now = date('y-m-d h:i:s', time());;
			$matchDateTime = new DateTime( $match->date);
			$matchDateTime = $matchDateTime->format("y-m-d h:i:s");
			//Only add if match exists, user is logged in and match is in the future
			//Note that this function should not be called otherwise, this check might be unneeded
			$success = ($match != NULL) && $user->loggedIn() && $now < $matchDateTime;
			if($success == true){
				Bet:: add($match->id, $user->ID(), $hometeam_score, $awayteam_score, $firstGoal_id, $hometeam_yellows, $hometeam_reds, $awayteam_yellows, $awayteam_reds);
				$data['content'] = 'Thank you for filling in your bet.';
				$data['title'] = 'Bet registered!';
				$acceptedInput = array("accepted" => true); //Add the bet accepted indicator flag as an input.
				
				// Do we have to post to Facebook
				if(Input::get("facebookpost") == 'yes'){
					$user = new User;
					
					if(!$user->facebookOnlyUser($user->ID())){
						return Redirect::back()->withInput($acceptedInput);//Go back to match page
					}
					
					$hometeam_name = Team::getTeamByID($hometeamID)[0]->name;
					$awayteam_name = Team::getTeamByID($awayteamID)[0]->name;
					
					$title = "I have placed a bet on ".$hometeam_name." - ".$awayteam_name;
					$message = "Do you think you can do beter then me? Place your own bet at Coachcenter!";
					$url = url('match/'.$match->id);
					
					$user->postToFacebook($title, $message, $url);
				}
				
				return Redirect::back()->withInput($acceptedInput);//Go back to match page
			}else{
				// Something went wrong (shouldn't happen)
				return Redirect::to('user/bet')->withInput();
			}
    	}
	}

	function betmodal(){
		$data['title'] = 'Bet';
		//Propagate the presets if given
		if (isset($_GET["presetHome"]))
			$presetValues = array("presetHome" =>  $_GET["presetHome"], "presetAway" => $_GET["presetAway"], "presetDate" => $_GET["presetDate"]);
		else
			$presetValues = array();
		return View::make('layouts.modal', $data)->nest('content', 'user.bet', $presetValues);
	}


	function showBets() {
		return View::make('layouts.simple', $data)->nest('content', 'user.bets');
	}

}
