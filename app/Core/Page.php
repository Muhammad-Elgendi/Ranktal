<?php

namespace App\Core;
require 'vendor/autoload.php';
use GeoIp2\Database\Reader;

/**
 *
 * Developed by :
 * 	Muhammad Elgendi
 *
 * * Note :
 * all get calls can now access publicly from the outside
 *
 * -Capabilities               -Return-type   Type      -Column-name
 *
 * 	-get('canonical')          -string        function  -canonical
 *  -get('language')           -string        function  -language
 *  -get('docType')            -string        function  -docType
 * 	-get('encoding')           -string        function  -encoding
 *  -get('country')            -string        function  -country
 *  -get('city')               -string        function  -city
 *  -get('IpAddress')          -string        function  -IpAddress
 *  -checkTextHtmlRatio()      -boolean       function  -checkTextHtmlRatio
 *  -hasCanonical              -boolean       field
 *  -ratio                     -float         field
 *  -hasLanguage               -boolean       field
 *  -hasDocType                -boolean       field
 *  -hasEncoding               -boolean       field
 *  -hasCountry                -boolean       field
 *  -hasCity                   -boolean       field
 *  -hasIpAddress              -boolean       field
 *
 **/

class Page{

    /**
     * @var string
     */
	public $canonical;

    /**
     * @var bool
     */
	public $hasCanonical=false;

    /**
     * @var float
     */
	public $ratio;

    /**
     * @var string
     */
	private $url;

    /**
     * @var string
     */
	public $language;

    /**
     * @var bool
     */
	public $hasLanguage=false;

    /**
     * holds the html of page
     * @var string
     */
	private $html;

    /**
     * holds docType if was found
     * @var
     */
	public $docType;

    /**
     * flag to indicate if we could get docType successfully
     * @var bool
     */
	public $hasDocType;

    /**
     * holds encoding if was found
     * @var
     */
	public $encoding;

    /**
     * flag to indicate if we could get Encoding successfully
     * @var bool
     */
	public $hasEncoding=false;

    /**
     * flag to indicate if we could get Country successfully
     * @var bool
     */
    public $hasCountry=false;

    /**
     * holds country if was found
     * @var string
     */
	public $country;

    /**
     * flag to indicate if we could get city successfully
     * @var bool
     */
    public $hasCity=false;

    /**
     * holds city if was found
     * @var string
     */
	public $city;

    /**
     * @var string
     * holds Ip address if was found
     */
    public $IpAddress;

    /**
     * @var bool
     * flag to indicate if we could get ip successfully
     */
    public $hasIpAddress;

    /**
     * Page constructor.
     * @param $url
     * @param $html
     */
	function __construct($url,$html){
		$this->url=$url;
		$this->html=$html;
		$this->setCanonical();
		$this->setTextHtmlRatio();
		$this->setLanguage();
		$this->setDocType();
		$this->setEncoding();
		$this->setIpAddress();
        $this->setLocation();
	}

    /**
     * Sets canonical and hasCanonical if was found
     */
	private function setCanonical(){
		$doc = new \DOMDocument;
		libxml_use_internal_errors(true);
		$doc->loadHTML($this->html);
		libxml_use_internal_errors(false);		
		$items = $doc->getElementsByTagName('head')->item(0)->getElementsByTagName('link');
		foreach ($items as $item) {
			if ($item->getAttribute('rel') == 'canonical' && !empty($item->getAttribute('href'))){
			    $this->hasCanonical=true;
                $this->canonical = $item->getAttribute('href');
        	    break;
        	}
		}
	}

    /**
     * set the TextToHtmlRatio
     * using:
     *  strip_tags -get the text out of code
     *  filesize — Gets file size
     *  strlen() returns the number of bytes rather than the number of characters in a string.
     */
	private function setTextHtmlRatio(){

		$text=strip_tags($this->html);
		$filesize=strlen($this->html);
		$textsize=strlen($text);
		$this->ratio=round((($textsize/$filesize)*100), 2);
	}

    /**
     * check the text to HTML ratio
     * A good text to HTML ratio is anywhere from 25 to 70 percent
     * @return bool
     */
	function checkTextHtmlRatio(){

		if((($this->ratio)>25)&(($this->ratio)<70))
			return true;
		else
    		return false;
	}

    /**
     * Extract language from the following tag
     * <html dir="rtl" lang="ar" prefix="og: http://ogp.me/ns#">
     */
	private function setLanguage(){
		$doc = new \DOMDocument;
		libxml_use_internal_errors(true);
		$doc->loadHTML($this->html);
		libxml_use_internal_errors(false);
		if($doc->getElementsByTagName('html')->item(0)->getAttribute('lang')) {
            $this->language = $doc->getElementsByTagName('html')->item(0)->getAttribute('lang');
            $this->hasLanguage=true;
        }
	}

    /**
     * Old Version Notes :
     * Alert !: if <!DOCTYPE > is placed like this into page class doesn't work
     * and gives 502 Bad Gateway
     * Error is in $docTypeName = $doc->doctype->name; line (solved for now)
     *
     * sets the doctype
     */
	private function setDocType(){
		$doc = new \DOMDocument();
		libxml_use_internal_errors(true);
		$doc->loadHTML($this->html);
		libxml_use_internal_errors(false);
		if(stripos($this->html,'<!DOCTYPE HTML') === false){
		    $this->hasDocType=false;
			return;
		}
		$docPublicId=$doc->doctype->publicId;	
		$docTypeNameOld=preg_replace('~.*//DTD(.*?)//.*~', '$1', $docPublicId);		
		if(empty($docTypeNameOld)) {
            $this->docType = 'HTML 5';
            $this->hasDocType = true;
        }
		else{
			$this->docType=$docTypeNameOld;
            $this->hasDocType=true;
		}
	}

    /**
     * set Encoding that was found in page
     *
     * <head>
     * <meta charset="utf-8">
     * </head>
     */
	private function setEncoding(){
		$doc = new \DOMDocument;
		libxml_use_internal_errors(true);
		$doc->loadHTML($this->html);
		libxml_use_internal_errors(false);		
		$items = $doc->getElementsByTagName('head')->item(0)
		->getElementsByTagName('meta');
		foreach ($items as $item) {
			if ($item->getAttribute('charset')){ 
                $this->encoding = $item->getAttribute('charset');
                $this->hasEncoding=true;
        	    break;
        	}
		}
	}

    /**
     * sets ipAddress of page
     */
	private function setIpAddress(){
		$hostname=parse_url($this->url, PHP_URL_HOST);
		$IP = gethostbyname($hostname);
		if($hostname !== $IP){
		    $this->IpAddress=$IP;
		    $this->hasIpAddress=true;
        }
        else
            $this->hasIpAddress=false;
	}

    /**
     * sets Location of page
     */
	private function setLocation(){
	    if(isset($this->IpAddress)) {
            $reader = new Reader(app_path().'/Core/GeoIP/GeoLite2-City.mmdb');
            try {
                $record = $reader->city($this->IpAddress);
                $this->country = $record->country->name;
                $this->city = $record->city->name;
                $this->hasCountry = true;
                $this->hasCity = true;
            } catch (\Exception $e) {
                return;
            }
        }
	}
}