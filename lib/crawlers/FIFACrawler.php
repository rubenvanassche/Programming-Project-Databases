<?php
require_once '../../vendor/autoload.php';
use Symfony\Component\DomCrawler\Crawler;

/**
 * @class FIFACrawler
 */
class FIFACrawler {

    /**
     * @var The base url
     */
    private $base_url;

    /**
     * @brief Constructor
     */
    public function __construct() {
        $this->base_url = "http://www.fifa.com/";
        return;
    }

    /**
     * @brief Grab 'em all.
     */
    public function grab() {
        $this->countries();
        return;
    }


    /**
     * @brief Grab the countries
     */
    private function countries() {
        $html = new DOMDocument();
        $html->loadHTMLFile( $this->base_url."/worldranking/rankingtable/index.html" );

        $crawler = new Crawler($html);

        $countries = $crawler->filterXPath("id('tbl_rankingTable')/tbody/tr/td[contains(@class, 'rnkTeam')]");
        foreach ($countries as $country) {
            print $country->textContent."\n";
        }

        return;
    }
}

$crawler = new FIFACrawler();
$crawler->grab();
