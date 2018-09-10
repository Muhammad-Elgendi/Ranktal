<?php

namespace App\Core;
require 'vendor/autoload.php';

/**
 *
 * Developed by :
 * 	Muhammad Elgendi
 * 
 **/


$p =new PageOptimization("https://lovejinju.net");

var_dump( $p->isAccessible );
var_dump( $p->isAllowedFromRobots() );
var_dump( $p->isAllowedFromPage() );
 class PageOptimization{

    private $url;

    private $httpCode;

    private $header;

    private $doc;
    
    public $isAccessible;

    function __construct($url){
        $this->url = $url;
        $this->connectPage();
        $this->isAccessible = ($this->httpCode != 200) && $this->isAllowedFromRobots() && $this->isAllowedFromPage();   

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

    private function connectPage(){        
        $ch = curl_init($this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        
        $response = curl_exec($ch);
        
        // Then, after your curl_exec call:
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $this->httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);       
        $this->header = substr($response, 0, $header_size);
        $body = substr($response, $header_size);
        $this->doc = $body;       
    }

    public function isAllowedFromPage(){
        foreach (explode("\r\n", $this->header) as $i => $line){
            if($i != 0){
                list ($key, $value) = explode(': ', $line);
                if($key == "X-Robots-Tag"){
                    if(stripos($value,'noindex') !== false || stripos($value,'none') !== false ){                        
                        return false;
                    }
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
        $pathOfUrl = parse_url($this->url, PHP_URL_PATH);
        foreach($links as $link){
            if ($link->getAttribute('rel')=="canonical"){  
                $href = $link->getAttribute('href'); 
                $pathOfCanonical = parse_url($href, PHP_URL_PATH);
                if($pathOfCanonical === $pathOfUrl){          
                    return false;            
                }    
            }               
        }
        return true;
    }

     
 }

