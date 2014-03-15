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
            print trim( $team->plaintext ) . "\n";
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

    /**
     * @brief Get all the matches
     *
     * @param base_url The base_url
     * @param rel_url The relative url
     * @param selectors An array of selectors
     * @param time_limit The maximum amount of time to be elapsed for crawling
     * @param elapsed The time already elapsed
     * @param visited The (relative) urls already visited.
     */
    public function matches( $base_url, $rel_url, $selectors, $time_limit, &$elapsed=0, &$visited=array()) {
        $visited[] = $rel_url;

        $start = time();

        $page = new simple_html_dom();
        $page->load_file( $base_url . $rel_url );

        foreach ( $page->find( $selectors["match"] ) as $match ) {
            $team_a = $match->find( $selectors["team1"] );
            $team_b = $match->find( $selectors["team2"] );
            $score = $match->find( $selectors["score"] );
            $time = $match->find( $selectors["time"] );

            if ( $time ) {
                // match has to be played yet
                print trim($team_a[0]->plaintext) . " " . str_replace(' ', '', $time[0]->plaintext) . " " . trim($team_b[0]->plaintext) . "\n";
            } else if ( $score ) {
                // match is played
                print trim($team_a[0]->plaintext) . " " . str_replace(' ', '', $score[0]->plaintext) . " " . trim($team_b[0]->plaintext) . "\n";
            } else {
                // do nothing
            } // end if-else
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

                $this->matches( $base_url, $link->href, $selectors, $time_limit, $elapsed, $visited);

                // stop if over time
                if ( $elapsed >= $time_limit ) break;
            } // end foreach

            return;
        } // end if-else
    }

    /**
     * @brief Get all the players
     *
     * @param base_url The base_url
     * @param rel_url The relative url
     * @param selector The selector to be used for getting the teams.
     * @param time_limit The maximum amount of time to be elapsed for crawling
     * @param elapsed The time already elapsed
     * @param visited The (relative) urls already visited.
     */
    public function players( $base_url, $rel_url, $selector, $time_limit, &$elapsed=0, &$visited=array()) {
        $visited[] = $rel_url;

        $start = time();

        $page = new simple_html_dom();
        $page->load_file( $base_url . $rel_url );

        foreach ( $page->find( $selector ) as $player ) {
            print trim( $team->plaintext ) . "\n";
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
print "TEAMS\n";
print "-------\n";
$crawler->teams("http://int.soccerway.com", "/", ".team a", 5);
print "\n";

print "MATCHES\n";
print "-------\n";
$selectors = array(
    "match" => "table.matches tbody tr.match",
    "team1" => "td.team-a a",
    "team2" => "td.team-b a",
    "score" => "td.score a",
    "time" => "td.status a span.timestamp" );
$crawler->matches("http://int.soccerway.com", "/", $selectors, 5);
print "\n";

print "PLAYERS\n";
print "-------\n";
$crawler->players("http://int.soccerway.com", "/", "table tbody td.player a", 5);
print "\n";
