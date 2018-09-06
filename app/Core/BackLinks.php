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

class Moz{

    public $accessID;
    public $secretKey;
    public $expires;
    public $objectURL;
    //Set defualt to our required data
    public $cols=103079266336;
    private $urlSafeSignature;
    private $error='';
    private $response;

    /**
     * Moz constructor.
     * @param $accessID
     * @param $secretKey
     * @param $expires
     */
    function __construct($accessID,$secretKey,$expires){

        // Get your access id and secret key here: https://moz.com/products/api/keys
        $this->accessID = $accessID;
        $this->secretKey = $secretKey;

        // Set your expires times for several minutes into the future.
        // An expires time excessively far in the future will not be honored by the Mozscape API.
        $this->expires = time() + $expires;

        // Put each parameter on a new line.
        $stringToSign = $this->accessID."\n".$this->expires;

        // Get the "raw" or binary output of the hmac hash.
        $binarySignature = hash_hmac('sha1', $stringToSign, $this->secretKey, true);

        // Base64-encode it and then url-encode that.
        $this->urlSafeSignature = urlencode(base64_encode($binarySignature));
    }

    /**
     * @param $url
     */
    function setURL($url){
        // Specify the URL that you want link metrics for.
        $this->objectURL = $url;
    }

    /**
     * @param $cols
     */
    function setCols($cols){
        // Add up all the bit flags you want returned.
        // Learn more here: https://moz.com/help/guides/moz-api/mozscape/api-reference/url-metrics
        $this->cols = $cols;
    }

    /**
     * @param $type
     * @return bool
     */
    function sendRequest($type){
        // Put it all together and you get your request URL.
        // This example uses the Mozscape URL Metrics API.
        switch ($type) {
            case 'data':
                $requestUrl = "http://lsapi.seomoz.com/linkscape/url-metrics/".urlencode($this->objectURL)."?Cols=".$this->cols."&AccessID=".$this->accessID."&Expires=".$this->expires."&Signature=".$this->urlSafeSignature;
                break;

            case 'links':
                $requestUrl = "http://lsapi.seomoz.com/linkscape/links/".urlencode($this->objectURL)."?AccessID=".$this->accessID."&Expires=".$this->expires."&Signature=".$this->urlSafeSignature."&Scope=page_to_domain&Filter=external+follow&Sort=page_authority&SourceCols=4&TargetCols=4&LinkCols=4&Limit=10";
                break;
            default:
                return false;
                break;
        }

        // Use Curl to send off your request.
        $options = array(
            CURLOPT_RETURNTRANSFER => true
        );

        $ch = curl_init($requestUrl);
        curl_setopt_array($ch, $options);
        $content = curl_exec($ch);
        if ( $content === false ){
            $this->error = curl_error( $ch );
            return false;
        }
        curl_close($ch);
        $data = json_decode($content,true);
        $this->response=$data;
    }

    // This function can name the response from request with cols= 103079266336
    function getNamedResponse(){
        if(!empty($this->error))
            return false;
        else{
            $this->response['External Equity Links'] = $this->response['ueid'];
            $this->response['Links'] = $this->response['uid'];
            $this->response['MozRank: URL mormalized'] = $this->response['umrp'];
            $this->response['MozRank: URL raw'] = $this->response['umrr'];
            $this->response['MozRank: Subdomain mormalized'] = $this->response['fmrp'];
            $this->response['MozRank: Subdomain raw'] = $this->response['fmrr'];
            $this->response['Page Authority'] = $this->response['upa'];
            $this->response['Domain Authority'] = $this->response['pda'];
            unset($this->response['ueid'],$this->response['uid'],$this->response['umrp'],$this->response['umrr'],$this->response['fmrp'],$this->response['fmrr'],$this->response['upa'],$this->response['pda']);
            return $this->response;
        }
    }

    function getRawResponse(){
        if(!empty($this->error))
            return false;
        else
            return $this->response;
    }

    function getError(){
        return $this->error;
    }
}

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