<?php

namespace App\Core;

/**
 *
 * Developed by :
 * 	Muhammad Elgendi
 *
 * -Capabilities               -Return-type   Type      -Column-name
 *
 * -h1                         -array
 * -h2                         -array
 * -h3                         -array
 * -h4                         -array
 * -h5                         -array
 * -h6                         -array
 * -hasH1                      -boolean
 * -hasH2                      -boolean
 * -hasH3                      -boolean
 * -hasH4                      -boolean
 * -hasH5                      -boolean
 * -hasH6                      -boolean
 * -countH1                    -integer
 * -countH2                    -integer
 * -countH3                    -integer
 * -countH4                    -integer
 * -countH5                    -integer
 * -countH6                    -integer
 * -hasManyH1                  -boolean
 * -hasGoodHeadings            -boolean
 *
 **/

class Heading{

    /**
     * holds html code of page
     * @var string
     */
	private $html;

    /**
     * each one has an array of its heading
     * @var array
     */
	public $h1;
	public $h2;
	public $h3;
	public $h4;
	public $h5;
	public $h6;

    /**
     * flags to indicate the existence of each heading
     * @var bool
     */
    public $hasH1;
    public $hasH2;
    public $hasH3;
    public $hasH4;
    public $hasH5;
    public $hasH6;

    /**
     * The count of elements of each heading
     * @var int
     */
    public $countH1;
    public $countH2;
    public $countH3;
    public $countH4;
    public $countH5;
    public $countH6;

    /**
     * flag indicate if there are many H1 tags in page
     * @var bool
     */
    public $hasManyH1;

    /**
     * flag indicate if there is a good implementation of headings in page
     * @var bool
     */
    public $hasGoodHeadings;

    /**
     * Heading constructor.
     * @param $html
     */
	function __construct($html){
		$this->html=$html;
		$this->setHeadings();
        $this->setCount();
		$this->setHeadingsChecks();
	}

    /**
     * Sets the heading arrays
     */
	private function setHeadings(){
		$doc =new \DOMDocument();
		libxml_use_internal_errors(true);
		$doc->loadHTML($this->html);
		libxml_use_internal_errors(false);
		$headingTags=array('h1','h2','h3','h4','h5','h6');
		foreach ($headingTags as $headingTag) {
			$hElement=$doc->getElementsByTagName('body')->item(0)->getElementsByTagName($headingTag);
            for ($i=0; $i < $hElement->length ; $i++) {
                $this->$headingTag[]=$hElement->item($i)->nodeValue;
            }
		}	
	}

    /**
     * Sets the count of each heading
     */
	private function setCount(){

        if(is_array($this->h1))
            $this->countH1 = count($this->h1);
        else
            $this->countH1=0;

        if(is_array($this->h2))
            $this->countH2 = count($this->h2);
        else
            $this->countH2=0;

        if(is_array($this->h3))
            $this->countH3 = count($this->h3);
        else
            $this->countH3=0;

        if(is_array($this->h4))
            $this->countH4 = count($this->h4);
        else
            $this->countH4=0;

        if(is_array($this->h5))
            $this->countH5 = count($this->h5);
        else
            $this->countH5=0;

        if(is_array($this->h6))
            $this->countH6 = count($this->h6);
        else
            $this->countH6=0;

	}

    /**
     * set Headings Checks
     */
	private function setHeadingsChecks(){
        $this->hasManyH1 = ($this->countH1 > 1) ? true : false;
        $this->hasGoodHeadings = ($this->countH1 > 0 & $this->countH2 > 0 & $this->countH3 > 0) ? true : false;
        $this->hasH1=($this->countH1 != 0) ? true : false;
        $this->hasH2=($this->countH2 != 0) ? true : false;
        $this->hasH3=($this->countH3 != 0) ? true : false;
        $this->hasH4=($this->countH4 != 0) ? true : false;
        $this->hasH5=($this->countH5 != 0) ? true : false;
        $this->hasH6=($this->countH6 != 0) ? true : false;
    }
}