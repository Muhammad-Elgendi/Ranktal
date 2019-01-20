<?php

namespace App\Core;

/**
 *
 * Developed by :
 * 	Muhammad Elgendi
 *
 * -Capabilities               -Return-type
 *
 * -alt                        -array
 * -emptyAlt                   -array
 * -altCount                   -integer
 * -imgCount                   -integer
 * -emptyAltCount              -integer
 * -hasImg                     -boolean
 * -hasEmptyAlt                -boolean
 * -hasAlt                     -boolean
 * -hasNoAltWithImg            -boolean
 * -hasGoodImg                 -boolean
 *
 **/

class Image{


    /**
     * holds all alt attributes
     * @var array
     */
	public $alt;

    /**
     * holds all Empty-alt-image src attributes
     * @var array
     */
	public $emptyAlt;

    /**
     * @var int
     */
	public $altCount;

    /**
     * @var int
     */
	public $imgCount;

    /**
     * @var int
     */
	public $emptyAltCount;

    /**
     * flag to indicate if the page has <IMG> tag or not
     * @var boolean
     */
	public $hasImg;

    /**
     * flag to indicate if the page has <IMG> tag and at least one alt attributes
     * @var boolean
     */
	public $hasAlt;

    /**
     * flag to indicate if the page has <IMG> tag and some of them doesn't alt
     * @var boolean
     */
	public $hasEmptyAlt;

    /**
     * flag to indicate if the page has <IMG> tag and all of them doesn't alt
     * @var boolean
     */
	public $hasNoAltWithImg;

    /**
     * flag to indicate if the page has all <IMG> tags with alt attributes
     * @var boolean
     */
	public $hasGoodImg;

    /**
     * Image constructor.
     * @param $html
     */
	function __construct($html){
		$this->setAlts($html);
		$this->setAltChecks();
	}

    /**
     * set alts and all counters
     * @param $html
     */
	private function setAlts($html){
		$doc =new \DOMDocument();
		libxml_use_internal_errors(true);
		$doc->loadHTML($html);
		libxml_use_internal_errors(false);
		$imageElement=$doc->getElementsByTagName('body')->item(0)->getElementsByTagName('img');
        $this->imgCount=$imageElement->length;
        for ($i=0;$i< $imageElement->length; $i++){
            $value = $imageElement->item($i)->getAttribute("alt");
            if (!empty($value))
                $this->alt[] = $value;
            else
                $this->emptyAlt[] = ['num' => ($i + 1), 'src' => ($imageElement->item($i)->getAttribute("src"))];
        }
        if(is_array($this->alt))
            $this->altCount = count($this->alt);
        else
            $this->altCount=0;

        if(is_array($this->emptyAlt))
            $this->emptyAltCount = count($this->emptyAlt);
        else
            $this->emptyAltCount=0;
	}

	private function setAltChecks(){

        $this->hasImg=($this->imgCount > 0) ? true : false;
        $this->hasEmptyAlt=($this->emptyAltCount > 0) ? true:false  ;
        $this->hasAlt=($this->altCount > 0) ? true:false  ;
        $this->hasNoAltWithImg=($this->imgCount>0 & $this->altCount==0) ? true : false ;
        $this->hasGoodImg=($this->altCount == $this->imgCount) ? true: false ;
	}

}