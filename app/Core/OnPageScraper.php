<?php

namespace App\Core;
require 'vendor/autoload.php';

/**
 *
 * Developed by :
 * 	Muhammad Elgendi
 * 
 **/


class OnPageChecks{

    private $doc;

	public $isMultiTitle;

	public $title;

	public $titleLength;

	public $isGoodTitleLength;

	public $isGoodTitle;

	public $url;

	public $urlStatus;

    function __construct(){
	
    }
    
    public function setTitleChecks($html_code){
        $doc = new \DOMDocument;
		libxml_use_internal_errors(true);
		$doc->loadHTML($html_code);
		libxml_use_internal_errors(false);
		$count = $doc->getElementsByTagName('head')->item(0)->getElementsByTagName('title')->length;
		$this->isMultiTitle = $count > 1;		
        $this->title=$doc->getElementsByTagName('head')->item(0)->getElementsByTagName('title')->item(0)->nodeValue;
        $this->titleLength=mb_strlen($this->title,'utf8');
		$this->isGoodTitleLength= $this->titleLength > 10 && $this->titleLength < 60;
		$this->isGoodTitle = isset($this->title) && !$this->multiTitle && $this->isGoodTitleLength;
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

	public function setUrlChecks($url,$status){
		$this->url=rawurldecode($url);
		$this->urlStatus = $status;
		// $this->domain=$this->urlToDomain($this->url);
		// $this->urlLength=mb_strlen($this->url,'utf8');
        // $this->domainLength=mb_strlen($this->domain,'utf8');
		// $this->status=get_headers($this->url,1)[0];
		// $this->google_cache_url='http://google.com/search?q=cache:'.$this->url;
		// $this->count_of_spaces=substr_count($this->url, ' ');
		// $this->isGoodUrlLength = $this->urlLength < 200;
		// $this->isUrlHasSpaces = 	$this->count_of_spaces > 0;	
		// $this->isUrlHasGoodStatus = $status==="200" || $status==="301" ||$status==="404"||$status==="503";
		// $this->isGoodUrl =  $this->isGoodUrlLength && !$this->isUrlHasSpaces && $this->isUrlHasGoodStatus ;
	}








}