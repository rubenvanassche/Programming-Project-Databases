<?php

class TeamController extends BaseController {

	public function index($teamID){
		$teamObj = Team::getTeamByID($teamID)[0];
		$teamImageURL = Team::getTeamImageURL($teamObj->name);
		
		// Check if we can find an background picture
		$teamBackground = '';
		if($teamObj->twitterAccount != ''){
			$tweets = Twitter::getUserTimeline(array('screen_name' => $teamObj->twitterAccount, 'count' => 1, 'format' => 'array'));
			if (isset($tweets[0]['user']['profile_banner_url'])) {
				$backgroundpicture = $tweets[0]['user']['profile_banner_url'];
				//$teamBackground = substr($backgroundpicture, 0, -1);
				$teamBackground = $backgroundpicture . "/1500x500";
			}
			
		}
		//Check if there's news for this team
		$teamName = $teamObj->name;
		$articles = RSS::getFIFAtext();
		$hasNews = false;
		foreach ($articles as $article){
			$title = $article->get_title();
			$description = $article->get_description();
			
			$inTitle = strstr($title,$teamName);
			$inDescription = strstr($description,$teamName);
			
			if($inTitle == true or $inDescription == true){
				$hasNews = true;
				break;
			}
		}

		
		return View::make('team.team', compact('teamObj', 'teamImageURL', 'teamBackground', 'hasNews'))->with('title', $teamObj->name);
	}
	
	function all(){
		$teams = Team::getAll();


		return View::make('team.teams', compact('teams'))->with('title', 'Teams');
	}
	
	public function players($teamID){
		$team = Team::getTeamByID($teamID)[0];
		$playerBase = Team::getPlayers($teamID);
		$teamImageURL = Team::getTeamImageURL($team->name);
		
		return View::make('team.players', compact('team', 'playerBase', 'teamImageURL'));
	}
	
	public function information($teamID){
		$teamObj = Team::getTeamByID($teamID)[0];
		$teamText = Team::getTeamText($teamObj->name);
		
		return View::make('team.information', compact('teamText'));
	}
	
	public function matches($teamID){
		$team = Team::getTeamByID($teamID);
		$matches = Team::getMatches($teamID);
		
		return View::make('team.matches', compact('matches'));
	}
	
	public function news($teamID){
		$articles = RSS::getFIFAtext();
		$selectedArticles = array();
		
		$teamObj = Team::getTeamByID($teamID)[0];
		$teamName = $teamObj->name;
		
		foreach ($articles as $article){
			$title = $article->get_title();
			$link = $article->get_permalink();
			$description = $article->get_description();
			
			$inTitle = strstr($title,$teamName);
			$inDescription = strstr($description,$teamName);
			
			if($inTitle == true or $inDescription == true){
				$article = array('title' => $title, 'description' => $description, 'link' => $link);
				array_push($selectedArticles, $article);	
			}
		}
		
		return View::make('team.news', compact('selectedArticles'));
	}
	
	public function twitter($teamID){
		$teamObj = Team::getTeamByID($teamID)[0];
		$twitterAccount = $teamObj->twitterAccount;
		$tweets = Twitter::getUserTimeline(array('screen_name' => $twitterAccount, 'count' => 20, 'format' => 'array'));
		return View::make('team.twitter', compact('tweets', 'twitterAccount'));
	}

	public function graphs($teamID){
		$outcomes = Team::getWinsLossesTies($teamID);
		$yearlyGoalsCards = Team::getYearlyGoalsCards($teamID);
		ksort($yearlyGoalsCards); //Otherwise the graph is all messed up
		return View::make('team.graphs', compact('outcomes', 'yearlyGoals', 'yearlyGoalsCards'));
	}
}

?>
