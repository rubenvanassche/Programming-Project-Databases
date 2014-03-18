<?php

class RSS {
	public static function getFIFAtext() {
		
		$feed = new SimplePie;
		$feed->set_feed_url('http://www.fifa.com/worldcup/news/rss.xml');
		$feed->enable_order_by_date(true);
		$feed->set_cache_location($_SERVER['DOCUMENT_ROOT'] . '/Programming-Project-Databases/cache');
		$feed->init();
		
		$articles = array();
		
		foreach ($feed->get_items() as $item):
			array_push($articles, $item);
		endforeach;
		
		return $articles;
	}
	
	public static function getFIFAphotos() {
		
		$feed = new SimplePie;
		$feed->set_feed_url('http://www.fifa.com/worldcup/photo/rss.xml');
		$feed->enable_order_by_date(true);
		$feed->set_cache_location($_SERVER['DOCUMENT_ROOT'] . '/Programming-Project-Databases/cache');
		$feed->init();
		
		$articles = array();
		
		foreach ($feed->get_items() as $item):
			array_push($articles, $item);
		endforeach;
		
		return $articles;
	}

}
