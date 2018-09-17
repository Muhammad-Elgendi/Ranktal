<?php

namespace App\Core;
require 'vendor/autoload.php';

/**
 *
 * Developed by :
 * 	Muhammad Elgendi
 * 
 **/


class OnPageChecker{

//Title
    public $isMultiTitle;

    public $title;
    
    public $isTitleExist;

	public $titleLength;

	public $isGoodTitleLength;

    public $isGoodTitle;
//Url    
    public $url;

    public $urlStatus;
    
    public $domain;

    public $urlLength;

    public $domainLength;

    public $google_cache_url;

    public $countSpacesInUrl;

    public $isGoodUrlLength;

    public $isUrlHasSpaces;

    public $isUrlHasGoodStatus;

    public $isGoodUrl;
//Meta
    public $description;

	public $contentType;

	public $charset;

	public $viewport;

	public $robotsMeta;

	public $isMultiDescription;

	public $xRobots;

	public $refreshMeta;

    public $refreshHeader;
    
    public $isDescriptionExist;

    public $descriptionLength; 

    public $isGoodDescriptionLength;

    public $isGoodDescription;

    public $isViewportExist;

    public $isMetaContentTypeExist;

    function __construct($json){
        $obj = json_decode($json);
        foreach($obj as $key => $value) {
            $this->$key = $value;
       }
    }
    
    public function setTitleChecks(){
        $this->isTitleExist = !empty($this->title);		
        $this->titleLength=mb_strlen($this->title,'utf8');
		$this->isGoodTitleLength= $this->titleLength > 10 && $this->titleLength < 60;
		$this->isGoodTitle = $this->isTitleExist && !$this->multiTitle && $this->isGoodTitleLength;
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

    public function setUrlChecks(){
		$this->domain=$this->urlToDomain($this->url);
		$this->urlLength=mb_strlen($this->url,'utf8');
        $this->domainLength=mb_strlen($this->domain,'utf8');
		$this->google_cache_url='http://google.com/search?q=cache:'.$this->url;
		$this->countSpacesInUrl=substr_count($this->url, ' ');
		$this->isGoodUrlLength = $this->urlLength < 200;
		$this->isUrlHasSpaces = $this->countSpacesInUrl > 0;	
		$this->isUrlHasGoodStatus = $this->urlStatus===200 || $this->urlStatus===301 ||$this->urlStatus===404 || $this->urlStatus===503;
		$this->isGoodUrl =  $this->isGoodUrlLength && !$this->isUrlHasSpaces && $this->isUrlHasGoodStatus ;
    }

    public function setMetaChecks(){        
        $this->isDescriptionExist=!empty($this->description);
        $this->descriptionLength=mb_strlen($this->description, 'utf8'); 
        $this->isGoodDescriptionLength  =  $this->descriptionLength > 70 &&  $this->descriptionLength < 160;
        $this->isGoodDescription = $this->isGoodDescriptionLength && $this->isDescriptionExist && !$this->isMultiDescription;
        $this->isViewportExist=!empty($this->viewport);
        $this->isMetaContentTypeExist = !empty($this->contentType) && !empty($this->charset);
    }

    //TODO setAccessabilty checks robots+xrobots + meta refresh + refresh header + canonical URL
}