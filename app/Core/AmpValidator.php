<?php

namespace App\Core;
require 'vendor/autoload.php';

/**
 *
 * Developed by :
 * 	Muhammad Elgendi
 * 
 **/

$html = '<!doctype html>
 <html ⚡>
   <head>
	 <meta charset="utf-8">
	 <title>Sample document</title>
	 <link rel="canonical" href="./regular-html-version.html">
	 <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
	 <style amp-custom>
	   h1 {color: red}
	 </style>
	 <script type="application/ld+json">
	 {
	   "@context": "http://schema.org",
	   "@type": "NewsArticle",
	   "headline": "Article headline",
	   "image": [
		 "thumbnail1.jpg"
	   ],
	   "datePublished": "2015-02-05T08:00:00+08:00"
	 }
	 </script>
	 <script async custom-element="amp-carousel" src="https://cdn.ampproject.org/v0/amp-carousel-0.1.js"></script>
	 <style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style><noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>
	 <script async src="https://cdn.ampproject.org/v0.js"></script>
   </head>
   <body>
	 <h1>Sample document</h1>
	 <p>
	   Some text
	   <amp-img src=sample.jpg width=300 height=300></amp-img>
	 </p>
	 <amp-ad width=300 height=250
		 type="a9"
		 data-aax_size="300x250"
		 data-aax_pubname="test123"
		 data-aax_src="302">
	 </amp-ad>
   </body>
 </html>';
$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL,            "https://amp.cloudflare.com/q" );
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt($ch, CURLOPT_POST,           1 );
		curl_setopt($ch, CURLOPT_POSTFIELDS,     $html ); 


		$result=curl_exec ($ch);
		var_dump($result);
