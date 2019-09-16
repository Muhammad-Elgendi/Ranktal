<?php

namespace App\Core;
require 'vendor/autoload.php';

// $proxy = ProxyProvider::getParsedPubProxy();
// var_dump($proxy);


class ProxyProvider{

    public function __construct(){
     
    }

    /**
     * @http://spys.one/en/
     * @https://github.com/clarketm/proxy-list
     */
    public static function getSpysMeProxy(){
        $ch = curl_init("http://spys.me/proxy.txt");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1");
        
        $response = curl_exec($ch);
        $lines = explode("\n", $response);
        $proxies = [];
        foreach($lines as $line){
            if(substr_count($line,".") == 3 && substr_count($line,":") == 1){
                $proxies[]= $line;
            }
        }
        return $proxies;
    }

    public static function getParsedSpysMeProxy(){
        $parsedProxies = [];
        $proxies = ProxyProvider::getSpysMeProxy();
        foreach($proxies as $item){
            $proxy =[];
            $spaceSplited = explode(' ',$item);
            $proxy['proxy'] = $spaceSplited[0];
            $proxy['country'] = explode('-',$spaceSplited[1])[0];
            $proxy['google_pass'] = $spaceSplited[2] == "+";

            $parsedProxies[] = $proxy;
        }
        return $parsedProxies;
    }

    /**
     * @http://pubproxy.com
     * @https://github.com/clarketm/proxy-list
     */
    public static function getPubProxy(){
        // This api returns only 5 google passed proxies for each request (tested @ 15/9/2019)
        $ch = curl_init("http://pubproxy.com/api/proxy?limit=20&google=true");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1");
        
        $response = curl_exec($ch);
        $json = json_decode($response);

        return $json->data;
    }

    public static function getParsedPubProxy(){
        $parsedProxies = [];
        $proxies = ProxyProvider::getPubProxy();
        foreach($proxies as $item){
            $proxy =[];
            $proxy['proxy'] = $item->ipPort;
            $proxy['country'] = $item->country;
            $proxy['google_pass'] = $item->support->google == 1;
            $parsedProxies[] = $proxy;
        }
        return $parsedProxies;
    }

}