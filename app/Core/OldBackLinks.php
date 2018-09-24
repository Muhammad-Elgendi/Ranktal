<?php
namespace App\Core;

/**
 *
 * Developed by :
 * 	Muhammad Elgendi
 *
 * -Capabilities                 -Return-type
 *
 * mozMetrics                     array
 * hasMozMetrics                  boolean
 * mozLinks                       array
 * hasMozLinks                    boolean
 * olpLinks                       array
 * hasOlpLinks                    boolean
 *
 * BackLinks constructor.
 * @param $url
 *
 * Request URL Example :
 * http://lsapi.seomoz.com/linkscape/url-metrics/moz.com%2fblog?Cols=4&AccessID=member-cf180f7081&Expires=1225138899&Signature=LmXYcPqc%2BkapNKzHzYz2BI4SXfC%3D
 *
 *
 * Cols=103079266336
 *
 * Access ID:mozscape-b8c7023e7a
 *
 * Secret Key:5ec326509fe6cc73fd0333c67022a273
 *
 **/


/**
 * Class BackLinks
 * @package App\Core
 */
class BackLinks{

	private $url;

    /**
     * holds the response of mozMetrics
     * @var
     */
	public $mozMetrics;
    public $hasMozMetrics;
    /**
     * holds the response of mozLinks
     * @var
     */
	public $mozLinks;
    public $hasMozLinks;
    /**
     * holds the response of openLinkProfiler
     * @var
     */
	public $olpLinks;
	public $hasOlpLinks;

    /**
     * BackLinks constructor.
     * @param $url
     */
	function __construct($url){
		$this->url=$url;
		$this->setMozLinks();
		$this->setMozMetrics();
		$this->setOpenLinkProfiler();
		$this->setChecks();
		$this->makeReadableMozLinks();
		$this->makeReadableMozMetrics();
	}

	/*
		Currently the request is set to page_to_domain means that it shows all backlinks that refer to the domain of URL not Just the Page

		and I set the limit of links to 10

		also this api brings the anchor text of the link and shows Dofollow links only

		also it sorts the results om page authority high first
	*/

	private function setMozMetrics(){
		//it takes accessID,secretKey,Time_to_expire
		$test=new Moz('mozscape-b8c7023e7a','5ec326509fe6cc73fd0333c67022a273',300);
		$test->setURL($this->url);		
		$test->sendRequest('data');//get mozMetrics
		$response=$test->getNamedResponse();		
		if($response){			
			$this->mozMetrics=$response;
		}
		return;
	}

	private function setMozLinks(){
		//it takes accessID,secretKey,Time_to_expire
		$test=new Moz('mozscape-b8c7023e7a','5ec326509fe6cc73fd0333c67022a273',300);
		$test->setURL($this->url);		
		$test->sendRequest('links');//get mozLinks
		$response=$test->getRawResponse();		
		if($response){
			$this->mozLinks=$response;		
		}		
		return;
	}

    /**
     * returns the Domain name of Url
     * @param $url
     * @return string
     */
    private function urlToDomain($url) {
        if ( substr($url, 0, 8) == 'https://' ) {
            $url = substr($url, 8);
        }
        if ( substr($url, 0, 7) == 'http://' ) {
            $url = substr($url, 7);
        }
        if ( substr($url, 0, 4) == 'www.' ) {
            $url = substr($url, 4);
        }
        if ( strpos($url, '/') !== false ) {
            $explode = explode('/', $url);
            $url     = $explode['0'];
        }
        return $url;
    }

	private function setOpenLinkProfiler(){
		
		$requestUrl='http://openlinkprofiler.org/r/'.parse_url($this->url, PHP_URL_HOST).'?q='.parse_url($this->url, PHP_URL_HOST).'&st=0&sq=&dt=0&dq=&follow=all&trust=all&tt=0&tq=&at=0&aq=&ind=all&cat=all&tld=all&special=all&found=0&sort=15&num=100&unique=unique&filter=Filter+links';
		// Use Curl to send off your request.
		
		$ch = curl_init($requestUrl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array("User-Agent: Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/60.0.3112.90 Safari/537.36"));		
		$content = curl_exec($ch);
        curl_close($ch);
		if ( $content === false | empty($content)){
            return;
		}
		$doc = new \DOMDocument;
		libxml_use_internal_errors(true);
		$doc->loadHTML($content);
		libxml_use_internal_errors(false);
		try{
		if(!is_null($doc->getElementsByTagName('table')->item(0))){
			$anchors=$doc->getElementsByTagName('table')->item(0)->getElementsByTagName('a');
			$domain=$this->urlToDomain($this->url);
			$links=array();
			foreach ($anchors as $anchor) {
            if(stripos($anchor->getAttribute('href'),$domain)=== false && stripos($anchor->getAttribute('href'),'/r/')=== false)
                    $links[]=$anchor->getAttribute('href');
            }

			if(!empty($links))	
				$this->olpLinks=$links;
		}
        else{
            return;
        }
		}catch (\Exception $e){
		    return;
        }
	}

	private function setChecks(){
        $this->hasMozLinks=(isset($this->mozLinks)) ? true : false ;
        $this->hasMozMetrics=(isset($this->mozMetrics)) ? true : false ;
        $this->hasOlpLinks=(isset($this->olpLinks)) ? true : false ;
    }

    private function makeReadableMozLinks(){
	    /**
         * lt   ->  Anchor Text
         * lrid ->  Internal ID of the link
         * lsrc ->  Internal ID of the source URL
         * ltgt ->  Internal ID of the target URL
         * luuu	->  The canonical form of the target URL
         * uu	->  The canonical form of the source URL
            (OR, for url-metrics calls, the canonical form of the target URL)
         *
         */
	    if (isset($this->mozLinks)){
	        for ($i=0;$i<count($this->mozLinks);$i++){
	           $this->mozLinks[$i]['Anchor Text'] =$this->mozLinks[$i]['lt'];
	           $this->mozLinks[$i]['Target URL'] =$this->mozLinks[$i]['luuu'];
               $this->mozLinks[$i]['Source URL'] =$this->mozLinks[$i]['uu'];
	           unset($this->mozLinks[$i]['lrid'],$this->mozLinks[$i]['lsrc'],$this->mozLinks[$i]['ltgt'],$this->mozLinks[$i]['lt'],$this->mozLinks[$i]['luuu'],$this->mozLinks[$i]['uu']);
            }
        }
    }

    private function makeReadableMozMetrics(){

        if (isset($this->mozMetrics)){
            $this->mozMetrics['MozRank: URL']=round($this->mozMetrics['MozRank: URL mormalized'],2);
            $this->mozMetrics['MozRank: Subdomain']=round($this->mozMetrics['MozRank: Subdomain mormalized'],2);
            $this->mozMetrics['Page Authority']=round($this->mozMetrics['Page Authority'],2);
            $this->mozMetrics['Domain Authority']=round($this->mozMetrics['Domain Authority'],2);
            unset($this->mozMetrics['MozRank: URL raw'],$this->mozMetrics['MozRank: Subdomain raw'],$this->mozMetrics['MozRank: Subdomain mormalized'],$this->mozMetrics['MozRank: URL mormalized']);
        }
    }
}