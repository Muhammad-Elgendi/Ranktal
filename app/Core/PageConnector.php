<?php

namespace App\Core;
require 'vendor/autoload.php';

/**
 *
 * Developed by :
 * 	Muhammad Elgendi
 * 
 **/


class PageConnector{

    public $url;

    private $isGoodUrl;

    public $parsedUrl;

	public $httpCode;

	public $header;

    public $doc;
    
    public $urlRedirects;

    //TODO : Get URL redirects HTTP status codes

    function __construct($url){
        $this->url=rawurldecode($url);	
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
    
    public function isGoodUrl(){
        if(!isset($this->isGoodUrl)){
            $this->isGoodUrl = filter_var($this->url, FILTER_VALIDATE_URL);          
        }
        return $this->isGoodUrl;
    }

	public function connectPage(){        
        if(!$isGoodUrl){
            return;
        }
        $this->parsedUrl = parse_url($this->url);        
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
    
    public function setURLRedirects(){
        if (isset($this->header['Location'])) {
            $this->urlRedirects = array_merge($this->urlRedirects,$this->header['Location']);
        }
    }
    
    /**
     * @param $url
     * @return bool|mixed
     */
    public function getRedirectUrlOrFail () {        
        if (isset($this->header ['Location'])) {
            return array_pop($headers['Location']);
        }
        return false;
    }


}