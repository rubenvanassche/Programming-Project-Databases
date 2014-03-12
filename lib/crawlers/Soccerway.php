<?php
require_once '../../vendor/autoload.php';
use Symfony\Component\DomCrawler\Crawler;

/**
 * @class SoccerwayCrawler
 */
class SoccerwayCrawler {

    /**
     * @var The base url
     */
    private $base_url;

    /**
     * @brief Constructor
     */
    public function __construct() {
        $this->base_url = "http://int.soccerway.com/";
        return;
    }

    /**
     * @brief Grab 'em all.
     */
    public function grab() {
        $this->countries();
        $this->matches();
        return;
    }


    /**
     * @brief Grab the countries
     */
    private function countries() {
        $html = new DOMDocument();
        $html->loadHTMLFile( $this->base_url."/teams/national-teams/?ICID=TN_03_03" );

        $crawler = new Crawler($html);

        $countries = $crawler->filterXPath("id('page_teams_1_block_teams_index_national_teams_2')/ul/li/div/a");
        foreach ($countries as $country) {
            print trim( $country->textContent ) . "\n";
        }

        return;
    }

    /**
     * @brief Grab the matches
     */
    private function matches() {
        $html = new DOMDocument();
        $html->loadHTMLFile( $this->base_url."international/world/world-cup/2014-brazil/group-stage/r16351/matches/?ICID=PL_3N_02" );

        $crawler = new Crawler($html);

        $teams_a = $crawler->filterXPath("//table[contains(@class, 'matches')]/tbody/tr/td[contains(@class, 'team-a')]");
        $teams_b = $crawler->filterXPath("//table[contains(@class, 'matches')]/tbody/tr/td[contains(@class, 'team-b')]");
        $status = $crawler->filterXPath("//table[contains(@class, 'matches')]/tbody/tr/td[contains(@class, 'status')]");

        $FUCK_PHP_A = array();
        $FUCK_PHP_B = array();
        $FUCK_PHP_C = array();

        foreach ($teams_a as $a) {
            $FUCK_PHP_A[] = trim($a->textContent);
        }

        foreach ($teams_b as $b) {
            $FUCK_PHP_B[] = trim($b->textContent);
        }

        foreach ($status as $s) {
            $FUCK_PHP_C[] = trim($s->textContent);
        }

        for ($index = 0; $index < sizeof($FUCK_PHP_C); $index++) { // WTF SIZEOF??? use ->length or ->size YOU DUMBFUCK!
            print $FUCK_PHP_A[$index]." ".$FUCK_PHP_C[$index]." ".$FUCK_PHP_B[$index]."\n";
        }
        return;
    }
}

$crawler = new SoccerwayCrawler();
$crawler->grab();
