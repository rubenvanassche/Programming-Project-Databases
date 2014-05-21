<?php

class RSS {
	public static function getFIFAtext() {
		
		$feed = new SimplePie;
		$feed->set_feed_url('http://www.fifa.com/worldcup/news/rss.xml');
		$feed->enable_order_by_date(true);
		$feed->set_cache_location(base_path() . '/cache/simplepie');
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
		$feed->enable_order_by_date(false);
		$feed->set_cache_location(base_path() . '/cache/simplepie');
		$feed->init();
		
		$articles = array();
		
		foreach ($feed->get_items() as $item):
			$url = RSS::getURL($item);
			array_push($articles, $url);
		endforeach;
		
		
		return $articles;
	}
	
	public static function getURL($item) {
		$htmlDOM = new DOMDocument();
		@$htmlDOM->loadHTML($item->get_content());
		$x = new DOMXPath($htmlDOM);
		
		foreach($x->query("//img") as $node)
		{
			$url = $node->getAttribute("src");
			$correct_url = str_replace("small", "big-lnd", $url);
			return $correct_url;
		}
	}

}
