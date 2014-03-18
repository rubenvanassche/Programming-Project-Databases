<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function index(){	
		//$xml = simplexml_load_file("http://www.fifa.com/worldcup/photo/rss.xml");
		//$xmlIterator = new SimpleXMLIterator($xml);
		
		$recentMatches = Match::getRecentMatches();
		$countryFlags = array();
		$matchGoals = array();
		$recentTeamMatches = array();
		
		foreach ($recentMatches as $rm) {
			$hid = Team::getTeambyID($rm->hometeam_id);
			$aid = Team::getTeambyID($rm->awayteam_id);
			array_push($recentTeamMatches, $hid, $aid);
			
			$hGoals = Goal::getHomeGoals($rm);
			$aGoals = Goal::getAwayGoals($rm);
			array_push($matchGoals, count($hGoals), count($aGoals));
			
			$hFlag = Country::getCountry($hid[0]->country_id);
			$aFlag = Country::getCountry($aid[0]->country_id);
			array_push($countryFlags, $hFlag, $aFlag);
		}
		
		return View::make('home', compact('recentMatches', 'recentTeamMatches', 'matchGoals', 'countryFlags'))->with('title', 'Home');

	}


}

?>
