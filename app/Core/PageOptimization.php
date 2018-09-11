<?php

namespace App\Core;
require 'vendor/autoload.php';

/**
 *
 * Developed by :
 * 	Muhammad Elgendi
 * 
 **/


$p =new PageOptimization("https://lovejinju.net",'متجري');
var_dump(get_object_vars($p));


 class PageOptimization{

    private $url;

    private $httpCode;

    public $header;

    private $doc;

    private $keyword;

    //Accessible to Search Engines
    public $isAccessible;    

    //Avoid Keyword Stuffing in Page Title
    public $isKeywordStuffTitle;

    //Avoid Multiple Page Title Elements
    public $isMultiTitle;

    //Only One Canonical URL
    public $isOneCanonical;

    //Broad Keyword Use in Page Title
    public $isBroadKeywordTitle;

    //Optimal Page Title Length
    public $isGoodTitleLength;

    //Exact Keyword is Used in Page Title
    public $isKeywordInTitle;

    //Exact Keyword Used in Document at Least Once
    public $isExactKeywordInDoc;

    //Avoid Keyword Stuffing in Document
    public $isKeywordStuffDoc;

    //Sufficient Characters in Content
    public $isSufficientCharInContent;

    //Sufficient Words in Content
    public $isSufficientWordsInContent;
    



    function __construct($url,$keyword){
        $this->url = $url;
        $this->keyword = $keyword;
        $this->connectPage();
        $this->isAccessible = ($this->httpCode == 200) && $this->isAllowedFromRobots() && $this->isAllowedFromPage();
        $this->setTitleChecks();
        $this->setContentChecks();   

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

    private function getRobots(){
        $robotsUrl=parse_url($this->url, PHP_URL_SCHEME).'://'.parse_url($this->url, PHP_URL_HOST).'/robots.txt';
        $content=$this->makeConnection($robotsUrl);
        if($content) {            
            return $content;            
        }else{
            return false;
        }
    }  

    public function isAllowedFromRobots(){
        $robotsContent = $this->getRobots();
		if($robotsContent) {
            $parser = new \RobotsTxtParser($robotsContent);
            $agents=['*','Googlebot','Bingbot','Slurp','DuckDuckBot','Baiduspider','YandexBot'];
            $pathToPage = parse_url($this->url, PHP_URL_PATH);            
            foreach($agents as $agent){
                $parser->setUserAgent($agent);         
                if ($parser->isDisallowed($pathToPage)) {
                    return false;
                }
            }
            return true;            
        }else
            return true;        
    }

    public function get_headers_into_array($header_text) { 
        $headers = array();
        foreach (explode("\r\n", $header_text) as $i => $line) 
             if ($i !== 0 && !empty($line)){ 
                  list ($key, $value) = explode(': ', $line);
                  $headers[$key][] = $value; 
             } 
        return $headers; 
    }

    private function connectPage(){        
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

    public function isAllowedFromPage(){        
        if(isset($this->header['X-Robots-Tag'])){
            foreach($this->header['X-Robots-Tag'] as $value){
                if(stripos($value,'noindex') !== false || stripos($value,'none') !== false ){                        
                    return false;
                }
            }
        }
        $doc = new \DOMDocument();
		libxml_use_internal_errors(true);
		$doc->loadHTML($this->doc);
		libxml_use_internal_errors(false);
        $metas=$doc->getElementsByTagName('meta');
        foreach($metas as $meta){
            if ($meta->getAttribute('name')=="robots"){
                $content = $meta->getAttribute('content');
                if(stripos($content,'noindex') !== false || stripos($content,'none') !== false ){         
                    return false;                    
                }
            }
            if ($meta->getAttribute('http-equiv')=="refresh"){
                $content = $meta->getAttribute('content');
                if(!empty($content) ){
                    return false;
                }
            }   
        }
        $links=$doc->getElementsByTagName('link');
        $canonicalCount = 0;
        $pathOfUrl = parse_url($this->url, PHP_URL_PATH);
        foreach($links as $link){
            if ($link->getAttribute('rel')=="canonical"){
                $canonicalCount++;
                $href = $link->getAttribute('href'); 
                $pathOfCanonical = parse_url($href, PHP_URL_PATH);
                if($pathOfCanonical === $pathOfUrl){          
                    return false;            
                }    
            }               
        }
        $this->isOneCanonical = $canonicalCount == 1;
        return true;
    }

    private function setTitleChecks(){
        $doc = new \DOMDocument();
		libxml_use_internal_errors(true);
		$doc->loadHTML($this->doc);
		libxml_use_internal_errors(false);
        $titles=$doc->getElementsByTagName('title');
        $firstTitle = $titles->item(0)->nodeValue;
        $this->isKeywordStuffTitle = substr_count ( $firstTitle, $this->keyword ) > 2;
        $this->isMultiTitle =  $titles->length > 1;
        $this->isBroadKeywordTitle = stripos ( $firstTitle , $this->keyword ) === 0 ;
        $this->isGoodTitleLength = mb_strlen($firstTitle,'utf8') <= 60;
        $this->isKeywordInTitle = strpos($this->keyword,$firstTitle) !== false  ;      
    }

    private function setContentChecks(){
        $countOfKeywordInDoc = substr_count ( $this->doc, $this->keyword );
        $this->isExactKeywordInDoc = $countOfKeywordInDoc > 1;
        $this->isKeywordStuffDoc = $countOfKeywordInDoc > 15;
        $doc = new \DOMDocument();
		libxml_use_internal_errors(true);
		$doc->loadHTML($this->doc);
		libxml_use_internal_errors(false);
        $body=$doc->getElementsByTagName('body')->item(0)->nodeValue;
        $countOfBodyNoSpaces =  mb_strlen($body,'utf8') - substr_count($body, ' ');
        $this->isSufficientCharInContent = $countOfBodyNoSpaces >= 300;
        $word_count = str_word_count($body, 0);
        $this->isSufficientWordsInContent = $word_count >= 50;


    }

    private function setKeywordsChecks(){

    }

     
 }