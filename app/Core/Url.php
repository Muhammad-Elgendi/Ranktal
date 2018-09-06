<?php
namespace App\Core;

/**
 *
 * Developed by :
 * 	Muhammad Elgendi
 *
 * -Capabilities   -Properties           -Return-type   Type      -Column-name
 *
 * 	-Decoded Url       -url              -string        field
 *  -Domain name       -domain           -string        field
 *  -Domain length     -domainLength     -integer       field
 * 	-length of Url     -urlLength        -integer       field     -lengthUrl
 * 	-status of Url     -status           -string        field     -statusUrl
 * 	-google_cache_url  -google_cache_url -string        field     -googleCacheUrl
 * 	-count_of_spaces   -count_of_spaces  -integer       field     -spacesUrl
 *  -check length      -check_length     -boolean       function  -checkLengthUrl
 *  -check spaces      -check_spaces     -boolean       function  -checkSpacesUrl
 *  -check status      -check_status     -boolean       function  -checkStatusUrl
 * 	-make final check  -check            -boolean       function  -checkUrl
 *
 * Ideas :
 *  use trim() to remove any thing from the beginning and ending of the url
 *
 **/

class Url{

    /**
     * holds the url of page
     * @var string
     */
	public $url;

    /**
     * holds the length of the URL
     * @var int
     */
    public $urlLength;

    /**
     * holds the domain name of the site
     * @var string
     */
	public $domain;

    /**
     * holds the length of the Domain name
     * @var int
     */
    public $domainLength;

    /**
     * holds the status of http response
     * @var string
     */
	public $status;

    /**
     * holds the cache URL of the Page
     * @var string
     */
	public $google_cache_url;

    /**
     * holds the count of spaces
     * @var int
     */
	public $count_of_spaces;

    /**
     * Url constructor.
     * @param $url
     */
	function __construct($url){

        /**
         * setting data fields
         */
		$this->url=rawurldecode($url);
		$this->domain=$this->urlToDomain($this->url);
		$this->urlLength=mb_strlen($this->url,'utf8');
        $this->domainLength=mb_strlen($this->domain,'utf8');
		$this->status=get_headers($this->url,1)[0];
		$this->google_cache_url='http://google.com/search?q=cache:'.$this->url;
		$this->count_of_spaces=substr_count($this->url, ' ');		
	}

    /**
     * check the length of URL
     * @return bool
     */
	function check_length(){
		if(($this->urlLength)>200){
        	return false;
    	}
    	else
    		return true;
	}

    /**
     * check the count of spaces in the URL
     * @return bool
     */
	function check_spaces(){
		if(($this->count_of_spaces)>0){			
        	return false;
		}
		else
			return true;
	}

    /**
     * Check the HTTP status of the response
     * @return bool
     */
	function check_status(){
		$status_code = substr($this->status, 9, 3);
		if($status_code==="200" | $status_code==="301" |$status_code==="404"|$status_code==="503"){
			return true;
		}
		else			
			return false;		
	}

    /**
     * Doing a full check to the URL
     * @return bool
     */
	function check(){
		if( $this->check_length() & $this->check_spaces() & $this->check_status() )
			return true;
		else
			return false;
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
}