<?php

namespace App\Core;
/**
 *
 * Developed by :
 * 	Muhammad Elgendi
 *
 * -Capabilities               -Return-type   Type      -Column-name
 *
 * -iFrameCount                                 integer
 * -frameSetCount                               integer
 * -frameCount                                   integer
 * -hasIFrame                                    boolean
 * -hasFrameSet                                   boolean
 * -hasFrame                                      boolean
 * -ampLink                                       string
 * -og                                             array   openGraph
 * -twitterCard                                    array
 * -favicon                                        string
 * -hasAmpLink                                        boolean
 * -hasOG                                             boolean
 * -hasTwitterCard                                    boolean
 * -hasFavicon                                        boolean
 * -hasMicroData                                      boolean
 * -hasRDFa                                           boolean
 * -hasJson                                           boolean
 * -hasStructuredData                                 boolean
 * -hasMicroFormat                                    boolean
 * -robotsFile                                      string
 * -siteMap                                         array
 * -bItems                                         array
 * -iItems                                         array
 * -emItems                                        array
 * -strongItems                                    array
 * -URLRedirects                                    array
 * -redirectStatus                                 array
 * -anchorCount                                     integer
 * -defaultRel                                   string
 * -aText                                        array
 * -aHref                                         array
 * -aRel                                          array
 * -aStatus                                       array
 * -hasRobotsFile                                  boolean
 * -hasSiteMap                                     boolean
 * -hasFormattedText                              boolean
 * -hasFlash                                     boolean
 * -isIndexAble                                  boolean
 *
 * This class contains :
 * frames        
 * microFormat   
 * schema.org    
 * open Graph    
 * Twitter card  
 * AMP           
 * favicon       
 * flash         		
 * robots.txt           
 * xml siteMaps         
 * bold/strong          
 * italic/em            
 * url redirect status  
 * link analyser(rel)   
 * indexAbility         
 *
 **/

class Check{

    /**
     * holds the html code of page
     * @var string
     */
	private $html;

    /**
     * holds the URL of page
     * @var string
     */
	private $url;

	public $iFrameCount;
	public $frameSetCount;
	public $frameCount;

    public $hasIFrame;
    public $hasFrameSet;
    public $hasFrame;

	public $ampLink;
	public $og;
	public $twitterCard;
	public $favicon;

	public $hasAmpLink;
    public $hasOG;
    public $hasTwitterCard;
    public $hasFavicon;

    public $hasMicroData;
    public $hasRDFa;
    public $hasJson;
    public $hasStructuredData;
    public $hasMicroFormat;

    public $robotsFile;
    public $siteMap;
    public $bItems;
    public $iItems;
    public $emItems;
    public $strongItems;

    public $URLRedirects;
    public $redirectStatus;
    public $anchorCount;
    public $defaultRel;
    public $aText;
    public $aHref;
    public $aRel;
    public $aStatus;

    public $hasRobotsFile;
    public $hasSiteMap;
    public $hasFormattedText;
    public $hasFlash;
    public $isIndexAble;

    /**
     * Check constructor.
     * @param $html
     * @param $url
     */
	function __construct($url,$html){
		$this->html=$html;
		$this->url=$url;
		$this->setFavicon();
		$this->setAll();

        $this->setRobotsFile();
        $this->setSiteMapFromRoot();
        $this->setSiteMapFromRobotsFile();
        $this->setFormattedText();
        $this->setURLRedirect();
        $this->setURLStatus();
        $this->defaultRel=$this->getDefaultRel();
        $this->setAllRel();

        $this->setChecks();
    }

    /**
     * set all the data that fetched from the page
     * sets :
     * iFrame
     * frameSet
     * frame
     * ampLink
     * favicon
     * og
     * twitterCard
     */
	private function setAll(){
		$doc = new \DOMDocument;
		libxml_use_internal_errors(true);
		$doc->loadHTML($this->html);
		libxml_use_internal_errors(false);
		//---Get frames elements count		
		$iframe = $doc->getElementsByTagName('iframe')->length;
		$IFRAME = $doc->getElementsByTagName('IFRAME')->length;
		$this->iFrameCount=$iframe+$IFRAME;
		$FRAMESET = $doc->getElementsByTagName('FRAMESET')->length;
		$frameset = $doc->getElementsByTagName('frameset')->length;
		$this->frameSetCount=$FRAMESET+$frameset;
		$FRAME = $doc->getElementsByTagName('FRAME')->length;
		$frame = $doc->getElementsByTagName('frame')->length;
		$this->frameCount=$FRAME+$frame;
		//---get AMP link & fav icon rel in link tag
		$linkTags=$doc->getElementsByTagName('link');
		for ($i = 0; $i < $linkTags->length; $i++) {
	        $tag_item = $linkTags->item($i);
	        if ($tag_item->getAttribute('rel') == 'amphtml')
	            $this->ampLink = $tag_item->getAttribute('href');
	        elseif ($tag_item->getAttribute('rel') == 'shortcut icon'){ 
	        	$faviconlink=$tag_item->getAttribute('href');
                $status=(!filter_var($faviconlink, FILTER_VALIDATE_URL) === false) ? get_headers($faviconlink,1)[0] : 'Error';
                if(strpos($status, '200')!== false)
	        		$this->favicon = $faviconlink;	        
	        }	   
    	}
    	//---get open graph  and twitter cards
    	$metas=$doc->getElementsByTagName('meta');
    	for ($i = 0; $i < $metas->length; $i++) {
	        $meta = $metas->item($i);
	        $property=$meta->getAttribute('property');
	        $twitter=$meta->getAttribute('name');
	        if (strpos($property,'og:') !== false)
	            $this->og["$property"] = $meta->getAttribute('content');   
	        elseif (strpos($twitter,'twitter:') !== false)
	        	$this->twitterCard["$twitter"] = $meta->getAttribute('content');     
    	}
	}

    /**
     * @param $url
     * @return bool|mixed
     */
    private function getRedirectUrlOrFail ($url) {
        $headers = get_headers($url, 1);
        if ($headers !== false && isset($headers['Location'])) {
            return is_array($headers['Location']) ? array_pop($headers['Location']) : $headers['Location'];
        }
        return false;
    }

    private function setFavicon(){
        $faviconroot='http://'.parse_url($this->url, PHP_URL_HOST).'/favicon.ico';
        $redirected=$this->getRedirectUrlOrFail($faviconroot);
        $realFavicon=($redirected) ? $redirected : $faviconroot;
        $status=get_headers($realFavicon,1)[0];
        if(strpos($status, '200')!== false){
            $this->favicon=$realFavicon;
        }
    }

    private function setRobotsFile(){
        $robots='http://'.parse_url($this->url, PHP_URL_HOST).'/robots.txt';
        $redirected=$this->getRedirectUrlOrFail($robots);
        $realRobots=($redirected) ? $redirected : $robots;
        $status=get_headers($realRobots,1)[0];
        if(strpos($status, '200')!== false){
            $this->robotsFile=$realRobots;
        }
    }

    private function setSiteMapFromRoot(){
        $sitemap='http://'.parse_url($this->url, PHP_URL_HOST).'/sitemap.xml';
        $redirected=$this->getRedirectUrlOrFail($sitemap);
        $realSiteMap=($redirected) ? $redirected : $sitemap;
        $status=get_headers($realSiteMap,1)[0];
        if(strpos($status, '200')!== false){
            $this->siteMap[]=$realSiteMap;
        }
    }

    private function setSiteMapFromRobotsFile(){
        if(isset($this->robotsFile)){
            $file = new \SplFileObject($this->robotsFile);
            while (!$file->eof()){
                $line = $file->fgets();
                $SiteMapPos=stripos($line, 'Sitemap:');
                if($SiteMapPos !== false){
                    $siteMap=trim(substr($line,($SiteMapPos+8)));
                    if( ! empty($siteMap))
                        if (!(in_array($siteMap, $this->siteMap, true)))
                            $this->siteMap[] = $siteMap;
                }
            }
        }
    }

    private function setFormattedText(){
        /*
            <b> - Bold text
            <strong> - Important text
            <i> - Italic text
            <em> - Emphasized text
        */
        $doc = new \DOMDocument;
        libxml_use_internal_errors(true);
        $doc->loadHTML($this->html);
        libxml_use_internal_errors(false);
        $body=$doc->getElementsByTagName('body')->item(0);
        $bItems = $body->getElementsByTagName('b');
        $iItems = $body->getElementsByTagName('i');
        $emItems = $body->getElementsByTagName('em');
        $strongItems = $body->getElementsByTagName('strong');
        foreach ($bItems as $bItem)
            if (!empty($bItem->nodeValue))
                $this->bItems[] = $bItem->nodeValue;
        foreach ($iItems as $iItem)
            if (!empty($iItem->nodeValue))
                $this->iItems[] = $iItem->nodeValue;
        foreach ($emItems as $emItem)
            if (!empty($emItems->nodeValue))
                $this->emItems[] = $emItem->nodeValue;
        foreach ($strongItems as $strongItem)
            if (!empty($strongItems->nodeValue))
                $this->strongItems[] = $strongItem->nodeValue;
    }

    private function isHasFlash(){
        /**
         * -search for .swf
         * To check if website is using Flash, you need to check for either embed tag or object tag,
         * for embed tag you can see the application type which should be shockwave ,
         * and for object you can see the CLSID value which is same on windows for sure.
         */
        $doc = new \DOMDocument;
        libxml_use_internal_errors(true);
        $doc->loadHTML($this->html);
        libxml_use_internal_errors(false);
        $objects=$doc->getElementsByTagName('object');
        $params=$doc->getElementsByTagName('param');
        $embeds=$doc->getElementsByTagName('embed');
        for ($i = 0; $i < $objects->length; $i++) {
            $tag_item = $objects->item($i);
            if ((strpos($tag_item->getAttribute('data'), '.swf')!== false)|(strpos($tag_item->getAttribute('type'), 'shockwave')!== false))
                return true;
        }
        for ($i = 0; $i < $params->length; $i++) {
            $tag_item = $params->item($i);
            if (strpos($tag_item->getAttribute('value'), '.swf')!== false)
                return true;
        }
        for ($i = 0; $i < $embeds->length; $i++) {
            $tag_item = $embeds->item($i);
            if (strpos($tag_item->getAttribute('src'), '.swf')!== false)
                return true;
        }
        if(preg_match('(swfobject|swfobject.registerObject|.swf|shockwave)', $this->html) === 1)
            return true;
        else
            return false;
    }

    private function setURLRedirect(){
        $headers = get_headers($this->url, 1);
        $this->URLRedirects[]=$this->url;
        if ($headers !== false && isset($headers['Location'])) {
            $this->URLRedirects= is_array($headers['Location']) ? array_merge($this->URLRedirects,$headers['Location']) : $headers['Location'];
        }
    }

    private function setURLStatus(){

            foreach ((array) $this->URLRedirects as $url)
                $this->redirectStatus[] = get_headers($url, 1)[0];

    }

    private function getDefaultRel(){
        /**
         * X-Robots-Tag
         * meta robots
         */
        $default=null;
        $headers = get_headers($this->url, 1);
        if ($headers !== false && isset($headers['X-Robots-Tag'])) {
            $default=$headers['X-Robots-Tag'];
        }
        $metas = get_meta_tags($this->url);
        if (isset($metas['robots'])) {
            $default.=$metas['robots'];
        }
        return $default;
    }

    private function setAllRel(){
        $doc = new \DOMDocument;
        libxml_use_internal_errors(true);
        $doc->loadHTML($this->html);
        libxml_use_internal_errors(false);
        $anchors=$doc->getElementsByTagName('a');
        $this->anchorCount=$anchorCount=$doc->getElementsByTagName('a')->length;
        for ($i = 0; $i < $anchorCount; $i++) {
            $tag_item = $anchors->item($i);
            $text=$tag_item->nodeValue;
            $link=$tag_item->getAttribute("href");
            $rel=$tag_item->getAttribute("rel");
            if(strpos($rel, 'nofollow')=== false && strpos($this->defaultRel, 'nofollow')=== false && strpos($this->defaultRel, 'none')=== false)
                $relStatus='dofollow';
            else
                $relStatus='nofollow';

                $this->aText[]=$text;
                $this->aHref[]=$link;
                $this->aRel[]=$rel;
                $this->aStatus[]=$relStatus;
        }
    }

    private function setChecks(){
        $this->hasIFrame=($this->iFrameCount>0) ? true : false ;
        $this->hasFrameSet=($this->frameSetCount>0) ? true : false ;
        $this->hasFrame=($this->frameCount>0) ? true : false ;
        $this->hasMicroData=(strpos($this->html,'itemscope') === false && strpos($this->html,'itemtype') === false) ? false:true;
        $this->hasRDFa=(strpos($this->html,'vocab') === false && strpos($this->html,'typeof') === false) ? false: true;
        $this->hasJson=(strpos($this->html,'@context') === false && strpos($this->html,'@type') === false) ? false:true;
        $this->hasStructuredData=($this->hasMicroData || $this->hasRDFa || $this->hasJson) ? true:false;
        $this->hasMicroFormat=(preg_match('(hnews|h-card|h-entry|h-event|h-review|h-feed|h-product|h-recipe|h-resume)', $this->html) === 1) ?true :false ;
        $this->hasAmpLink=(isset($this->ampLink)) ? true : false;
        $this->hasOG=(isset($this->og)) ? true : false;
        $this->hasTwitterCard=(isset($this->twitterCard)) ? true : false;
        $this->hasFavicon=(isset($this->favicon)) ? true : false;
        $this->hasRobotsFile=(isset($this->robotsFile)) ? true : false;
        $this->hasSiteMap=(isset($this->siteMap)) ? true : false;
        $this->hasFormattedText=(isset($this->bItems) || isset($this->iItems) || isset($this->emItems) || isset($this->strongItems)) ? true : false;
        $this->hasFlash=$this->isHasFlash();
        $this->isIndexAble=(strpos($this->defaultRel,'noindex') === false && strpos($this->defaultRel,'none') === false) ? true: false;
    }
}