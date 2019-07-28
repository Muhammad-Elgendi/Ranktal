<?php

namespace App\Core;
require 'vendor/autoload.php';

/**
 *
 * Developed by :
 * 	Muhammad Elgendi
 * 
 **/


class PageChecker{

	private $parsedUrl;

	private $httpCode;
//Title
    public $isMultiTitle;

    public $title;
    
    public $isTitleExist;

	public $titleLength;

	public $isGoodTitleLength;

    public $isGoodTitle;
//Url    
    public $url;
 
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
//Page
	public $canonical;

	public $ratio;

	public $language;

    public $docType;
    
    public $isCanonicalExist;

    public $isGoodTextHtmlRatio;

    public $isLanguageExist;

    public $isDocTypeExist;
//Headers
    public $h1;

    public $h2;

    public $h3;

    public $h4;

    public $h5;

    public $h6;

    public $isMultiH1;

    public $isGoodHeader;
//Images
    public $alt;

    public $emptyAlt;

    public $isGoodImg;
//Checks
    public $ampLink;

    public $openGraph;

    public $twitterCard;

    public $framesCount;

    public $bItems;

    public $iItems;

    public $emItems;

    public $strongItems;

    public $markItems;

    public $isFlashExist;

    public $links;

    public $isAllowedFromRobots;

    public $isAccessible;

    public $isFrameExist;

    public $isAmpCopyExist;

    public $isOpenGraphExist;

    public $isTwitterCardExist;

    public $isFormattedTextExist;
    

    function __construct($obj){
        foreach($obj as $key => $value) {
            if(property_exists($this, $key)){
                $this->$key = $value;
            }
       }
    }
    
    public function setTitleChecks(){
        $this->isTitleExist = !empty($this->title);		
        $this->titleLength=mb_strlen($this->title,'utf8');
		$this->isGoodTitleLength= $this->titleLength > 10 && $this->titleLength < 60;
		$this->isGoodTitle = $this->isTitleExist && !$this->isMultiTitle && $this->isGoodTitleLength;
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
		$this->isUrlHasGoodStatus = $this->httpCode===200 || $this->httpCode===301 ||$this->httpCode===404 || $this->httpCode===503;
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

    public function setPagechecks(){
        $this->isCanonicalExist = !empty($this->canonical);
        $this->isGoodTextHtmlRatio = $this->ratio > 25 && $this->ratio < 70;
        $this->isLanguageExist = !empty($this->language);
        $this->isDocTypeExist = !empty($this->docType);
    }

    private function getCountIfArray($var){
        return is_array($var) ? count($var) : 0 ;        
    }

    public function setHeadersChecks(){
        $countH1 = $this->getCountIfArray($this->h1);
        $this->isMultiH1 = $countH1 > 1;
        $this->isGoodHeader = $countH1 > 0 && $this->getCountIfArray($this->h2) > 0 && $this->getCountIfArray($this->h3) > 0;
    }

    public function setImagesChecks(){
        $countAlt = $this->getCountIfArray($this->alt);
        $countEmptyAlt = $this->getCountIfArray($this->emptyAlt);
        $this->isGoodImg = ($countAlt+$countEmptyAlt) > 0 && $countEmptyAlt === 0;
    }

    public function setChecks(){
        $this->isFrameExist=$this->framesCount > 0;     
        $this->isAmpCopyExist=!empty($this->ampLink);
        $this->isOpenGraphExist=!empty($this->openGraph);
        $this->isTwitterCardExist=!empty($this->twitterCard);  
        $this->isFormattedTextExist=!empty($this->bItems) || !empty($this->iItems) || !empty($this->emItems) || !empty($this->strongItems) || !empty($this->markItems);
    }

    private function isAllowedFromPage(){
        if(!empty($this->xRobots)){
            if(stripos($this->xRobots,'noindex') !== false || stripos($this->xRobots,'none') !== false ){                        
                return false;
            }
        }
        if(!empty($this->robotsMeta)){
            if(stripos($this->robotsMeta,'noindex') !== false || stripos($this->robotsMeta,'none') !== false ){                        
                return false;
            }
        }
        if(!empty($this->refreshHeader)){
            if(stripos($this->refreshHeader,'url=') !== false){                        
                return false;
            } 
        }
        if (!empty($this->refreshMeta)){  
            if(stripos($this->refreshMeta,'url=') !== false){                        
                return false;
            } 
        }
        $pathOfUrl =  isset($this->parsedUrl["path"]) ? $this->parsedUrl["path"] : '/';
        $pathOfCanonical = parse_url($this->canonical, PHP_URL_PATH);
        if($pathOfCanonical !== $pathOfUrl){          
            return false;            
        }
        return true;
    }

    public function setAccessabiltyChecks(){
        $this->isAccessible = ($this->httpCode == 200) && $this->isAllowedFromRobots && $this->isAllowedFromPage();
    }
}