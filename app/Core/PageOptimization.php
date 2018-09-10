<?php

namespace App\Core;
require 'vendor/autoload.php';

/**
 *
 * Developed by :
 * 	Muhammad Elgendi
 * 
 **/


$p =new PageOptimization();
$p->isAllowedFromPage('https://lovejinju.net');

 class PageOptimization{

    private $doc;

    function __constructor(){

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

    private function isAllowedFromRobots($url){
        $robots=parse_url($url, PHP_URL_SCHEME).'://'.parse_url($url, PHP_URL_HOST).'/robots.txt';
		$content=$this->makeConnection($robots);
        if($content) {
            $parser = new RobotsTxtParser($content);
            $agents=['*','Googlebot','Bingbot','Slurp','DuckDuckBot','Baiduspider','YandexBot'];            
            foreach($agents as $agent){
                $parser->setUserAgent($agent);         
                if ($parser->isDisallowed(parse_url($url, PHP_URL_PATH))) {
                    return false;
                }
            }
            return true;            
        }else{
            return true;
        }
    }

    // private function get_headers_from_curl_response($response){
    // $headers = array();

    // $header_text = substr($response, 0, strpos($response, "\r\n\r\n"));

    // foreach (explode("\r\n", $header_text) as $i => $line)
    //     if ($i === 0)
    //         $headers['http_code'] = $line;
    //     else
    //     {
    //         list ($key, $value) = explode(': ', $line);

    //         $headers[$key] = $value;
    //     }

    // return $headers;
    // }

    public function isAllowedFromPage($url){
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        
        $response = curl_exec($ch);
        
        // Then, after your curl_exec call:
        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if($httpcode != 200){
            return false;
        }
        $header = substr($response, 0, $header_size);
        foreach (explode("\r\n", $header) as $i => $line){
            if($i != 0){
                list ($key, $value) = explode(': ', $line);
                if($key == "X-Robots-Tag"){
                    if(stripos($value,'noindex') !== false || stripos($value,'none') !== false ){
                        return false;
                    }
                }    
            }
        }       
        $body = substr($response, $header_size);
        $this->doc = new \DOMDocument;
        libxml_use_internal_errors(true);
        $this->doc->loadHTML($body);
        libxml_use_internal_errors(false);
        // $body=$this->doc->getElementsByTagName('body')->item(0);
        // var_dump($body);

        //meta robots 
        //meta refresh
        //meta canonical URL
    }
     
 }

