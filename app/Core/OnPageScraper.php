<?php

namespace App\Core;
require 'vendor/autoload.php';

/**
 *
 * Developed by :
 * 	Muhammad Elgendi
 * 
 **/


class OnPageScraper{	
	
	private $parsedUrl;

	private $httpCode;

	private $header;

	private $doc;

	public $isMultiTitle;

	public $title;

	public $url;

	public $urlStatus;

	public $description;

	public $contentType;

	public $charset;

	public $viewport;

	public $robotsMeta;

	public $isMultiDescription;

	public $xRobots;

	public $refreshMeta;

	public $refreshHeader;

	public $canonical;

    function __construct($url){
		$this->url = $url;
	}
	
	private function connectPage(){
        $parsedUrl = parse_url($this->url);
        if(!$parsedUrl){
            return;
        }
        $this->parsedUrl = $parsedUrl;        
        $ch = curl_init($this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        
        $response = curl_exec($ch);
        
        // Then, after your curl_exec call:
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $this->httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); 
        $header = substr($response, 0, $header_size);      
        $this->header = $this->get_headers_into_array($header);
        $body = substr($response, $header_size);
        $this->doc = $body;       
    }
    
    public function getTitleAttr(){
        $doc = new \DOMDocument;
		libxml_use_internal_errors(true);
		$doc->loadHTML($this->doc);
		libxml_use_internal_errors(false);
		$count = $doc->getElementsByTagName('head')->item(0)->getElementsByTagName('title')->length;
		$this->isMultiTitle = $count > 1;		
        $this->title=$doc->getElementsByTagName('head')->item(0)->getElementsByTagName('title')->item(0)->nodeValue;
	}

	public function getUrlAttr(){
		$this->url=rawurldecode($this->url);
		$this->urlStatus = $this->httpCode;
	}

	public function getMetaAttr(){
		$doc = new \DOMDocument;
		libxml_use_internal_errors(true);
		$doc->loadHTML($this->doc);
		libxml_use_internal_errors(false);		
		$items = $doc->getElementsByTagName('head')->item(0)>getElementsByTagName('meta');
		$usesDescription=0;		
		foreach ($items as $item) {
			if ($item->getAttribute('name') == 'description'){
				$usesDescription++;
				if($usesDescription == 1){
					$this->description = $item->getAttribute('content');
				}
			}
			if ($item->getAttribute('http-equiv') == 'Content-Type'){				
				$this->contentType = $item->getAttribute('content');
				$this->charset = $item->getAttribute('charset');				
			}
			if ($item->getAttribute('name') == 'viewport'){				
				$this->viewport = $item->getAttribute('content');
			}
			if ($item->getAttribute('name') == 'robots'){				
				$this->robotsMeta = $item->getAttribute('content');
			}
			if ($meta->getAttribute('http-equiv')=="refresh"){
                $this->refreshMeta = $meta->getAttribute('content');                
            }    	
		}
		$this->isMultiDescription = $usesDescription > 1;
	}

	public function getHeaderAttr(){
		if(isset($this->header['X-Robots-Tag'])){
			$this->xRobots = '';
            foreach($this->header['X-Robots-Tag'] as $value){
                $this->xRobots +=' '.$value; 
            }
		}
		if(isset($this->header['Refresh'])){
			$this->refreshHeader ='';
            foreach($this->header['Refresh'] as $value){
				$this->refreshHeader +=' '.$value;   
            }
        }
	}

	public function getCanonicalAttr(){
		$doc = new \DOMDocument;
		libxml_use_internal_errors(true);
		$doc->loadHTML($this->doc);
		libxml_use_internal_errors(false);		
		$items = $doc->getElementsByTagName('head')->item(0)->getElementsByTagName('link');
		foreach ($items as $item) {
			if ($item->getAttribute('rel') == 'canonical' && !empty($item->getAttribute('href'))){			    
                $this->canonical = $item->getAttribute('href');
        	    break;
        	}
		}
	}








}