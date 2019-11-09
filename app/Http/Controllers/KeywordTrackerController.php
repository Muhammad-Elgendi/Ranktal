<?php

namespace App\Http\Controllers;

use App\Core\GoogleParser;
use Illuminate\Http\Request;
use App\Core\simple_html_dom;
use App\serp;
use Carbon\Carbon;
use Serps\SearchEngine\Google\Page\GoogleSerp;

class KeywordTrackerController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }

    // View Method
    public function index()
    {
        return view('dashboard.keywordTracker');
    }

    public function viewkeywordTrackerUsingAjax(Request $request)
    {
        if (!$request->ajax()) {
            return "This page is not for you";
        }
        // Twitter @VorticonCmdr.
        // Thanks to a tweet from @Aleyda Solis about the Chrome Sensor option, which sparked a lot of replies, 
        // I found out about the possibility to use the GET-parameters UULE (location), hl (language) and gl (region).
        $url = $request->get('u');
        $keyword = $request->get('k');
        $engine = $request->get('e');
        $device = $request->get('d');
        $language = $request->get('l');
        $country = strtolower($request->get('c'));
        $latitude = $request->get('lat');
        $longitude = $request->get('long');
        $location = $request->get('uule');

        // Validate keyword and parameters and trim them

        if ($engine == 'google') {
            $latest_serp = null;
            // check if serps exist in DB
            $serp = serp::where('keyword', $keyword)->where('engine', 'google')->where('created_at', '>=', Carbon::now()->subDay(1))
                ->latest()->first();
            // serp doesn't exist in DB
            if ($serp == null) {
                $serp = [];
                while (empty($serp)) {
                    $serp = $this->getparsedGoogleSerp($keyword, $device, $language, $country, $latitude, $longitude, $location);
                }
                // save serp
                $newserp = new serp();
                $newserp->keyword = $keyword;
                $newserp->engine = 'google';
                $newserp->serps = json_encode($serp);
                $newserp->save();
            }

            // Get all old postions for that site in serps and show them in chart to user
            $AllSerps = serp::where('keyword', $keyword)->where('engine', 'google')->latest()->get();
            $postions = [];
            // Timestamp : postion
            if (!$AllSerps->isEmpty()) {
                // get site postion from each serp
                foreach ($AllSerps as $item) {
                    $json =  json_decode($item);
                    // loop over pages
                    foreach($json as $page){
                        // get organic results
                        foreach ($json->results as $postion) {
                            if (stripos($postion->site, $url) !== false) {
                                if ($latest_serp == null) {
                                    $latest_serp = $postion;
                                }
                                $date = Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at)->format('Y-m-d');
                                $postions[] = [$date, $postion->rank];
                                break;
                            }
                        }
                    }                 
                }
            }
            return compact('latest_serp', 'postions');
        } else if ($engine == 'bing') {
            $latest_serp = null;
            // check if serps exist in DB
            $serp = serp::where('keyword', $keyword)->where('engine', 'bing')->where('created_at', '>=', Carbon::now()->subDay(1))
                ->latest()->first();
            // serp doesn't exist in DB
            if ($serp == null) {
                $serp = [];
                while (empty($serp)) {
                    $serp = $this->getparsedBingSerp($keyword, $device, $language, $country, $latitude, $longitude);
                }
                // save serp
                $newserp = new serp();
                $newserp->keyword = $keyword;
                $newserp->engine = 'bing';
                $newserp->serps = json_encode($serp);
                $newserp->save();
            }

            // Get all old postions for that site in serps and show them in chart to user
            $AllSerps = serp::where('keyword', $keyword)->where('engine', 'bing')->latest()->get();
            $postions = [];
            // Timestamp : postion
            if (!$AllSerps->isEmpty()) {
                // get site postion from each serp
                foreach ($AllSerps as $item) {
                    $json =  json_decode($item->serps);
                    foreach ($json->results as $postion) {
                        if (stripos($postion->site, $url) !== false) {
                            if ($latest_serp == null) {
                                $latest_serp = $postion;
                            }
                            $date = Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at)->format('Y-m-d');
                            $postions[] = [$date, $postion->rank];
                            break;
                        }
                    }
                }
            }
            return compact('latest_serp', 'postions');
        }
    }

    private function getparsedGoogleSerp($keyword, $device, $language, $country, $latitude, $longitude, $location)
    {

        $htmlAndProxyAndUrl = BrowserController::getGoogleSerp($keyword, $device, $language, $country, $latitude, $longitude, $location);
        $htmls = $htmlAndProxyAndUrl['html'];
        $proxy = $htmlAndProxyAndUrl['proxy'];
        $results = [];

        // parse each html
        foreach ($htmls as $key => $html) {

            $parser = new GoogleParser($html);
            $temp = $parser->getJson();
            if (!empty($temp)) {
                $results['Page '.$key + 1] = $temp;
            }
        }

        // update proxy status
        if (empty($results)) {
            $proxy->google_pass = false;
            $proxy->save();
        } else {
            $proxy->google_pass = true;
            $proxy->save();
        }
        return $results;
    }

    private function getparsedBingSerp($keyword, $device, $language, $country, $latitude, $longitude)
    {

        //    result count <span class="sb_count" data-bm="4">18,400,000 results</span>
        // results <ol id="b_results">
        /**
         * <li class="b_algo" data-bm="8">
         *  <h2>
         *      <a href="https://www.link-assistant.com/" h="ID=SERP,5104.1">
         *          All-In-One SEO Software &amp; SEO Tools | SEO PowerSuite
         *      </a>
         *  </h2>
         * <div class="b_caption">
         *      <div class="b_attribution" u="0|5048|4549079082538227|ZnZvo-Cc2rcUruLdarnXG2J66tBX3RaA">
         *          <cite>
         *              https://www.link-assistant.com
         *          </cite>
         *      <a href="#" aria-label="Actions for this site" aria-haspopup="true" aria-expanded="false" role="button">
         *          <span class="c_tlbxTrg">
         *              <span class="c_tlbxTrgIcn sw_ddgn"></span>
         *              <span class="c_tlbxH" h="BASE:CACHEDPAGEDEFAULT" k="SERP,5105.1"></span>
         *          </span>
         *      </a>
         *      </div>
         *      <p>
         *          Get all <strong>SEO</strong> tools in one pack - download free edition of <strong>SEO</strong> PowerSuite and get top 10 rankings for your site on Google and other search engines!
         *      </p>
         * </div>
         * </li>
         * 
         * Related searches
         * <ul class="b_vList">
         * <li>
         * <a href="/search?q=top+seo+software&amp;FORM=R5FD" h="ID=SERP,5323.1">
         * <strong>top</strong> seo software
         * </a>
         * </li>
         * ....
         * </ul>
         * 
         * Next Page 
         *  <a class="sb_pagN sb_pagN_bp b_widePag sb_bp b_roths">
         * sb_pagN sb_pagN_bp b_widePag sb_bp 
         * sb_pagN sb_pagN_bp b_widePag sb_bp 
         * 
         * 
         */

        // Create a DOM object
        $dom = new simple_html_dom();
        $results = [];
        $rank = 0;
        $suggests = [];

        $htmlAndProxy = BrowserController::getBingSerp($keyword, $device, $language, $country, $latitude, $longitude);
        $htmls = $htmlAndProxy['html'];
        $proxy = $htmlAndProxy['proxy'];

        // parse each html
        foreach ($htmls as $key => $html) {
            // Load HTML from a string
            $dom->load($html);

            if ($key == 0) {

                // get results count
                $count_query = $dom->find('span[class=sb_count]', 0);
                if ($count_query != null) {
                    $count = $dom->find('span[class=sb_count]', 0)->plaintext;
                    $count = explode(' ', $count)[0];
                }

                // Get Related searches
                $related = $dom->find('ul[class=b_vList] li');

                foreach ($related as $item) {
                    $element_query = $item->find('a', 0);
                    if ($element_query != null) {
                        $suggests[] = $element_query->plaintext;
                    }
                }
            }

            // Get serps results
            $serp = $dom->find('ol[id=b_results] li[class=b_algo]');

            foreach ($serp as $postion) {
                $rank++;
                $title = $site = $description = null;
                $element_query = $postion->find('h2 a', 0);
                if ($element_query != null) {
                    $title = $element_query->plaintext;
                    $site = $element_query->href;
                }
                $description_query = $postion->find('div[class=b_caption] p', 0);
                if ($description_query != null) {
                    $description = $description_query->plaintext;
                }
                $results[] = ['rank' => $rank, 'title' => $title, 'site' => $site, 'description' => $description];
            }
        }

        // generate bing array
        $bing = [];
        if (!empty($count)) {
            $bing['count'] = $count;
        }
        if (!empty($results)) {
            $bing['results'] = $results;
        }
        if (!empty($suggests)) {
            $bing['suggests'] = $suggests;
        }

        // update proxy status
        if (empty($bing)) {
            $proxy->bing_pass = false;
            $proxy->save();
        } else {
            $proxy->bing_pass = true;
            $proxy->save();
        }
        return $bing;
    }

    private function prepareViewArray($catagory, &$json, &$response)
    {
        $array = [];

        return $array;
    }

    public static function getGoogleDomain($country_code)
    {
        $prefix = 'https://www.';
        $domains = [
            "ae" => "google.ae",

            "af" => "google.com.af",

            "al" => "google.al",

            "am" => "google.am",

            "ao" => "google.co.ao",

            "ar" => "google.com.ar",

            "at" => "google.at",

            "au" => "google.com.au",

            "az" => "google.az",

            "ba" => "google.ba",

            "bd" => "google.com.bd",

            "be" => "google.be",

            "bg" => "google.bg",

            "bh" => "google.com.bh",

            "bn" => "google.com.bn",

            "bo" => "google.com.bo",

            "br" => "google.com.br",

            "bs" => "google.bs",

            "bw" => "google.co.bw",

            "by" => "google.by",

            "bz" => "google.com.bz",

            "ca" => "google.ca",

            "cd" => "google.cd",

            "ch" => "google.ch",

            "cl" => "google.cl",

            "cm" => "google.cm",

            "co" => "google.com.co",

            "cr" => "google.co.cr",

            "cv" => "google.cv",

            "cy" => "google.com.cy",

            "cz" => "google.cz",

            "de" => "google.de",

            "dk" => "google.dk",

            "do" => "google.com.do",

            "dz" => "google.dz",

            "ec" => "google.com.ec",

            "ee" => "google.ee",

            "eg" => "google.com.eg",

            "es" => "google.es",

            "et" => "google.com.et",

            "fi" => "google.fi",

            "fr" => "google.fr",

            "ge" => "google.ge",

            "gh" => "google.com.gh",

            "gr" => "google.gr",

            "gt" => "google.com.gt",

            "gy" => "google.gy",

            "hk" => "google.com.hk",

            "hn" => "google.hn",

            "hr" => "google.hr",

            "ht" => "google.ht",

            "hu" => "google.hu",

            "id" => "google.co.id",

            "ie" => "google.ie",

            "il" => "google.co.il",

            "in" => "google.co.in",

            "is" => "google.is",

            "it" => "google.it",

            "jm" => "google.com.jm",

            "jo" => "google.jo",

            "jp" => "google.co.jp",

            "kh" => "google.com.kh",

            "kr" => "google.co.kr",

            "kw" => "google.com.kw",

            "kz" => "google.kz",

            "lb" => "google.com.lb",

            "lk" => "google.lk",

            "lt" => "google.lt",

            "lu" => "google.lu",

            "lv" => "google.lv",

            "ly" => "google.com.ly",

            "ma" => "google.co.ma",

            "md" => "google.md",

            "me" => "google.me",

            "mg" => "google.mg",

            "mn" => "google.mn",

            "mt" => "google.com.mt",

            "mu" => "google.mu",

            "mx" => "google.com.mx",

            "my" => "google.com.my",

            "mz" => "google.co.mz",

            "na" => "google.com.na",

            "ng" => "google.com.ng",

            "ni" => "google.com.ni",

            "nl" => "google.nl",

            "no" => "google.no",

            "np" => "google.com.np",

            "nz" => "google.co.nz",

            "om" => "google.com.om",

            "pe" => "google.com.pe",

            "ph" => "google.com.ph",

            "pk" => "google.com.pk",

            "pl" => "google.pl",

            "pt" => "google.pt",

            "py" => "google.com.py",

            "ro" => "google.ro",

            "rs" => "google.rs",

            "ru" => "google.ru",

            "sa" => "google.com.sa",

            "se" => "google.se",

            "sg" => "google.com.sg",

            "si" => "google.si",

            "sk" => "google.sk",

            "sn" => "google.sn",

            "sv" => "google.com.sv",

            "th" => "google.co.th",

            "tn" => "google.tn",

            "tr" => "google.com.tr",

            "tt" => "google.tt",

            "ua" => "google.com.ua",

            "uk" => "google.co.uk",

            "us" => "google.com",

            "uy" => "google.com.uy",

            "ve" => "google.co.ve",

            "vn" => "google.com.vn",

            "za" => "google.co.za",

            "zm" => "google.co.zm",

            "zw" => "google.co.zw"
        ];
        return $prefix . $domains[strtolower($country_code)];
    }
}
