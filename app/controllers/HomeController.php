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
    |   Route::get('/', 'HomeController@showWelcome');
    |
    */

    public function index(){
        Notifications::sendReminders(20);

        $user = new User;
        //require_once('../lib/autoloader.php');
        $recentMatches = Match::getRecentMatches(5);
	      $futureMatches = Match::getFutureMatches(5);
        $articles = RSS::getFIFAtext();
        $playedMatchInfo = array();
	      $futureMatchInfo = array();
        $topteams = Team::getTopTeams(5);
        $fifaPoints = Team::getFIFAPoints(true);


        foreach ($recentMatches as $rm) {
		$info = Match::getInfo($rm);
        	array_push($playedMatchInfo, $info);

        }

	foreach($futureMatches as $fm) {
		$info = Match::getInfo($fm);
		array_push($futureMatchInfo, $info);
	}

        return View::make('home', compact('recentMatches', 'playedMatchInfo', 'topteams', 'articles', 'fifaPoints', 'futureMatchInfo'))->with('title', 'Home');
    }

    public function news(){
        $articles = RSS::getFIFAtext();
        return View::make('news', compact('articles'))->with('title', 'News');
    }


}
