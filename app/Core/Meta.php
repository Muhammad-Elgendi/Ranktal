<?php

namespace App\Core;

/**
 *
 * Developed by :
 * 	Muhammad Elgendi
 *
 * -Capabilities               -Return-type   Type      -Column-name
 *
 * * Note :
 * all get calls can now access publicly from the outside
 *
 * 	-get('description')        -string        function  -descriptionMata
 *  -get('keywords')           -string        function  -keywordsMeta
 *  -get('viewport')           -string        function  -viewportMeta
 * 	-get('robots')             -string        function  -robotsMeta
 *  -get('news_keywords')      -string        function  -news_keywordsMeta
 *  -get('lengthDescription')  -integer       function  -lengthDescription
 *  -get('lengthKeywords')     -integer       function  -lengthKeywords
 *  -get('lengthNews_keywords')-integer       function  -lengthNews_keywords
 *  -get('descriptionCount')   -integer       function  -descriptionCount
 *  -get('keywordsCount')      -integer       function  -keywordsCount
 *  -get('news_keywordsCount') -integer       function  -news_keywordsCount
 *  -hasDescription            -boolean          field  -
 *  -duplicateDescription      -boolean          field  -
 *  -hasKeywords               -boolean          field  -
 *  -duplicateKeywords         -boolean          field  -
 *  -hasRobots                 -boolean          field  -
 *  -hasViewport               -boolean          field  -
 *  -hasNews_keywords          -boolean          field  -
 *  -duplicateNews_keywords    -boolean          field  -
 * 	-getAll()                  -array         function  -metas
 *  -checkLengthDescription()  -boolean       function  -checkLengthDescription
 *  -checkDescription()        -boolean       function  -checkDescription
 *
 * Notes :
 *
 *  lack of check robots and the follow and index for the page
 *
 **/

class Meta{

    /**
     * @var string
     */
	private $html;

    /**
     * @var array
     */
	public $metas;

    /**
     * @var bool
     */
	public $hasDescription;

    /**
     * @var string
     */
    public $description;

    /**
     * flag to indicate if Description is duplicated
     * @var bool
     */
    public $duplicateDescription;

    /**
     * @var int
     */
    public $lengthDescription;

    /**
     * @var bool
     */
    public $hasKeywords;

    /**
     * @var string
     */
	public $keywords;

    /**
     * flag to indicate if keywords is duplicated
     * @var bool
     */
    public $duplicateKeywords;

    /**
     * @var int
     */
    public $lengthKeywords;

    /**
     * @var bool
     */
    public $hasNews_keywords;

    /**
     * @var bool
     */
    public $duplicateNews_keywords;

    /**
     * @var int
     */
    public $lengthNews_keywords;

    /**
     * @var string
     */
    public $news_keywords;

    /**
     * @var string
     */
	public $viewport;

    /**
     * @var string
     */
	public $robots;

    /**
     * @var int
     */
	public $descriptionCount;

    /**
     * @var int
     */
	public $keywordsCount;

    /**
     * @var int
     */
	public $news_keywordsCount;

    /**
     * @var bool
     */
	public $hasRobots;

    /**
     * @var bool
     */
	public $hasViewport;

    /**
     * Meta constructor.
     * @param $url
     * @param $html
     */
	function __construct($url,$html){
		$this->metas=get_meta_tags($url);
		$this->html=$html;
		$this->setDescription();
		$this->setKeywords();
		$this->setNews_keywords();
		$this->setViewport();
		$this->setRobots();				
	}

    /**
     * return the count of words if the meta tag was found
     * @param $name
     * @return bool|int
     */
	private function getWordCount($name){
		if(isset($this->metas[$name])){

            // ' ' or ','
            $pattern = '/ |,/i';

            // split it in an array, so we have the count of words
            $array = preg_split($pattern, $this->metas[$name],-1, PREG_SPLIT_NO_EMPTY);

            return count($array);
		}
		return false;
	}

    /**
     * sets the description
     * and word count
     * sets the hasDescription
     * @return bool
     */
	private function setDescription(){
		if(isset($this->metas['description'])){
			$doc = new \DOMDocument;
			libxml_use_internal_errors(true);
			$doc->loadHTML($this->html);
			libxml_use_internal_errors(false);		
			$items = $doc->getElementsByTagName('head')->item(0)
			->getElementsByTagName('meta');
			$counter=0;
			foreach ($items as $item) {
				if ($item->getAttribute('name') == 'description')
	            $counter++;	        	
			}
            /**
             * check description duplication
             */
			if ($counter>1)
				$this->duplicateDescription=true;
			else
                $this->duplicateDescription=false;

            /**
             * set description
             * and its word count
             */
			$this->description=$this->metas['description'];
			$this->descriptionCount=$this->getWordCount('description');
			$this->hasDescription=true;
            $this->lengthDescription=mb_strlen($this->description, 'utf8');
		}
		else {
            $this->hasDescription = false;
            $this->duplicateDescription=false;
        }
	}

    /**
     * returns the result check of Description length
     * @return bool
     */
	 function checkLengthDescription(){
		if(isset($this->description)) {
            if ($this->lengthDescription > 160 | $this->lengthDescription < 70)
                return false;
            else
                return true;
        }
		else
			return false;
	}

    /**
     * make Description full check
     * @return bool
     */
	 function checkDescription(){
	    return $this->checkLengthDescription() && $this->hasDescription && !$this->duplicateDescription;
    }

    /**
     * sets the keywords
     * and word count
     * sets the hasKeywords
     * @return bool
     */
	private function setKeywords(){
		if(isset($this->metas['keywords'])){
			$doc = new \DOMDocument;
			libxml_use_internal_errors(true);
			$doc->loadHTML($this->html);
			libxml_use_internal_errors(false);		
			$items = $doc->getElementsByTagName('head')->item(0)
			->getElementsByTagName('meta');
			$counter=0;
			foreach ($items as $item) {
				if ($item->getAttribute('name') == 'keywords')
	            $counter++;	        	
			}

            /**
             * check keywords duplication
             */
			if ($counter>1)
				$this->duplicateKeywords=true;
			else
			    $this->duplicateKeywords=false;

            /**
             * set keywords
             * and its word count
             */
			$this->keywords=$this->metas['keywords'];
			$this->keywordsCount=$this->getWordCount('keywords');
			$this->hasKeywords=true;
			$this->lengthKeywords=mb_strlen($this->keywords, 'utf8');
		}
		else {
            $this->hasKeywords = false;
            $this->duplicateKeywords=false;
        }
	}


    /**
     * sets the news_keywords
     * and word count
     * sets the hasNews_keywords
     * @return bool
     */
    private function setNews_keywords(){
        if(isset($this->metas['news_keywords'])){
            $doc = new \DOMDocument;
            libxml_use_internal_errors(true);
            $doc->loadHTML($this->html);
            libxml_use_internal_errors(false);
            $items = $doc->getElementsByTagName('head')->item(0)
                ->getElementsByTagName('meta');
            $counter=0;
            foreach ($items as $item) {
                if ($item->getAttribute('name') == 'news_keywords')
                    $counter++;
            }

            /**
             * check news_keywords duplication
             */
            if ($counter>1)
                $this->duplicateNews_keywords=true;
            else
                $this->duplicateNews_keywords=false;

            /**
             * set news_keywords
             * and its word count
             */
            $this->news_keywords=$this->metas['news_keywords'];
            $this->news_keywordsCount=$this->getWordCount('news_keywords');
            $this->hasNews_keywords=true;
            $this->lengthNews_keywords=mb_strlen($this->news_keywords, 'utf8');
        }
        else {
            $this->hasNews_keywords = false;
            $this->duplicateNews_keywords=false;
        }
    }



    /**
     * sets viewport
     * sets hasViewport
     * @return bool
     */
	private function setViewport(){
		if(isset($this->metas['viewport'])){

			$this->viewport=$this->metas['viewport'];
			$this->hasViewport=true;

		}
		else
            $this->hasViewport=false;
	}

    /**
     * sets robots
     * sets hasRobots
     * @return bool
     */
	private function setRobots(){
		if(isset($this->metas['robots'])){
			
			$this->robots=$this->metas['robots'];
			$this->hasRobots=true;
						
		}
		else
            $this->hasRobots=false;
	}
}