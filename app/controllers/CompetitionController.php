<?php

class CompetitionController extends BaseController {

	public function index(){
		$data['competitions'] = Competition::getAll();


		return View::make('competition.index', $data)->with('title', 'Competitions');
	}

	function competition($id){
		$data['competition'] = Competition::get($id);
		$data['teams'] = Competition::getTeams($id);
		$data['matches'] = Competition::getMatches($id);
		$data['goals'] = Competition::getGoals($id);
		
		
		return View::make('competition.competition', $data)->with('title', $data['competition']->name);
	}

}
