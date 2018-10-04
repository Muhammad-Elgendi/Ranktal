<?php

namespace App\Core;
require 'vendor/autoload.php';

/**
 *
 * Developed by :
 * 	Muhammad Elgendi
 * 
 **/

// $p =new PageConnector("http://lovejinju.net");
// $class_methods = get_class_methods($p);

// foreach ($class_methods as $method_name) {
//     if($method_name != "__construct")
//         $p->$method_name();
// }

// // echo end($p->httpCodes);

// // var_dump($p->httpCodes);

// var_dump(get_object_vars($p));


class PageConnector{

    public $url;

    public $isGoodUrl;

    public $isGoodStatus;

    public $httpCodes;
    
    public $urlRedirects;

    public $parsedUrl;

	public $header;

    public $doc;

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

	public function connectPage($url =null){  
        if($url != null){
            $this->url = $url;
        }
        $this->isGoodUrl = !empty(filter_var($this->url, FILTER_VALIDATE_URL));       
        if(!$this->isGoodUrl){
            return;
        }
        $this->urlRedirects[] = $this->url;      
               
        $ch = curl_init($this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        
        $response = curl_exec($ch);
        
        // Then, after your curl_exec call:
        
        $this->httpCodes[] = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $redirect = curl_getinfo($ch, CURLINFO_REDIRECT_URL);   
        if(!empty($redirect)){
            $this->connectPage($redirect); 
            return;
        }
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $header = substr($response, 0, $header_size);      
        $this->header = $this->get_headers_into_array($header);
        $body = substr($response, $header_size);
        $this->doc = $body; 
        $this->parsedUrl = parse_url($this->url);       
    }

    public function setIsGoodStatus(){
        foreach($this->httpCodes as $httpCode){
            if(!($httpCode===200 || $httpCode===301 || $httpCode===404 || $httpCode===503)){
                $this->isGoodStatus =false;
                return;
            }
        }
        $this->isGoodStatus = true;
    }
    
}