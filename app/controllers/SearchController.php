<?php
class SearchController extends BaseController {

	function search($input=''){
		if($input == ''){
			$input = Input::get('input');
		}
		$data['input'] = $input;
		$input = explode(' ', $input);
		
		$data['teams'] = Search::teams($input);
		$data['players'] = Search::players($input);
		$data['matches'] = Search::matches($input);
		$data['users'] = Search::users($input);
		$data['usergroups'] = Search::usergroups($input);

		return View::make('search', $data)->with('title', 'Search');
	}
}