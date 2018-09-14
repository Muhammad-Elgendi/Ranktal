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

$class_methods = get_class_methods($p);

foreach ($class_methods as $method_name) {
    if($method_name != "__construct")
        $p->$method_name();
}

var_dump(get_object_vars($p));


 class PageOptimization{

     //TODO use parse_url once and deal with NULL if component is not existed

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
    
    //Use Keywords in your URL
    public $isKeywordInUrl;

    //Optimal Use of Keywords in Header Tags
    public $isGoodKeywordInHeader;

    //Keywords in Image Alt Attribute
    public $isKeywordInAlt;

    //Avoid Too Many External Links
    public $isManyExternal;

    //Avoid Too Many Internal Links
    public $isManyInternal;

    //Use Static URLs
    public $isStaticUrl;

    //URL Uses Only Standard Characters
    public $useStandardChar;

    //Avoid Keyword Stuf ng in the URL
    public $isKeywordStuffUrl;

    //Minimize URL Length
    public $isGoodUrlLength;

    function __construct($url,$keyword){
        $this->url = $url;
        $this->keyword = $keyword;
        $this->connectPage();
        $this->isAccessible = ($this->httpCode == 200) && $this->isAllowedFromRobots() && $this->isAllowedFromPage();
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

    private function isAllowedFromRobots(){
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

    private function get_headers_into_array($header_text) { 
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

    private function isAllowedFromPage(){        
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
        $metas=$doc->getElementsByTagName('head')->item(0)->getElementsByTagName('meta');
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
        $links=$doc->getElementsByTagName('head')->item(0)->getElementsByTagName('link');
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

    public function setTitleChecks(){
        $doc = new \DOMDocument();
		libxml_use_internal_errors(true);
		$doc->loadHTML($this->doc);
		libxml_use_internal_errors(false);
        $titles=$doc->getElementsByTagName('head')->item(0)->getElementsByTagName('title');
        $firstTitle = $titles->item(0)->nodeValue;
        $this->isKeywordStuffTitle = substr_count ( $firstTitle, $this->keyword ) > 2;
        $this->isMultiTitle =  $titles->length > 1;
        $this->isBroadKeywordTitle = stripos ( $firstTitle , $this->keyword ) === 0 ;
        $this->isGoodTitleLength = mb_strlen($firstTitle,'utf8') <= 60;
        $this->isKeywordInTitle = stripos($this->keyword,$firstTitle) !== false  ;      
    }

    public function setContentChecks(){
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

    public function setUrlChecks(){
        $this->isKeywordInUrl = stripos($this->keyword,$this->url) !== false  ;
        $this->isStaticUrl = empty(parse_url($this->url, PHP_URL_QUERY));
        $matchNonStandard = preg_match_all("/([^a-zA-Z\d\s,!.#+-:&])+/", $this->url, $output_array);
        $this->useStandardChar = empty($output_array[0]);
        $this->isKeywordStuffUrl = substr_count ( $this->url, $this->keyword ) > 1;
        $path = parse_url($this->url, PHP_URL_PATH);
        $formattedPath = rtrim($path, '/');
        $folder_depth = substr_count($formattedPath , "/");
        $this->isGoodUrlLength = mb_strlen($this->url,'utf8') < 75 && $folder_depth < 4;
    }

    public function setHeaderChecks(){
        $doc = new \DOMDocument();
		libxml_use_internal_errors(true);
		$doc->loadHTML($this->doc);
		libxml_use_internal_errors(false);
        $heading1=$doc->getElementsByTagName('body')->item(0)->getElementsByTagName('h1');
        if($heading1->length != 0){
            $countOfUse = 0;
            foreach($heading1 as $tag){
                if(stripos ( $tag , $this->keyword ) === 0){
                    $countOfUse++;                   
                }
            }
            $this->isGoodKeywordInHeader = $countOfUse < 3;
        }
        else{
            $this->isGoodKeywordInHeader = false;
        }
    }

    public function setImagesChecks(){
        $doc =new \DOMDocument();
		libxml_use_internal_errors(true);
		$doc->loadHTML($this->doc);
		libxml_use_internal_errors(false);
        $imageElements=$doc->getElementsByTagName('body')->item(0)->getElementsByTagName('img');
        $this->isKeywordInAlt = false ;
        if($imageElements->length != 0){            
            foreach($imageElements as $tag){
                if(stripos ( $tag->getAttribute('alt') , $this->keyword ) !== false){
                  $this->isKeywordInAlt = true ;
                  return;                   
                }
            }            
        }       
    }
    
    public function setDescriptionChecks(){

    }

    private function isExternal($url,$host) {
        $site = parse_url($url, PHP_URL_HOST);
        // we will treat url like '/relative.php' as relative
        if ( empty($site) ) return false;
        // url host looks exactly like the local host
        if ( strcasecmp($site, $host) === 0 ) return false; 
        // check if the url host is a subdomain
        return strrpos(strtolower($site), '.'.$host) !== strlen($site) - strlen('.'.$host);      
    }

    public function setLinksChecks(){
        $doc =new \DOMDocument();
		libxml_use_internal_errors(true);
		$doc->loadHTML($this->doc);
		libxml_use_internal_errors(false);
        $ahrefs=$doc->getElementsByTagName('body')->item(0)->getElementsByTagName('a');
        if($ahrefs->length != 0){
            $host = parse_url($this->url, PHP_URL_HOST);
            $externals = 0;
            foreach($ahrefs as $ahref){
              if($this->isExternal($ahref->getAttribute('href'), $host)){
                $externals++;
              }
            }
            $internals = $ahrefs->length - $externals;
            $this->isManyExternal = $externals > 99;
            $this->isManyInternal = $internals > 99;            
        }
    }
     
 }