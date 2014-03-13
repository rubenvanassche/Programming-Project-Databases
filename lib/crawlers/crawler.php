<?php
include("simple_html_dom.php");

/**
 * @class Crawler
 */
class Crawler {

    /**
     * @brief Constructor
     */
    public function __construct() {
        return;
    }

    /**
     * @brief Get all the teams
     *
     * @param base_url The base_url
     * @param rel_url The relative url
     * @param selector The selector to be used for getting the teams.
     * @param time_limit The maximum amount of time to be elapsed for crawling
     * @param elapsed The time already elapsed
     * @param visited The (relative) urls already visited.
     */
    public function teams( $base_url, $rel_url, $selector, $time_limit, &$elapsed=0, &$visited=array()) {
        $visited[] = $rel_url;

        $start = time();

        $page = new simple_html_dom();
        $page->load_file( $base_url . $rel_url );

        foreach ( $page->find( $selector ) as $team ) {
            print trim( $team->innertext ) . "\n";
        } // end foreach

        // stop if over time
        $elapsed += time() - $start;
        if ( $elapsed >= $time_limit ) {
            $page->clear();
            return;
        } else {
            // visit subpages
            $links = $page->find( "a" );
            $page->clear();

            foreach ( $links as $link ) {
                // only use relative links, so you're sure you will stay on
                // the original site. Also ensure that you haven't visited
                // the page already
                if ( !( substr( $link->href, 0, 1) === '/' ) || in_array( $link->href, $visited ) ) continue;

                $this->teams( $base_url, $link->href, $selector, $time_limit, $elapsed, $visited);

                // stop if over time
                if ( $elapsed >= $time_limit ) break;
            } // end foreach

            return;
        } // end if-else
    }
}

$crawler = new Crawler();
$crawler->teams("http://int.soccerway.com", "/", ".team a", 10);
