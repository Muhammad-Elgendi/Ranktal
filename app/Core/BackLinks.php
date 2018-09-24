<?php
namespace App\Core;
require_once 'Moz.php';
require_once 'vendor/autoload.php';
require_once '../../vendor/autoload.php';
require_once "../../vendor/laravel/framework/src/Illuminate/Foundation/helpers.php";

$dotenv = new \Dotenv\Dotenv(dirname(dirname(__DIR__)));
$dotenv->load();

$p =new BackLinks("https://is.net.sa");

$class_methods = get_class_methods($p);

foreach ($class_methods as $method_name) {
    if($method_name != "__construct")
        $p->$method_name();
}

var_dump(get_object_vars($p));
/**
 *
 * Developed by :
 * 	Muhammad Elgendi
 *
 * BackLinks constructor.
 * @param $url
 *
 * Request URL Example :
 * http://lsapi.seomoz.com/linkscape/url-metrics/moz.com%2fblog?Cols=4&AccessID=member-cf180f7081&Expires=1225138899&Signature=LmXYcPqc%2BkapNKzHzYz2BI4SXfC%3D
 *
 *
 * Cols=103079266336
 *
 * Access ID:mozscape-b8c7023e7a
 *
 * Secret Key:5ec326509fe6cc73fd0333c67022a273
 *
 **/


/**
 * Class BackLinks
 * @package App\Core
 */
class BackLinks{

    private $url;
    //holds the Domain name of site
	private $domain;
    /**
     * holds the response of mozLinks
     * @var
     */
	public $backlinks;
    /**
     * holds the response of openLinkProfiler
     * @var
     */
    
    /**
     * BackLinks constructor.
     * @param $url
     */
	function __construct($url){
        $this->url=$url;
        $this->domain=parse_url($this->url, PHP_URL_HOST);		
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

	/*
		Currently the request is set to page_to_domain means that it shows all backlinks that refer to the domain of URL not Just the Page

		and I set the limit of links to 10

		also this api brings the anchor text of the link and shows Dofollow links only

		also it sorts the results om page authority high first
	*/
	public function setMozLinks(){
		//it takes accessID,secretKey,Time_to_expire
        $id = env('MOZ_ID', 'mozscape-b8c7023e7a');
        $secret = env('MOZ_SECRET', '5ec326509fe6cc73fd0333c67022a273');
        $expire = env('MOZ_EXPIRE', 300);
		$test=new Moz($id,$secret,$expire);
		$test->setURL($this->url);		
		$test->sendRequest('links');//get mozLinks
		$response=$test->getRawResponse();		
		if($response){
            /**
             * lt   ->  Anchor Text
             * lrid ->  Internal ID of the link
             * lsrc ->  Internal ID of the source URL
             * ltgt ->  Internal ID of the target URL
             * luuu	->  The canonical form of the target URL
             * uu	->  The canonical form of the source URL
                (OR, for url-metrics calls, the canonical form of the target URL)
            */
            foreach ($response as $link){
                $this->backlinks[] = ['Anchor Text' => $link['lt'],
                                      'Target URL'  => $link['luuu'],
                                      'Source URL'  => $link['uu']];             
            }
		}
	}
   
    /**
     * set alexa backLinks if succeed
     */
	public function setAlexaBackLinks(){
        //form the request url
        $requestUrl = 'https://www.alexa.com/siteinfo/' . $this->domain;
        $content = $this->makeConnection($requestUrl);
        if ($content) {
            // search for "sites liking in"
            $doc = new \DOMDocument;
            libxml_use_internal_errors(true);
            $doc->loadHTML($content);
            libxml_use_internal_errors(false);
            try {
                $anchors = $doc->getElementsByTagName('table')->item(3)->getElementsByTagName('a');
                foreach ($anchors as $anchor) {
                    $link = $anchor->getAttribute('href');
                    if (stripos($link, 'siteinfo/') === false)
                        $this->backlinks[]['Source URL'] = $link;
                }
            }
            catch (\Exception $e) {
                return;
            }
        }
    }
}