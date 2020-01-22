<?php
namespace App\Core;

/**
 *
 * Developed by :
 * 	Muhammad Elgendi
 * */

// $p =new PageInsights("https://is.net.sa","mobile");

// $class_methods = get_class_methods($p);

// foreach ($class_methods as $method_name) {
//     if($method_name != "__construct")
//         $p->$method_name();
// }

// var_dump(get_object_vars($p));



 class PageInsights{
    public $url;
    public $type;
    //holds page insight response
	public $pageInsight;
    //holds screenShot to show it {echo '<img src='.'"'.$test->srcImage.'"/>';}
	public $screenShotSrc;
	public $screenShotWidth;
	public $screenShotHeight;
	public $optimizableResources;
	public $impactsList;
	public $problemsList;

     /**
     * PageInsights constructor.
     * Allowed types :-
     * mobile
     * desktop
     * 
     * @param $url
     */
	function __construct($url,$type){
        $this->url=$url;	
        $this->type =$type;
    }
    
    public function setPageInsight(){
		$url="https://www.googleapis.com/pagespeedonline/v2/runPagespeed?url=$this->url&strategy=$this->type&screenshot=true&key=AIzaSyCuI3LI3zdYsoiVq--wrnBwdX-ma0Ct1U4";
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
		$this->pageInsight=$data;
		$image = $data['screenshot']['data'];
		$imageData = str_replace(array('_','-'),array('/','+'),$image);
		$mimeType=$data['screenshot']['mime_type'];
		$width=$data['screenshot']['width'];
        $height=$data['screenshot']['height'];
		if(!empty($mimeType) && !empty($imageData))
		    $this->screenShotSrc = 'data:'.$mimeType.';base64,'.$imageData;
        if(!empty($width))
            $this->screenShotWidth = $width;
        if(!empty($height))
            $this->screenShotHeight = $height;
    }   

    public function makeReadablePageInsight(){
	    if(isset($this->pageInsight)){
	        $speed=$this->pageInsight['ruleGroups']['SPEED']['score'];
	        unset(
                $this->pageInsight['id'],
                $this->pageInsight['responseCode'],
                $this->pageInsight['title'],
                $this->pageInsight['ruleGroups'],
                $this->pageInsight['version'],
                $this->pageInsight['screenshot'],
                $this->pageInsight['kind']
            );
	        $this->pageInsight['speed']=$speed;

            array_walk_recursive($this->pageInsight,array($this, 'processArray'));

            $this->optimizableResources=$this->optimizableResources['value'];
            foreach ($this->optimizableResources as $key => $value){
                if(stripos($value,'developers.google.com')!== false | stripos($value,'http')=== false)
                    unset($this->optimizableResources[$key]);
            }

	        foreach ($this->pageInsight['formattedResults']['ruleResults'] as $key => $rule){
	            if($rule['ruleImpact'] == 0) {
                    unset($this->pageInsight['formattedResults']['ruleResults'][$key]);
                    continue;
                }
	            unset(
	                $this->pageInsight['formattedResults']['ruleResults'][$key]['groups'],
                    $this->pageInsight['formattedResults']['ruleResults'][$key]['summary'],
                    $this->pageInsight['formattedResults']['ruleResults'][$key]['urlBlocks']
                );
	            if(!empty($this->pageInsight['formattedResults']['ruleResults'][$key]['localizedRuleName']))
	                $this->problemsList[]=$this->pageInsight['formattedResults']['ruleResults'][$key]['localizedRuleName'];
                if(!empty($this->pageInsight['formattedResults']['ruleResults'][$key]['ruleImpact']))
                    $this->impactsList[]=$this->pageInsight['formattedResults']['ruleResults'][$key]['ruleImpact'];
            }
        }
    }

    private function processArray($item, $key){
        if(isset($this->optimizableResources[$key]))
            $this->optimizableResources[$key][]=$item;

        else
            $this->optimizableResources[$key]=[$item];
    }
 }