<?php
class SearchController extends BaseController {

	function search($input){
		$input = explode(' ', $input);
		$data['teams'] = Search::teams($input);
		$data['players'] = Search::teams($input);
		print_r($data['players']);
		
		return View::make('search', $data)->with('title', 'Search');
	}
}