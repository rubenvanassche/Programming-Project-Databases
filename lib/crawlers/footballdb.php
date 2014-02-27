<?php

include("../../vendor/cuab/phpcrawl/libs/PHPCrawler.class.php");

/*
 * @class FootballDBCrawler
 * @brief Crawler for Footballdatabases.com
 */
class FootballDBCrawler extends PHPCrawler {

    /*
     * @brief Handle document info.
     * @details Overriden from the base class. Handles every information and 
     * put the stuffs in a database with more stuffs.
     *
     * @param docinfo The HTML document whom data should be pulled out of it.
     */
    function handleDocumentInfo( $docinfo ) {
        echo "Page requested: " . $docinfo->url . "\n";

        // if content received, then pull the data-shit out of it
        if ( $docinfo->received == true ) {
            echo "\t Content received.\n";

            $doc = new DOMDocument();
            $doc->loadHTMLFile( $docinfo->url );

            $xpath = new DOMXPath( $doc );

            // Now do some XPath queries here...
            // For example:
            // $clubs = $xpath->query( "//*[@class='club']/a/div[@class='limittext']/text()" );
        } else {
            echo "\t Content NOT received.\n";
        } // end if-else

        flush();
        return;
    } // end member handleDocumentInfo()

} // end class MyCrawler

// it may take a while to crawl a site, so let's set the time limit to crawl 
// the site to 10 000ms
set_time_limit(10000);

$crawler = new FootballDBCrawler();

// first, some settings before running the crawler
$crawler->setURL("http://footballdatabase.com/");           // URL to crawl
$crawler->addContentTypeReceiveRule("#text/html#");         // only HTML content
$crawler->addURLFilterRule("#\.(jpg|jpeg|gif|png)$# i");    // ignore images
$crawler->enableCookieHandling(true);                       // treat cookies
$crawler->setTrafficLimit(1000 * 1024);                     // suck 1 MB

$crawler->go();
