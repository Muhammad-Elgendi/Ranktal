<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Core\PageScraper;
use App\Core\PageConnector;
use App\Core\PageChecker;
use App\Page;
use App\Html;


class checkerController extends Controller
{
    //

    public function findOrCreateCheck(Request $request){
        $inputUrl = $request->get('q');
        $connector =new PageConnector($inputUrl);
        $connector->connectPage();
        if(!$connector->isGoodUrl){
            return "Not Valid URL";
        }
        $connector->setIsGoodStatus();       
        // $connector->httpCodes;
        // $connector->urlRedirects;

        $foundPage = Page::where('url', $connector->url)->first();

        if ($foundPage === null) {
            // page doesn't exist

            $scraper =new PageScraper($connector->url,$connector->parsedUrl,end($connector->httpCodes),$connector->header,$connector->doc);
            $cacheKey = md5($scraper->parsedUrl["host"].'/robots.txt');
            $minutes = 600;
            $robotsContent = Cache::remember($cacheKey, $minutes, function () use ($scraper){
                return $scraper->getRobots();
            });
            $scraper->setRobotsContent($robotsContent);
    
            $class_methods = get_class_methods($scraper);
    
            foreach ($class_methods as $method_name) {
                if($method_name != "__construct" && $method_name != "setRobotsContent")
                    $scraper->$method_name();
            }

            $page = new Page();

            foreach($scraper as $key => $value) {
                $page->$key = $value;
            }

            $page->save();

            $html =new Html();
            $html->page_id = $page->id;
            $html->header = $connector->header;
            $html->doc = $connector->doc;
            $html->save();

            return $this->doChecks($scraper);
        }else{
            $foundPage = json_decode($foundPage->toJson(),true);
            return $this->doChecks($foundPage);
        }

        // var_dump(get_object_vars($connector));
        // var_dump(get_object_vars($scraper));

        // var_dump(Cache::get($cacheKey));
    }

    /**
     * Accept the Raw Scraper Object Or An array and
     * return well formatted JSON
     */
    private function doChecks($obj){
        $checker =new PageChecker($obj);
        $class_methods = get_class_methods($checker);

        foreach ($class_methods as $method_name) {
            if($method_name != "__construct")
                $checker->$method_name();
        }
        /**
         * JSON_PRETTY_PRINT |JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE together
         * more at http://php.net/manual/en/json.constants.php
         */
        return json_encode($checker,JSON_PRETTY_PRINT |JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }
}
