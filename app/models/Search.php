<?php
class Search{
	public static function teams($input){		
	    $query = DB::table('team');
	    $query->select(DB::raw('name, id, (SELECT abbreviation FROM country WHERE id = team.country_id) as abbreviation'));
	
	    foreach($input as $term){
	        $query->where('name', 'LIKE', '%'. $term .'%');
	    }
	
	    $results = $query->get();
	    return $results;
	}

	public static function players($input){		
	    $query = DB::table('player');
	    $query->select(DB::raw('name, id'));
	
	    foreach($input as $term){
	        $query->where('name', 'LIKE', '%'. $term .'%');
	    }
	
	    $results = $query->get();
	    return $results;
	}
}

?>