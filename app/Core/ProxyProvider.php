<?php

// $proxy = ProxyProvider::getSpysMeProxy();
class ProxyProvider{

    public function __construct(){
     
    }

    public static function getSpysMeProxy(){
        $ch = curl_init("http://spys.me/proxy.txt");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.1) Gecko/20061204 Firefox/2.0.0.1");
        
        $response = curl_exec($ch);
        $lines = explode("\n", $response);
        $space = 0;
        $proxies = [];
        foreach($lines as $line){
            if(!empty($line) && strpos($line,".") !== false && strpos($line,":") !== false && strpos($line,"//") === false){
                if(strpos($line,"+ ") !== false)
                    $proxies["google"][] = $line;
                else $proxies["bing"][] = $line;
            }
        }
        return $proxies;
    }

}