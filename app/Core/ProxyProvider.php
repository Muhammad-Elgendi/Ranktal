<?php

namespace App\Core;
require 'vendor/autoload.php';

// $proxy = ProxyProvider::getParsedPubProxy();
// var_dump($proxy);


class ProxyProvider{

    public function __construct(){
     
    }

    /** 
     * Other sources
     * https://www.proxyrotator.com/free-proxy-list/
     * http://proxydb.net/?anonlvl=4&min_uptime=75&max_response_time=5&country=
     * https://proxy-daily.com/
     * https://www.proxy-list.download/HTTP
     * https://www.proxy-list.download/HTTPS
     * https://www.proxy-list.download/SOCKS4
     * https://www.proxy-list.download/SOCKS5
     * http://free-proxy.cz/en/proxylist/country/all/all/speed/level1
     * http://nntime.com/
     * 
     * Backup choice
     * 
     * Run PROXY PROCKER rotator (Has only 50 sources)
     * and make proxypool seed our database with proxies (Has only 5 sources)
    */
    
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
            $proxy['proxy'] = trim($spaceSplited[0]);
            $proxy['country'] = explode('-',$spaceSplited[1])[0];
            // $proxy['google_pass'] = $spaceSplited[2] == "+";

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
            $proxy['proxy'] = trim($item->ipPort);
            $proxy['country'] = $item->country;
            // $proxy['google_pass'] = $item->support->google == 1;
            $parsedProxies[] = $proxy;
        }
        return $parsedProxies;
    }
    
    /**
     * @https://proxyscrape.com/home
     * @https://proxyscrape.com/free-proxy-list
     * https://api.proxyscrape.com/?request=getproxies&proxytype=http&timeout=10000&country=all&ssl=all&anonymity=all
     * https://api.proxyscrape.com/?request=getproxies&proxytype=socks4&timeout=10000&country=all
     * https://api.proxyscrape.com/?request=getproxies&proxytype=socks5&timeout=10000&country=all
     */
    public static function getProxyScrape(){
        $urls = [
            'http'=>'https://api.proxyscrape.com/?request=getproxies&proxytype=http&timeout=10000&country=all&ssl=all&anonymity=all',
            'socks4'=>'https://api.proxyscrape.com/?request=getproxies&proxytype=socks4&timeout=10000&country=all',
            'socks5'=>'https://api.proxyscrape.com/?request=getproxies&proxytype=socks5&timeout=10000&country=all'
        ];
        $proxies = [];
        foreach($urls as $key => $url){
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
            curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1");
            
            $response[$key] = curl_exec($ch);
            $lines = explode("\n", $response[$key]);
            foreach($lines as $line){
                if(substr_count($line,".") == 3 && substr_count($line,":") == 1){
                    $proxies[]= $line .' '.$key;
                }
            }
        }
        return $proxies;
    }

    public static function getParsedProxyScrape(){
        $parsedProxies = [];
        $proxies = ProxyProvider::getProxyScrape();
        foreach($proxies as $item){
            $proxy =[];
            $spaceSplited = explode(' ',$item);
            $proxy['proxy'] = trim($spaceSplited[0]);
            $proxy['type'] = $spaceSplited[1];

            $parsedProxies[] = $proxy;
        }
        return $parsedProxies;
    }



}