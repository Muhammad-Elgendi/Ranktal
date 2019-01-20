<?php
namespace App\Core;
/**
 *
 * Developed by :
 * 	Muhammad Elgendi
 *
 * -Capabilities                    -Return-type   Type      -Column-name
 *
 * -pageRank                              int
 * -rankSignalsUniqueDomainLinksCount     int
 * -globalAlexaRank                       int
 * -rankSignalsTotalBackLinks             int
 * -alexaReach                            int
 * -rankDelta                           string
 * -countryName                         string
 * -countryCode                         string
 * -countryRank                           int
 * -alexaBackLinksCount                   int
 * -alexaBackLinks                       array
 * -hasAlexaBackLinks                   boolean
 *
 *Alexa rank is fetched by
 * 1-Alexa API (available free)
 * 2-Alexa API (available restricted usage) credit card is required
 * 3-Rank signals API
 **/

class Alexa{

    //holds the URL of page
	private $url;
	//holds the Domain name of site
	private $domain;
    //stands for page rank
	public $pageRank;
	public $hasPageRank;
    //stands for unique domain links
	public $rankSignalsUniqueDomainLinksCount;
	public $hasRankSignalsUniqueDomainLinksCount;
    //stands for global alexa rank
	public $globalAlexaRank;
	public $hasGlobalAlexaRank;
    //stands for total back links
	public $rankSignalsTotalBackLinks;
	public $hasRankSignalsTotalBackLinks;
    //alexa api only
	public $alexaReach;
	public $hasAlexaReach;
    //alexa api only
	public $rankDelta;
	public $hasRankDelta;
    //stands for COUNTRY name
	public $countryName;
	public $hasCountryName;
    //stands for COUNTRY code
	public $countryCode;
	public $hasCountryCode;
    //stands for COUNTRY rank
	public $countryRank;
	public $hasCountryRank;
    //stands for Sites Linking In //Alexa only
	public $alexaBackLinksCount;
	public $hasAlexaBackLinksCount;
    //holds the backLinks from alexa
	public $alexaBackLinks;
    //flag for the backLinks from alexa
	public $hasAlexaBackLinks=false;

    /**
     * Alexa constructor.
     * @param $url
     */
	function __construct($url){		
		$this->url=$url;
		$this->domain=parse_url($this->url, PHP_URL_HOST);
		$this->setRankSignals();
		$this->setAlexaFromAPI();
        $this->setAlexaBackLinksCount();
        $this->setAlexaBackLinks();
        $this->setChecks();
	}

	private function makeConnection($url){
        // Use Curl to send off your request.
        $options = array(
            CURLOPT_RETURNTRANSFER => true
        );
        $ch = curl_init($url);
        curl_setopt_array($ch, $options);
        $content = curl_exec($ch);
        curl_close($ch);
        if ( $content === false )
            return false;
        else
            return $content;
    }

    /**
     * Sets RankSignals fields
     */
    private function setRankSignals(){
		$requestUrl='https://www.ranksignals.com/api/'.$this->domain;
		$content=$this->makeConnection($requestUrl);
        if($content) {
            $data = json_decode($content, true);
            if (empty($data))
                return;
            $this->pageRank = $data['pr'];
            $this->rankSignalsUniqueDomainLinksCount = $data['linkdomain'];
            $this->rankSignalsTotalBackLinks = $data['linktotal'];
            $this->globalAlexaRank = $data['alexa'];
        }
	}

    /**
     * set alexa API fields if succeeded
     */
	private function setAlexaFromAPI(){
        $requestUrl='http://data.alexa.com/data?cli=10&url='.$this->domain;
        $content=$this->makeConnection($requestUrl);
        if ($content) {
            $xml = simplexml_load_string($content, "SimpleXMLElement", LIBXML_NOCDATA);
            $json = json_encode($xml);
            $data = json_decode($json, TRUE);
            if (empty($data) && !isset($data['SD'])) {
                return;
            }
            if (isset($data['SD']['POPULARITY']['@attributes']['TEXT']))
                $this->globalAlexaRank = $data['SD']['POPULARITY']['@attributes']['TEXT'];
            if (isset($data['SD']['REACH']['@attributes']['RANK']))
                $this->alexaReach = $data['SD']['REACH']['@attributes']['RANK'];
            if (isset($data['SD']['RANK']['@attributes']['DELTA']))
                $this->rankDelta = $data['SD']['RANK']['@attributes']['DELTA'];
            if (isset($data['SD']['COUNTRY']['@attributes']['NAME']))
                $this->countryName = $data['SD']['COUNTRY']['@attributes']['NAME'];
            if (isset($data['SD']['COUNTRY']['@attributes']['CODE']))
                $this->countryCode = $data['SD']['COUNTRY']['@attributes']['CODE'];
            if (isset($data['SD']['COUNTRY']['@attributes']['RANK']))
                $this->countryRank = $data['SD']['COUNTRY']['@attributes']['RANK'];
        }
    }

    /**
     * set the alexa backLinks count if succeed
     */
    private function setAlexaBackLinksCount(){
        $requestUrl='https://www.alexa.com/minisiteinfo/'.$this->domain;
        $content=$this->makeConnection($requestUrl);
        if($content) {
            // search for "sites liking in"
            $doc = new \DOMDocument;
            libxml_use_internal_errors(true);
            $doc->loadHTML($content);
            libxml_use_internal_errors(false);
            try {
                $slin = $doc->getElementsByTagName('a')->item(3)->nodeValue;
            } catch (\Exception $e) {
                return;
            }
            $this->alexaBackLinksCount = $slin;
        }
    }

    /**
     * set alexa backLinks if succeed
     */
	private function setAlexaBackLinks(){
        //form the request url
        $requestUrl = 'https://www.alexa.com/siteinfo/' . $this->domain;
        $content = $this->makeConnection($requestUrl);
        if ($content) {
            // search for "sites liking in"
            $doc = new \DOMDocument;
            libxml_use_internal_errors(true);
            $doc->loadHTML($content);
            libxml_use_internal_errors(false);
            try {
                $anchors = $doc->getElementsByTagName('table')->item(3)->getElementsByTagName('a');
                foreach ($anchors as $anchor) {
                    $link = $anchor->getAttribute('href');
                    if (stripos($link, 'siteinfo/') === false)
                        $this->alexaBackLinks[] = $link;
                }
            }
            catch (\Exception $e) {
                return;
            }
        }
    }

    private function setChecks(){
        $this->hasAlexaBackLinks = (isset($this->alexaBackLinks)) ? true : false;
        $this->hasPageRank=(isset($this->pageRank)) ? true : false;
        $this->hasAlexaBackLinks = (isset($this->alexaBackLinks)) ? true : false;
        $this->hasRankSignalsUniqueDomainLinksCount=(isset($this->rankSignalsUniqueDomainLinksCount)) ? true : false;
        $this->hasGlobalAlexaRank=(isset($this->globalAlexaRank)) ? true : false;
        $this->hasRankSignalsTotalBackLinks=(isset($this->rankSignalsTotalBackLinks)) ? true : false;
        $this->hasAlexaReach=(isset($this->alexaReach)) ? true : false;
        $this->hasRankDelta=(isset($this->rankDelta)) ? true : false;
        $this->hasCountryName=(isset($this->countryName)) ? true : false;
        $this->hasCountryCode=(isset($this->countryCode)) ? true : false;
        $this->hasCountryRank=(isset($this->countryRank)) ? true : false;
        $this->hasAlexaBackLinksCount=(isset($this->alexaBackLinksCount)) ? true : false;
    }

}