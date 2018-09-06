<?php
namespace App\Core;
/**
 *
 * Developed by :
 * 	Muhammad Elgendi
 *
 * -Capabilities   -Properties    -Return-type  Type (Conditional-output) -Column-name
 * 	-check existence   -hasTitle       -boolean field
 * 	-check duplication -duplicateTitle -boolean field
 * 	-check length(s)   -checkLength    -boolean field (var or array) -checkLengthTitle
 * 	-get length(s)     -length         -integer field (var or array) -lengthTitle
 * 	-get title(s)      -title          -string  field (var or array)
 * 	-make final check  -check          -boolean function             -checkTitle
 *
 **/

class Title{

	/*
	 *  flag to indicate is there a title tag
	 */
	public $hasTitle;

	/*
	 *  flag to indicate is there many title tag
	 */
	public $duplicateTitle;

	/*
	 *  holds a variable or an array corresponding to titles
	 */
	public $title;

	/*
	 *  holds a variable or an array corresponding to lengths
	 */
	public $length;

	/*
	 *  holds a variable or an array corresponding to check_length foreach title
	 */
	public $checkLength;


    /**
     * Title constructor.
     * @param $html_code
     */
    function __construct($html_code){
		$doc = new \DOMDocument;
		libxml_use_internal_errors(true);
		$doc->loadHTML($html_code);
		libxml_use_internal_errors(false);

		/*
		 *  getting title tags count
		 */
		$count = $doc->getElementsByTagName('head')->item(0)->getElementsByTagName('title')->length;

		/*
		 *  set hasTitle
		 */
		if($count == 0)
			$this->hasTitle=false;
		else
			$this->hasTitle=true;

		/*
		 *  set duplicateTitle
		 */
		if($count > 1)
			$this->duplicateTitle=true;
		else
			$this->duplicateTitle=false;

		/*
		 *  get title and length and its check if one title only
		 *  is found and return a var for each parameter
		 */
		if($count == 1){
			$this->title=$doc->getElementsByTagName('head')->item(0)->getElementsByTagName('title')->item(0)->nodeValue;

			$this->length=mb_strlen($this->title,'utf8');
			$this->checkLength= ($this->length < 10 && $this->length > 60) ? false:true;
		}

		/*
		 *  get title and length and its check if many titles
		 *  are found and return an array for each parameter
		 */
		else if($count > 1){
			$titles=$doc->getElementsByTagName('head')->item(0)->getElementsByTagName('title');
			
			for ($i=0; $i < $count ; $i++) {
				$this->title[$i] = $titles->item($i)->nodeValue;
				$this->length[$i] = mb_strlen($this->title[$i],'utf8');
				$this->checkLength[$i]= ($this->length[$i] < 10 && $this->length[$i] > 60) ? false:true;
			}
		}		
	}

	/*
	 *  checks all lengths and return true on success or false on failure
	 */
	private function check_length(){
		$return=true;
		if (is_array($this->checkLength)){			
			foreach ($this->checkLength as $item) {			
				if($item === false){
					$return=false;
					break;
				}
			}
		}
		else
			$return=($this->checkLength === false) ? false : true;
		return $return;		
	}

	/*
	 *  make a final check (Right or false for the whole test)
	 */
	function check(){
		return $this->hasTitle && !$this->duplicateTitle && $this->check_length();
	}
}