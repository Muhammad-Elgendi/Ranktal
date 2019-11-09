<?php
namespace App\Core;
require_once 'vendor/autoload.php';
use App\Core\simple_html_dom;

/**
 * 19 SERP Features

  ✓ Adwords (Bottom)
  ✓ Adwords (Top)     
  Featured Snippet
  Local Pack
  Reviews
  AMP
  Site Links
  Video
  Featured video
  News Box (Top Stories) 
  Image Pack (Images)
  Tweet (Twitter)
  Instant answer
  Knowledge Panel
  In-Depth Article
  Knowledge Card
  Shopping Results (  Shopping ads )
  Local Teaser Pack
  Related Questions ( People also ask )

  * + organic

 */
class GoogleParser{
    private $dom;

    // the object that have all parsed elements from serps html
    private $json = [];
    // json state is a flag that tells getJson() to not create json property
    private $jsonState = false;

    private $excutableMethods =[
        'getStats',
        'getOrganicResults',
        'getAdwordsTop',
        'getAdwordsBottom'
    ];

    public function __construct($html){
        // Create a DOM object
        $this->dom = new simple_html_dom();
        // Load HTML from a string
        $this->dom->load($html);    
    }

    private function find($selector,$idx = null, $proberty = null, &$dom = null, $lowercase = false){
        $element_query = null;
        if($dom == null){
            $element_query = $this->dom->find($selector, $idx, $lowercase);
        }else{
            $element_query = $dom->find($selector, $idx, $lowercase);
        }
        
        if($element_query != null){
            if($proberty == null){
                return $element_query;
            }else if(is_array($proberty)){
                $result = [];
                foreach($proberty as $key => $item){
                    $result[$key] = $element_query->$item;
                }
                return $result;
            }else           
                return $element_query->$proberty;               
        }
    }

    // Get the number of results and the time to conduct the search
    public function getStats(){
        // #resultStats
        // About 1,950,000,000 results (0.64 seconds) 
        $stats = $this->find('#resultStats','plaintext');
        if(empty($stats)){
            return;
        }
        $temp = explode('(',$stats);
        $results=(float) filter_var( $temp[0], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_THOUSAND );
        $seconds=(float) filter_var( $temp[1], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION );
        return compact('results','seconds');
    }

    // Get nutural organic results
    public function getOrganicResults(){
        /**
         * divclass="g"
            * divclass="rc"
                * divclass="r" a -link
                * divclass="r" a h3 -title
                * divclass="s" description + review + votes
                    * divclass="slp f" Rating: 4 - ‎365 votes
                    * <span class="st"> description
                    * <div class="osl"> a links undder description
           *     <table class="nrgt">
           *        <tbody>
           *            <tr class="mslg dmenKe">
           *                <td>
           *                    <div class="sld vsc">
           *                        <span class="cNifBc">
           *                            <h3 class="r">
           *                                <a class="l" href="https://www.thepurplestore.com/html">
           *                                     Categories
           *                                </a> - link and title
           *                            </h3>
           *                        </span>
        *                           <div class="s">
        *                               <div class="st">The Purple Store's page of all </div> - description
        *                           </div>
        *                       </div>
        *                   </td>
        *               </tr>
        *           </tbody>
        *       </table>
         */
        $count = 0;
        $serps = [];
        $results = $this->dom->find('div[class=g]');
        if(empty($results)){
            return;
        }
        foreach($results as $result){
           $block = [];
        
           $block['link'] = $this->find('div[class=rc] div[class=r] a',0,'herf',$result);
           $block['title'] = $this->find('div[class=rc] div[class=r] a',0,'plaintext',$result);
           $block['description'] = $this->find('div[class=rc] div[class=s] span[class=st]',0,'plaintext',$result);
           $block['ratingAndVotesAndPrice'] = $this->find('div[class=rc] div[class=s] div[class=slp f]',0,'plaintext',$result);

           $links = $result->find('div[class=rc] div[class=s] div[class=osl] a');
           foreach($links as $link){
               $block['links'][] = ['link' => $link->href , 'text' => $link->plaintext ];
           }
           //   site sections
           $sections = $result->find('table[class=nrgt] tr');
           foreach($sections as $section){
               $link = $section->find('a[class=l]',0);
               $description = $section->find('div[class=s] div[class=st]',0);
               $block['sections'][] = ['link' => $link->href ,
                                        'text' => $link->plaintext ,
                                        'description' => $description->plaintext ];
           }
            //    Add this block to serps
           if(!empty($block['title'])){
                $block['rank']= ++$count;               
                $serps[]=$block;
           }   
        }
        return $serps;
    }

    // Get Adwords Top results
    public function getAdwordsTop(){

        /**
         * <div id="tads" aria-label="Ads"> 
         *      <ol>
         *          <li class="ads-ad">
         *              <h3> first h3 has title
            *             <div class="ads-visurl">
            *                 <span class="VqFMTc NceN9e">Ad</span>
            *                 <cite class="UdQCqe">www.dreamhost.com/web-hosting</cite>  has url
            *              ‎</div>
         *              <div class="I6vAHd h5RoYd ads-creative"> has description
         *              <ul class="OkkX2d"> has links under site
         *                  <li>
         *                      <a class="V0MxL"  href="https://firebase.google.com/pricing/">
         *                          Firebase Pricing Plans
         *                      </a>
         *                  </li>
         */
        $count = 0;
        $serps = [];
        $ads = $this->dom->find('div[id=tads] ol li[class=ads-ad]');
        if(empty($ads)){
            return;
        }
        foreach($ads as $ad){
            $block = [];
            $block['rank']= ++$count;
            $block['title'] = $this->find('h3',0,'plaintext',$ad);
            $block['url'] = $this->find('div[class=ads-visurl] cite',0,'plaintext',$ad);
            $block['description'] = $this->find('div[class=ads-creative]',0,'plaintext',$ad);
            $links = $ad->find('ul[class=OkkX2d] li a');
            foreach($links as $link){
                $block['links'][] = ['link' => $link->href , 'text' => $link->plaintext ];
            }
             //    Add this block to serps
            $serps[]=$block;
        }
        return $serps;
    }

    // Get Adwords Bottom results
    public function getAdwordsBottom(){
   
        /**
         * <div id="tadsb" aria-label="Ads"> 
         *      <ol>
         *          <li class="ads-ad">
         *              <h3> first h3 has title
            *             <div class="ads-visurl">
            *                 <span class="VqFMTc NceN9e">Ad</span>
            *                 <cite class="UdQCqe">www.dreamhost.com/web-hosting</cite>  has url
            *              ‎</div>
         *              <div class="I6vAHd h5RoYd ads-creative"> has description
         *              <ul class="OkkX2d"> has links under site
         *                  <li>
         *                      <a class="V0MxL"  href="https://firebase.google.com/pricing/">
         *                          Firebase Pricing Plans
         *                      </a>
         *                  </li>
         */
        $count = 0;
        $serps = [];
        $ads = $this->dom->find('div[id=tadsb] ol li[class=ads-ad]');
        if(empty($ads)){
            return;
        }
        foreach($ads as $ad){
            $block = [];
            $block['rank']= ++$count;
            $block['title'] = $this->find('h3',0,'plaintext',$ad);
            $block['url'] = $this->find('div[class=ads-visurl] cite',0,'plaintext',$ad);
            $block['description'] = $this->find('div[class=ads-creative]',0,'plaintext',$ad);
            $links = $ad->find('ul[class=OkkX2d] li a');
            foreach($links as $link){
                $block['links'][] = ['link' => $link->href , 'text' => $link->plaintext ];
            }
             //    Add this block to serps
            $serps[]=$block;
        }
        return $serps;
    }

    public function getFeaturedSnippets(){
        /**
         * is feature snippet exits search for span.hELpae>a

         * div.c2xzTb
         *      g ct-active
         *          div class="rc"  
         *              <div class="r ct-active"><a href="https://www.wikihow.com/" >
         *                  <h3 class="LC20lb">How to Catch a Pokémon in Any Game - wikiHow</h3>
         * 
         */

    }

    // produce all parsed elements in associative array 
    public function getJson(){
        if($this->jsonState){
            return $this->json;
        }

        $class_methods = get_class_methods($this);

        foreach ($class_methods as $method_name) {
            if(!in_array($method_name,$this->excutableMethods)){
                continue;
            }
            $temp = $this->$method_name();
            if(!empty($temp)){
                $this->json[ltrim($method_name,'get')] = $temp;
            }
        }
        unset($this->excutableMethods);
        $this->jsonState = true;     
        return $this->json;
    }


}