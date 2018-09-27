<?php
namespace App\Core;

/**
 *
 * Developed by :
 * 	Muhammad Elgendi
 * */

$p =new PageInsights("https://is.net.sa");

$class_methods = get_class_methods($p);

foreach ($class_methods as $method_name) {
    if($method_name != "__construct")
        $p->$method_name();
}

var_dump(get_object_vars($p));



 class PageInsights{
    private $url;


    //holds page insight response
	public $pageInsightDesktop;

    //holds screenShot to show it {echo '<img src='.'"'.$test->srcImage.'"/>';}
	public $screenShotSrcDesktop;


	public $screenShotWidthDesktop;
	public $screenShotHeightDesktop;
	public $optimizableResourcesDesktop;
	public $impactsListDesktop;
	public $problemsListDesktop;

    //holds page insight mobile response
    public $pageInsightMobile;
    //holds screenShot mobile to show it {echo '<img src='.'"'.$test->srcImage.'"/>';}
    public $screenShotSrcMobile;

    public $screenShotWidthMobile;
    public $screenShotHeightMobile;
    public $optimizableResourcesMobile;
    public $impactsListMobile;
    public $problemsListMobile;

        /**
     * PageInsights constructor.
     * @param $url
     */
	function __construct($url){
		$this->url=$url;

	
    }
    
    public function setPageInsightDesktop(){
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
    

    public  function makeReadablePageInsightDesktop(){
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

    public function setPageInsightMobile(){
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

    public  function makeReadablePageInsightMobile(){
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
 }