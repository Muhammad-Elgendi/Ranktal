<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Core\PageScraper;
use App\Core\PageConnector;
use App\Core\PageChecker;
use App\Page;
use App\Html;
use Illuminate\Support\Facades\Auth;


class checkerController extends Controller
{
    //
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    // View Method
    public function index()
    {
        $pages = Page::where('user_id', Auth::id())->get();
        return view('dashboard.seoAudit')->with('pages', $pages);
    }

    public function findOrCreateCheck($inputUrl)
    {
        $connector = new PageConnector($inputUrl);
        $connector->connectPage();
        if (!$connector->isGoodUrl) {
            return "Not Valid URL";
        }
        $connector->setIsGoodStatus();
        // $connector->httpCodes;
        // $connector->urlRedirects;

        $foundPage = Page::where('url', $connector->url)->where('user_id', Auth::id())->first();

        if ($foundPage === null) {
            // page doesn't exist

            $scraper = new PageScraper($connector->url, $connector->parsedUrl, end($connector->httpCodes), $connector->header, $connector->doc);
            $cacheKey = md5($scraper->parsedUrl["host"] . '/robots.txt');
            $minutes = 600;
            $robotsContent = Cache::remember($cacheKey, $minutes, function () use ($scraper) {
                return $scraper->getRobots();
            });
            $scraper->setRobotsContent($robotsContent);

            $class_methods = get_class_methods($scraper);

            foreach ($class_methods as $method_name) {
                if ($method_name != "__construct" && $method_name != "setRobotsContent")
                    $scraper->$method_name();
            }

            $page = new Page();
            $page->user_id = Auth::id();
            foreach ($scraper as $key => $value) {
                $page->$key = $value;
            }

            $page->save();

            $html = new Html();
            $html->page_id = $page->id;
            $html->header = $connector->header;
            $html->doc = $connector->doc;
            $html->save();

            return $this->doChecks($scraper);
        } else {
            $foundPage = json_decode($foundPage->toJson(), true);
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
    private function doChecks($obj)
    {
        $checker = new PageChecker($obj);
        $class_methods = get_class_methods($checker);

        foreach ($class_methods as $method_name) {
            if ($method_name != "__construct")
                $checker->$method_name();
        }
        /**
         * JSON_PRETTY_PRINT |JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE together
         * more at http://php.net/manual/en/json.constants.php
         */
        return json_encode($checker, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    public function viewChecksUsingAjax(Request $request, $url = null)
    {
        if (!$request->ajax()) {
            return "This page isn't for you ^^";
        }

        if ($url == null)
            $json = $this->findOrCreateCheck($request->get('u'));
        else
            $json = $this->findOrCreateCheck($url);

        $array = json_decode($json);
        $response = array();

        $sections = [
            'title', 'description', 'url', 'heading', 'image', 'fromatedItems', 'contentTypeAndCharset', 'viewport', 'canonical',
            'ratio', 'language', 'docType', 'accessiblity', 'amp', 'openGraph', 'twitterCard', 'frames', 'flash', 'links'
        ];

        /*
             Each section has a variable with its name contains an array that
             has the name of variable that used as type in the first index
             And the array of attribute-variable-names in the secound index 
            */

        $title = ['isGoodTitle', ['title', 'isTitleExist', 'titleLength', 'isGoodTitleLength', 'isSingleTitle']];

        $description = ['isGoodDescription', [
            'description', 'isSingleDescription', 'isDescriptionExist',
            'descriptionLength', 'isGoodDescriptionLength'
        ]];

        $url = ['isGoodUrl', [
            'url', 'domain', 'urlLength', 'domainLength', 'google_cache_url',
            'countSpacesInUrl', 'isGoodUrlLength', 'isUrlNotHasSpaces', 'httpCode', 'isUrlHasGoodStatus'
        ]];

        $heading = ['isGoodHeader', ['h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'isSingleH1']];

        $image = ['isGoodImg', ['alt', 'emptyAlt']];

        $fromatedItems = ['isFormattedTextExist', ['bItems', 'iItems', 'emItems', 'strongItems', 'markItems']];

        $contentTypeAndCharset = ['isContentTypeAndCharsetExist', ['contentType', 'charset']];

        $viewport = ['isViewportExist', ['viewport']];

        $canonical = ['isCanonicalExist', ['canonical']];

        $ratio =  ['isGoodTextHtmlRatio', ['ratio']];

        $language = ['isLanguageExist', ['language']];

        $docType = ['isDocTypeExist', ['docType']];

        $accessiblity = ['isAccessible', ['robotsMeta', 'xRobots', 'refreshMeta', 'refreshHeader', 'isAllowedFromRobots', 'isAllowedFromPage']];

        $amp = ['isAmpCopyExist', ['ampLink']];

        $openGraph = ['isOpenGraphExist', ['openGraph']];

        $twitterCard = ['isTwitterCardExist', ['twitterCard']];

        $frames = ['isFramesNotExist', ['framesCount']];

        $flash = ['isFlashNotExist', []];

        // Add Checks to response
        foreach ($sections as $index => $value) {
            if ($value !== 'links') {
                $response['checks'][$index] = $this->createViewArray($array, ${$value}[0], $value, ${$value}[1]);
            } else {
                // Create View component of links
                $linksArray = array();
                $linksArray['title'] = __('linksAnalysis');
                $linksArray["attributes"][] = [__('linksCount'), count($array->links)];
                $linksArray["tablesection"]["columns"] = [__('aText'), __('aHref'), __('aStatus')];
                foreach ($array->links as $ind => $link) {
                    $linksArray["tablesection"]["rows"][$ind] = [$link->aText, $link->aHref, $link->aStatus];
                }
                $response['checks'][$index] = $linksArray;
            }
        }
        // Add Page URL , Title and description to response
        $response['url'] = $array->url;
        $response['pageTitle'] = $array->title;
        $response['pageDescription'] = $array->description;
        // dd($response);
        return json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }


    public static function is_json($string) {
        $data = json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    private function createViewArray(&$json, $type, $title, $attributes)
    {
        $array = array();
        if (is_bool($json->$type)) {
            $array['type'] = empty($json->$type) ? "glyphicon-remove-sign text-danger" : "glyphicon-ok-sign text-success";
        } else {
            $array['type'] = "nutral";
        }
        $array['title'] = __($title);
        $array["infosection"]["infoword"] = __('infoword');
        $array["infosection"]["info"] =  __($title . 'Info');
        if (!empty($attributes)) {
            foreach ((array) $attributes as $attr) {
                if (is_bool($json->$attr)) {
                    $flag = empty($json->$attr) ? "glyphicon-remove-sign text-danger" : "glyphicon-ok-sign text-success";
                    $array["attributes"][] = [__($attr), '<span class="glyphicon ' . $flag . ' fa-lg"></span>'];
                }
                elseif (is_array($json->$attr) && is_object($json->$attr[0])) {
                    // array to hold objects
                    $listOfObjects = [];
                    foreach ($json->$attr as $object) {
                        // array to hold object attributes
                        $internalArray = [];
                        foreach($object as $key => $value){
                            $internalArray[]= [__($key),$object->$key];
                        }
                        $listOfObjects[] = $internalArray;
                    }
                    $array["attributes"][] = [__($attr), $listOfObjects];
                }
                else {
                    if ($json->$attr === null) {
                        $array["attributes"][] = [__($attr), __('not-found')];
                    }else{
                        $array["attributes"][] = [__($attr), $json->$attr];
                    }
                }
            }
        }
        return $array;
    }

    /**
     * Delete Page and its html
     */
    public function destroy($id)
    {
        $page = Page::findOrFail($id);
        $page->delete();
        return redirect(app()->getLocale() . '/dashboard/seo-audit');
    }

    /**
     * Reaudit a page
     */
    public function reaudit(Request $request)
    {
        $page = Page::findOrFail($request->get('id'));
        $url = $page->url;
        $page->delete();
        return $this->viewChecksUsingAjax($request, $url);
    }
}
