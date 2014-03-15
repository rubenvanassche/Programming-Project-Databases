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

	public function showWelcome()
	{
		Stats::addContinent("Europe");
		Stats::addCountry("Belgium", "Europe", "be");
		Stats::addCompetition("World Cup");
		Stats::addCoach("Marc Wilmots");
		Stats::addTeam("Belgium", "Belgium", "Marc Wilmots");
		
		Stats::addCountry("Russia", "Europe", "ru");
		Stats::addCoach("Fabio Capello");
		Stats::addTeam("Russia", "Russia", "Fabio Capello");
		
		Stats::addTeamPerCompetition("Belgium", "World Cup");
		Stats::addTeamPerCompetition("Russia", "World Cup");
		Stats::addMatch("Belgium", "Russia", "World Cup");
		
		Stats::addPlayerUnique("Vincent Kompany", 0);
		Stats::addPlayerPerTeam("Vincent Kompany", "Belgium");
		
		Stats::addPlayerUnique("Igor Denisov", 0);
		Stats::addPlayerPerTeam("Igor Denisov", "Russia");
		
		Stats::addPlayerUnique("Dries Mertens", 0);
		Stats::addPlayerPerTeam("Dries Mertens", "Belgium");
		
		Stats::addPlayerUnique("Nacer Chadli", 0);
		Stats::addPlayerPerTeam("Nacer Chadli", "Belgium");
		
		Stats::addPlayerUnique("Thibaut Courtois", 0);
		Stats::addPlayerPerTeam("Thibaut Courtois", "Belgium");
		
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
