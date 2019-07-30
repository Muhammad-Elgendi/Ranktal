<?php

namespace App\Core;
require 'vendor/autoload.php';

/**
 *
 * Developed by :
 * 	Muhammad Elgendi
 * 
 **/

// $p =new PageScraper("https://lovejinju.net/");
// $p->setRobotsContent($p->getRobots());

// $class_methods = get_class_methods($p);

// foreach ($class_methods as $method_name) {
//     if($method_name != "__construct" && $method_name != "setRobotsContent")
//         $p->$method_name();
// }

// var_dump(get_object_vars($p));
// var_dump($p->strongItems);
 

class PageScraper{	

	private $robotsContent;

	public $parsedUrl;

	public $httpCode;

	private $header;

	private $doc;

	public $isSingleTitle;

	public $title;

	public $url;

	public $description;

	public $contentType;

	public $charset;

	public $viewport;

	public $robotsMeta;

	public $isSingleDescription;

	public $xRobots;

	public $refreshMeta;

	public $refreshHeader;

	public $canonical;

	public $ratio;

	public $language;

	public $docType;

	public $h1;

	public $h2;

	public $h3;

	public $h4;

	public $h5;

	public $h6;

	public $alt;

	public $emptyAlt;

	public $ampLink;

	public $openGraph;

	public $twitterCard;

	public $framesCount;

	public $bItems;

	public $iItems;

	public $emItems;

	public $strongItems;

	public $markItems;

	public $isFlashNotExist;

	public $isAllowedFromRobots;

	public $links;

//  You should call pageConnector and pass these arguments to constructor
//  You should call getRobots and assign it to setRobotsContent to fetch the robots.txt

    function __construct($url,$parsedUrl,$httpCode,$header,$body){
		$this->url = $url;
		$this->parsedUrl = $parsedUrl;
		$this->httpCode =  $httpCode;
		$this->header = $header;       
        $this->doc = $body;   
	}
    
    public function getTitleAttr(){
        $doc = new \DOMDocument;
		libxml_use_internal_errors(true);
		$doc->loadHTML($this->doc);
		libxml_use_internal_errors(false);
		$count = $doc->getElementsByTagName('head')->item(0)->getElementsByTagName('title')->length;
		$this->isSingleTitle = $count == 1;		
        $this->title=$doc->getElementsByTagName('head')->item(0)->getElementsByTagName('title')->item(0)->nodeValue;
	}

	public function getMetaAttr(){
		$doc = new \DOMDocument;
		libxml_use_internal_errors(true);
		$doc->loadHTML($this->doc);
		libxml_use_internal_errors(false);		
		$items = $doc->getElementsByTagName('head')->item(0)->getElementsByTagName('meta');
		$usesDescription=0;		
		foreach ($items as $item) {
			if ($item->getAttribute('name') == 'description'){
				$usesDescription++;
				if($usesDescription == 1){
					$this->description = $item->getAttribute('content');
				}
			}
			if ($item->getAttribute('http-equiv') == 'Content-Type'){			
				$this->contentType = $item->getAttribute('content');
				// HTML 4.01 charset <meta http-equiv="content-type" content="text/html; charset=UTF-8">
				$arr = explode(";", $this->contentType);	
				if($arr !== false){
					foreach($arr as $value){
						if(stripos($value, 'charset=') !== false){
							$this->charset = substr($value, stripos($value, 'charset='));
						}
					}	
				}	
			}
			// Check for HTML 5 charset  <meta charset="UTF-8">
			if (empty($this->charset) && !empty($item->getAttribute('charset'))){			
				$this->charset = $item->getAttribute('charset');				
			}
			if ($item->getAttribute('name') == 'viewport'){				
				$this->viewport = $item->getAttribute('content');
			}
			if ($item->getAttribute('name') == 'robots'){				
				$this->robotsMeta = $item->getAttribute('content');
			}
			if ($item->getAttribute('http-equiv')=="refresh"){
                $this->refreshMeta = $item->getAttribute('content');                
			}
			$property=$item->getAttribute('property');
			if (strpos($property,'og:') !== false){
				$this->openGraph[$property] = $item->getAttribute('content');  
			}			
			$twitter=$item->getAttribute('name');			
			if (strpos($twitter,'twitter:') !== false){
				$this->twitterCard[$twitter] = $item->getAttribute('content');
			}    	
		}
		$this->isSingleDescription = $usesDescription == 1;
	}

	public function getHeaderAttr(){
		if(isset($this->header['X-Robots-Tag'])){
			$this->xRobots = '';
            foreach($this->header['X-Robots-Tag'] as $value){
                $this->xRobots +=' '.$value; 
            }
		}
		if(isset($this->header['Refresh'])){
			$this->refreshHeader ='';
            foreach($this->header['Refresh'] as $value){
				$this->refreshHeader +=' '.$value;   
            }
        }
	}

	public function getLinkAttr(){
		$doc = new \DOMDocument;
		libxml_use_internal_errors(true);
		$doc->loadHTML($this->doc);
		libxml_use_internal_errors(false);		
		$items = $doc->getElementsByTagName('head')->item(0)->getElementsByTagName('link');
		foreach ($items as $item) {
			if ($item->getAttribute('rel') == 'canonical' && !empty($item->getAttribute('href'))){			    
                $this->canonical = $item->getAttribute('href');        	
			}
			if ($item->getAttribute('rel') == 'amphtml'){
				$this->ampLink = $item->getAttribute('href');
			}
		}
	}
		
	public function setTextHtmlRatio(){
		$text=strip_tags($this->doc);
		$filesize=strlen($this->doc);
		$textsize=strlen($text);
		$this->ratio=round((($textsize/$filesize)*100), 2);
	}

	public function getLanguageAttr(){
		$doc = new \DOMDocument;
		libxml_use_internal_errors(true);
		$doc->loadHTML($this->doc);
		libxml_use_internal_errors(false);
		if($doc->getElementsByTagName('html')->item(0)->getAttribute('lang')) {
            $this->language = $doc->getElementsByTagName('html')->item(0)->getAttribute('lang');            
        }
	}

	public function getDocTypeAttr(){
		$doc = new \DOMDocument();
		libxml_use_internal_errors(true);
		$doc->loadHTML($this->doc);
		libxml_use_internal_errors(false);	
		$docPublicId=$doc->doctype->publicId;	
		$docTypeNameOld=preg_replace('~.*//DTD(.*?)//.*~', '$1', $docPublicId);
		$this->docType = empty($docTypeNameOld) ? 'HTML 5' : $docTypeNameOld;
	}

	public function getHeadersAttr(){
		$doc =new \DOMDocument();
		libxml_use_internal_errors(true);
		$doc->loadHTML($this->doc);
		libxml_use_internal_errors(false);
		$headingTags=array('h1','h2','h3','h4','h5','h6');
		foreach ($headingTags as $headingTag) {
			$hElement=$doc->getElementsByTagName('body')->item(0)->getElementsByTagName($headingTag);
            for ($i=0; $i < $hElement->length ; $i++) {
                $this->$headingTag[]=$hElement->item($i)->nodeValue;
            }
		}	
	}

	public function getImagesAttr(){
		$doc =new \DOMDocument();
		libxml_use_internal_errors(true);
		$doc->loadHTML($this->doc);
		libxml_use_internal_errors(false);
		$imageElement=$doc->getElementsByTagName('body')->item(0)->getElementsByTagName('img');    
        for ($i=0;$i< $imageElement->length; $i++){
            $value = $imageElement->item($i)->getAttribute("alt");
            if (!empty($value))
                $this->alt[] = $value;
            else
                $this->emptyAlt[] = ['num' => ($i + 1), 'src' => ($imageElement->item($i)->getAttribute("src"))];
        }
	}

	public function getFramesAttr(){
		$doc = new \DOMDocument;
		libxml_use_internal_errors(true);
		$doc->loadHTML($this->doc);
		libxml_use_internal_errors(false);
		//---Get frames elements count		
		$this->framesCount=$doc->getElementsByTagName('frame')->length + $doc->getElementsByTagName('iframe')->length;		
	}

	public function getFormattedTextAttr(){
        $doc = new \DOMDocument;
        libxml_use_internal_errors(true);
        $doc->loadHTML($this->doc);
        libxml_use_internal_errors(false);
        $body=$doc->getElementsByTagName('body')->item(0);
        $bItems = $body->getElementsByTagName('b');
        $iItems = $body->getElementsByTagName('i');
        $emItems = $body->getElementsByTagName('em');
		$strongItems = $body->getElementsByTagName('strong');
		$markItems = $body->getElementsByTagName('mark');
        foreach ($bItems as $bItem){
            if (!empty($bItem->nodeValue)){
				$this->bItems[] = $bItem->nodeValue;
			}
		}
        foreach ($iItems as $iItem){
            if (!empty($iItem->nodeValue)){
				$this->iItems[] = $iItem->nodeValue;
			}
		}
        foreach ($emItems as $emItem){
            if (!empty($emItem->nodeValue)){
				$this->emItems[] = $emItem->nodeValue;
			}
		}
        foreach ($strongItems as $strongItem){
            if (!empty($strongItem->nodeValue)){
				$this->strongItems[] = $strongItem->nodeValue;
			}
		}
		foreach ($markItems as $markItem){
            if (!empty($markItem->nodeValue)){
				$this->markItems[] = $markItem->nodeValue;
			}
		}
	}

	public function setFlashAttr(){
        $doc = new \DOMDocument;
        libxml_use_internal_errors(true);
        $doc->loadHTML($this->doc);
        libxml_use_internal_errors(false);
        $objects=$doc->getElementsByTagName('object');
        $params=$doc->getElementsByTagName('param');
        $embeds=$doc->getElementsByTagName('embed');
        for ($i = 0; $i < $objects->length; $i++) {
            $tag_item = $objects->item($i);
            if ((strpos($tag_item->getAttribute('data'), '.swf')!== false)|(strpos($tag_item->getAttribute('type'), 'shockwave')!== false)){
				$this->isFlashNotExist = false;
				return;
			}   
        }
        for ($i = 0; $i < $params->length; $i++) {
            $tag_item = $params->item($i);
            if (strpos($tag_item->getAttribute('value'), '.swf')!== false){
				$this->isFlashNotExist = false;
				return;
			} 
        }
        for ($i = 0; $i < $embeds->length; $i++) {
            $tag_item = $embeds->item($i);
            if (strpos($tag_item->getAttribute('src'), '.swf')!== false){
				$this->isFlashNotExist = false;
				return;
			}   
        }
		if(preg_match('(swfobject|swfobject.registerObject|.swf|shockwave)', $this->doc) === 1){
			$this->isFlashNotExist = false;  
		}	
        else
			$this->isFlashNotExist = true; 
	}

    public function getAllLinks(){
        $doc = new \DOMDocument;
        libxml_use_internal_errors(true);
        $doc->loadHTML($this->doc);
        libxml_use_internal_errors(false);
		$anchors=$doc->getElementsByTagName('a');
		$defaultRel = isset($this->xRobots) ? $this->xRobots : '';
		$defaultRel .=isset($this->robotsMeta) ? " ".$this->robotsMeta : '';
        foreach ($anchors as $anchor) {            
            $text=$anchor->nodeValue;
            $link=rawurldecode($anchor->getAttribute("href"));
            $rel=$anchor->getAttribute("rel");
            if(strpos($rel, 'nofollow')=== false && strpos($defaultRel, 'nofollow')=== false && strpos($defaultRel, 'none')=== false)
                $relStatus='Dofollow';
            else
				$relStatus='Nofollow';
				
			$this->links[] =['aText' => $text,
							 'aHref' => $link,							
							 'aStatus' => $relStatus];
        }
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
	
	public function setRobotsContent($robotsContent){
		$this->robotsContent = $robotsContent;
	}

    public function getRobots(){
		if(empty($this->robotsContent)) {
			if(isset($this->parsedUrl["scheme"]) && isset($this->parsedUrl["host"])){
				$robotsUrl=$this->parsedUrl["scheme"].'://'.$this->parsedUrl["host"].'/robots.txt';
				return $this->makeConnection($robotsUrl);            
			}
		}
		else return $this->robotsContent;
	}
	
	

    public function setIsAllowedFromRobots(){
		 
		if(!empty($this->robotsContent)) {
            $parser = new \RobotsTxtParser($this->robotsContent);
            $agents=['*','Googlebot','Bingbot','Slurp','DuckDuckBot','Baiduspider','YandexBot'];
            $pathToPage = isset($this->parsedUrl["path"]) ? $this->parsedUrl["path"] : '/';            
            foreach($agents as $agent){
                $parser->setUserAgent($agent);         
                if ($parser->isDisallowed($pathToPage)) {
					$this->isAllowedFromRobots =false;
                    return;
                }
			}
			$this->isAllowedFromRobots = true;          
        }else{
			$this->isAllowedFromRobots = true;       
		}      
    }

}