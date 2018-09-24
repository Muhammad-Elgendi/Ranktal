<?php
namespace App\Core;
require_once 'Moz.php';
require_once 'vendor/autoload.php';
require_once '../../vendor/autoload.php';
require_once "../../vendor/laravel/framework/src/Illuminate/Foundation/helpers.php";
/**
 *
 * Developed by :
 * 	Muhammad Elgendi
 **/
$dotenv = new \Dotenv\Dotenv(dirname(dirname(__DIR__)));
$dotenv->load();

$p =new Metrics("https://is.net.sa");

$class_methods = get_class_methods($p);

foreach ($class_methods as $method_name) {
    if($method_name != "__construct")
        $p->$method_name();
}

var_dump(get_object_vars($p));

class Metrics{

    //holds the URL of page
	private $url;
	//holds the Domain name of site
	private $domain;

    public $pageRank;
    public $rankSignalsUniqueDomainLinksCount;
    public $rankSignalsTotalBackLinks;
    public $globalAlexaRank;
    public $alexaReach;
    public $rankDelta;
    public $countryName;
    // public $countryCode;
    public $countryRank;
    public $alexaBackLinksCount;
    public $MozRankURL;
    public $MozRankSubdomain;
    public $PageAuthority;
    public $DomainAuthority;
    public $MozTotalLinks;
    public $MozExternalEquityLinks;

      /**
     * Metrics constructor.
     * @param $url
     */
	function __construct($url){		
		$this->url=$url;
		$this->domain=parse_url($this->url, PHP_URL_HOST);
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
    public function setRankSignals(){
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
	public function setAlexaFromAPI(){
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
            // if (isset($data['SD']['COUNTRY']['@attributes']['CODE']))
            //     $this->countryCode = $data['SD']['COUNTRY']['@attributes']['CODE'];
            if (isset($data['SD']['COUNTRY']['@attributes']['RANK']))
                $this->countryRank = $data['SD']['COUNTRY']['@attributes']['RANK'];
        }
    }

     /**
     * set the alexa backLinks count if succeed
     */
    public function setAlexaBackLinksCount(){
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

	/*
		Currently the request is set to page_to_domain means that it shows all backlinks that refer to the domain of URL not Just the Page

		and I set the limit of links to 10

		also this api brings the anchor text of the link and shows Dofollow links only

		also it sorts the results on page authority high first
	*/

	public function setMozMetrics(){
        //it takes accessID,secretKey,Time_to_expire
        $id = env('MOZ_ID', 'mozscape-b8c7023e7a');
        $secret = env('MOZ_SECRET', '5ec326509fe6cc73fd0333c67022a273');
        $expire = env('MOZ_EXPIRE', 300);
		$test=new Moz($id,$secret,$expire);
		$test->setURL($this->url);		
		$test->sendRequest('data');//get mozMetrics
		$response=$test->getNamedResponse();		
		if($response){	
            $this->MozRankURL = $response['MozRank: URL normalized'];
            $this->MozRankSubdomain = $response['MozRank: Subdomain normalized'];
            $this->PageAuthority = $response['Page Authority'];
            $this->DomainAuthority = $response['Domain Authority'];
            $this->MozTotalLinks =  $response['Links'];
            $this->MozExternalEquityLinks  = $response['External Equity Links'];
		}	
    }
}