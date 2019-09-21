<?php
require_once 'ProxyProvider.php';
use App\Core\ProxyProvider;

// $url = "https://ip.seeip.org";
// $ch = curl_init();
// $headers = [];
// curl_setopt($ch, CURLOPT_URL, $url);
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// // this function is called by curl for each header received
// curl_setopt($ch, CURLOPT_HEADERFUNCTION,
//   function($curl, $header) use (&$headers)
//   {
//     $len = strlen($header);
//     $header = explode(':', $header, 2);
//     if (count($header) < 2) // ignore invalid headers
//       return $len;

//     $headers[strtolower(trim($header[0]))][] = trim($header[1]);

//     return $len;
//   }
// );

// $data = curl_exec($ch);
// var_dump($headers);
// echo $data;

// $proxies = ProxyProvider::getParsedProxyScrape();
// print_r($proxies);