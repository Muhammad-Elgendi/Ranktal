<?php
namespace App\Core;

/**
 *
 * Developed by :
 * 	Muhammad Elgendi
 *
 * -Capabilities                 -Return-type
 *
 *
 * pageInsightDesktop            array
 * hasPageInsightDesktop         boolean
 * screenShotSrcDesktop          text
 * hasScreenShotSrcDesktop       boolean
 * screenShotWidthDesktop        int
 * screenShotHeightDesktop       int
 * hasScreenShotWidthDesktop     boolean
 * hasScreenShotHeightDesktop    boolean
 * optimizableResourcesDesktop   array
 * impactsListDesktop            array
 * problemsListDesktop           array
 * pageInsightMobile             array
 * hasPageInsightMobile          boolean
 * screenShotSrcMobile           text
 * hasScreenShotSrcMobile        boolean
 * screenShotWidthMobile         int
 * screenShotHeightMobile        int
 * hasScreenShotWidthMobile      boolean
 * hasScreenShotHeightMobile     boolean
 * optimizableResourcesMobile    array
 * impactsListMobile             array
 * problemsListMobile            array
 * hasProblemsListDesktop        boolean
 * hasProblemsListMobile         boolean
 * hasImpactsListDesktop         boolean
 * hasImpactsListMobile          boolean
 *
 *
 *
 *$json = json_decode($string);
 *echo json_encode($json, JSON_PRETTY_PRINT);
 *Use the second parameter of json_decode to make it return an array
 *Guzzle method
 *$client = new client();
 *$data = json_decode($client->request('GET', $url)->getBody(),true);
 *file_get_contents method
 *$data = json_decode(file_get_contents($url),true);
 *We use CURL method because it's the fastest
 *api key:AIzaSyCuI3LI3zdYsoiVq--wrnBwdX-ma0Ct1U4
 *GET https:*www.googleapis.com/pagespeedonline/v2/runPagespeed?url=https%3A%2F%2Fwww.islamland.net&screenshot=true&key={YOUR_API_KEY}
 *information : goo.gl/5dQTci
 *
 **/


class PageSpeed{

	private $url;

    //holds page insight response
	public $pageInsightDesktop;
    public $hasPageInsightDesktop;
    //holds screenShot to show it {echo '<img src='.'"'.$test->srcImage.'"/>';}
	public $screenShotSrcDesktop;
	public $hasScreenShotSrcDesktop;

	public $screenShotWidthDesktop;
	public $screenShotHeightDesktop;
	public $hasScreenShotWidthDesktop;
	public $hasScreenShotHeightDesktop;
	public $optimizableResourcesDesktop;
	public $impactsListDesktop;
	public $problemsListDesktop;

    //holds page insight mobile response
    public $pageInsightMobile;
    public $hasPageInsightMobile;
    //holds screenShot mobile to show it {echo '<img src='.'"'.$test->srcImage.'"/>';}
    public $screenShotSrcMobile;
    public $hasScreenShotSrcMobile;

    public $screenShotWidthMobile;
    public $screenShotHeightMobile;
    public $hasScreenShotWidthMobile;
    public $hasScreenShotHeightMobile;
    public $optimizableResourcesMobile;
    public $impactsListMobile;
    public $problemsListMobile;

    public $hasProblemsListDesktop;
    public $hasProblemsListMobile;
    public $hasImpactsListDesktop;
    public $hasImpactsListMobile;

    /**
     * PageSpeed constructor.
     * @param $url
     */
	function __construct($url){
		$this->url=$url;
		$this->setPageInsightDesktop();
		$this->makeReadablePageInsightDesktop();
		$this->setPageInsightMobile();
		$this->makeReadablePageInsightMobile();
		$this->setChecks();
	
	}

	private function setPageInsightDesktop(){
		$url="https://www.googleapis.com/pagespeedonline/v2/runPagespeed?url=$this->url&strategy=desktop&screenshot=true&key=AIzaSyCuI3LI3zdYsoiVq--wrnBwdX-ma0Ct1U4";
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$curl_response = curl_exec($curl);
        curl_close($curl);
		if ($curl_response === false) {
    		return ;
		}
		$data = json_decode($curl_response,true);
		if (empty($data)){
    		return ;
		}
		$this->pageInsightDesktop=$data;
		$image = $data['screenshot']['data'];
		$imageData = str_replace(array('_','-'),array('/','+'),$image);
		$mimeType=$data['screenshot']['mime_type'];
		$width=$data['screenshot']['width'];
        $height=$data['screenshot']['height'];
		if(!empty($mimeType) && !empty($imageData))
		    $this->screenShotSrcDesktop = 'data:'.$mimeType.';base64,'.$imageData;
        if(!empty($width))
            $this->screenShotWidthDesktop = $width;
        if(!empty($height))
            $this->screenShotHeightDesktop = $height;
	}

    private  function makeReadablePageInsightDesktop(){
	    if(isset($this->pageInsightDesktop)){
	        $speed=$this->pageInsightDesktop['ruleGroups']['SPEED']['score'];
	        unset(
                $this->pageInsightDesktop['id'],
                $this->pageInsightDesktop['responseCode'],
                $this->pageInsightDesktop['title'],
                $this->pageInsightDesktop['ruleGroups'],
                $this->pageInsightDesktop['version'],
                $this->pageInsightDesktop['screenshot'],
                $this->pageInsightDesktop['kind']
            );
	        $this->pageInsightDesktop['speed']=$speed;

            array_walk_recursive($this->pageInsightDesktop,array($this, 'processArrayDesktop'));

            $this->optimizableResourcesDesktop=$this->optimizableResourcesDesktop['value'];
            foreach ($this->optimizableResourcesDesktop as $key => $value){
                if(stripos($value,'developers.google.com')!== false | stripos($value,'http')=== false)
                    unset($this->optimizableResourcesDesktop[$key]);
            }

	        foreach ($this->pageInsightDesktop['formattedResults']['ruleResults'] as $key => $rule){
	            if($rule['ruleImpact'] == 0) {
                    unset($this->pageInsightDesktop['formattedResults']['ruleResults'][$key]);
                    continue;
                }
	            unset(
	                $this->pageInsightDesktop['formattedResults']['ruleResults'][$key]['groups'],
                    $this->pageInsightDesktop['formattedResults']['ruleResults'][$key]['summary'],
                    $this->pageInsightDesktop['formattedResults']['ruleResults'][$key]['urlBlocks']
                );
	            if(!empty($this->pageInsightDesktop['formattedResults']['ruleResults'][$key]['localizedRuleName']))
	                $this->problemsListDesktop[]=$this->pageInsightDesktop['formattedResults']['ruleResults'][$key]['localizedRuleName'];
                if(!empty($this->pageInsightDesktop['formattedResults']['ruleResults'][$key]['ruleImpact']))
                    $this->impactsListDesktop[]=$this->pageInsightDesktop['formattedResults']['ruleResults'][$key]['ruleImpact'];
            }
        }
    }

    private function processArrayDesktop($item, $key){
        if(isset($this->optimizableResourcesDesktop[$key]))
            $this->optimizableResourcesDesktop[$key][]=$item;

        else
            $this->optimizableResourcesDesktop[$key]=[$item];
    }

    private function setPageInsightMobile(){
        $url="https://www.googleapis.com/pagespeedonline/v2/runPagespeed?url=$this->url&strategy=mobile&screenshot=true&key=AIzaSyCuI3LI3zdYsoiVq--wrnBwdX-ma0Ct1U4";
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $curl_response = curl_exec($curl);
        curl_close($curl);
        if ($curl_response === false) {
            return ;
        }
        $data = json_decode($curl_response,true);
        if (empty($data)){
            return ;
        }
        $this->pageInsightMobile=$data;
        $image = $data['screenshot']['data'];
        $imageData = str_replace(array('_','-'),array('/','+'),$image);
        $mimeType=$data['screenshot']['mime_type'];
        $width=$data['screenshot']['width'];
        $height=$data['screenshot']['height'];
        if(!empty($mimeType) && !empty($imageData))
            $this->screenShotSrcMobile = 'data:'.$mimeType.';base64,'.$imageData;
        if(!empty($width))
            $this->screenShotWidthMobile = $width;
        if(!empty($height))
            $this->screenShotHeightMobile = $height;
    }

    private  function makeReadablePageInsightMobile(){
        if(isset($this->pageInsightMobile)){
            $speed=$this->pageInsightMobile['ruleGroups']['SPEED']['score'];
            unset(
                $this->pageInsightMobile['id'],
                $this->pageInsightMobile['responseCode'],
                $this->pageInsightMobile['title'],
                $this->pageInsightMobile['ruleGroups'],
                $this->pageInsightMobile['version'],
                $this->pageInsightMobile['screenshot'],
                $this->pageInsightMobile['kind']
            );
            $this->pageInsightMobile['speed']=$speed;

            array_walk_recursive($this->pageInsightMobile,array($this, 'processArrayMobile'));

            $this->optimizableResourcesMobile=$this->optimizableResourcesMobile['value'];
            foreach ($this->optimizableResourcesMobile as $key => $value){
                if(stripos($value,'developers.google.com')!== false | stripos($value,'http')=== false)
                    unset($this->optimizableResourcesMobile[$key]);
            }

            foreach ($this->pageInsightMobile['formattedResults']['ruleResults'] as $key => $rule){
                if($rule['ruleImpact'] == 0) {
                    unset($this->pageInsightMobile['formattedResults']['ruleResults'][$key]);
                    continue;
                }
                unset(
                    $this->pageInsightMobile['formattedResults']['ruleResults'][$key]['groups'],
                    $this->pageInsightMobile['formattedResults']['ruleResults'][$key]['summary'],
                    $this->pageInsightMobile['formattedResults']['ruleResults'][$key]['urlBlocks']
                );
                if(!empty($this->pageInsightMobile['formattedResults']['ruleResults'][$key]['localizedRuleName']))
                    $this->problemsListMobile[]=$this->pageInsightMobile['formattedResults']['ruleResults'][$key]['localizedRuleName'];
                if(!empty($this->pageInsightMobile['formattedResults']['ruleResults'][$key]['ruleImpact']))
                    $this->impactsListMobile[]=$this->pageInsightMobile['formattedResults']['ruleResults'][$key]['ruleImpact'];
            }
        }
    }

    private function processArrayMobile($item, $key){
        if(isset($this->optimizableResourcesMobile[$key]))
            $this->optimizableResourcesMobile[$key][]=$item;

        else
            $this->optimizableResourcesMobile[$key]=[$item];
    }

    private function setChecks(){
        $this->hasPageInsightDesktop=(isset($this->pageInsightDesktop)) ? true : false;
        $this->hasScreenShotSrcDesktop=(isset($this->screenShotSrcDesktop)) ? true : false;
        $this->hasScreenShotHeightDesktop=(isset($this->screenShotHeightDesktop)) ? true : false;
        $this->hasScreenShotWidthDesktop=(isset($this->screenShotWidthDesktop)) ? true : false;
        $this->hasPageInsightMobile=(isset($this->pageInsightMobile)) ? true : false;
        $this->hasScreenShotSrcMobile=(isset($this->screenShotSrcMobile)) ? true : false;
        $this->hasScreenShotHeightMobile=(isset($this->screenShotHeightMobile)) ? true : false;
        $this->hasScreenShotWidthMobile=(isset($this->screenShotWidthMobile)) ? true : false;

        $this->hasImpactsListDesktop=(isset($this->impactsListDesktop)) ? true : false;
        $this->hasImpactsListMobile=(isset($this->impactsListMobile)) ? true : false;
        $this->hasProblemsListDesktop=(isset($this->problemsListDesktop)) ? true : false;
        $this->hasProblemsListMobile=(isset($this->problemsListMobile)) ? true : false;

    }
}