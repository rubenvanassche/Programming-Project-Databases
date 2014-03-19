<?php

class ParserController extends BaseController {

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

	public function parseteams(){
		$crawler = new CrawlerController;
		$db = new Stats;
		
		// Logica om teams te crawlen vanaf http://int.soccerway.com/teams/rankings/fifa/ 'land' => 'fifa ranking'
		$teams = array();
		
		
		foreach($teams as $team => $ranking){
			// Logica om spelers + coach van team te crawlen van http://int.soccerway.com/teams/spain/spain/2137/squad/
			$coach = '';
			$players = array();
		
			$db->addCoach($coach);
			// Rating moet hier nog bij
			$db->addTeam($team, $team, $coach);
			
			foreach($players as $player){
				$db->addPlayerPerTeam($player, $team);
			}	
		}
		
	}
	
	public function parseWorldcup(){
		$crawler = new CrawlerController;
		$db = new Stats;
		
		// Iemand moet alle landen van de world cup even linken in de database
		
		// Logica om matchen te crawlen van http://int.soccerway.com/international/world/world-cup/2014-brazil/group-stage/r16351/matches/?ICID=PL_3N_02 -> array(array('hometeam'=>'', 'awayteam'=> '', 'date'=> ''))
		
		$matches = array();
		foreach($matches as $match){
			// Date moet er nog bij!
			$db->addMatch($match['hometeam'], $match['awayteam'], 'World Cup');
		}
		
	}


}
?>