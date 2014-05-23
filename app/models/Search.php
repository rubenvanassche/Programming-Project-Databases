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
	
	public static function matches($input){	
		$input = implode($input, ' ');	
		$results = DB::select("SELECT id FROM `match` WHERE hometeam_id IN (SELECT id FROM team WHERE name = ?) OR awayteam_id IN (SELECT id FROM team WHERE name = ?)", array($input, $input));
		
		$out = array();
		
		foreach($results as $result){
			$x = DB::select("SELECT id, (SELECT name FROM team WHERE id = `match`.hometeam_id) AS hometeam,  (SELECT name FROM team WHERE id = `match`.awayteam_id) AS awayteam FROM `match` WHERE id = ?", array($result->id));
			array_push($out, $x[0]);
		}
	    return $out;
	}
	
	public static function users($input){		
	    $query = DB::table('user');
	    $query->select(DB::raw('username, id'));
	
	    foreach($input as $term){
	        $query->where('username', 'LIKE', '%'. $term .'%');
	    }
	
	    $results = $query->get();
	    return $results;
	}

	public static function usergroups($input){		
	    $query = DB::table('userGroup');
	    $query->select(DB::raw('name, id, private'));
	
	    foreach($input as $term){
	        $query->where('name', 'LIKE', '%'. $term .'%');
	    }
	
	    $results = $query->get();
	    return $results;
	}
	
}

?>