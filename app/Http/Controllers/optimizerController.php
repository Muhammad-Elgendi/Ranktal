<?php

namespace App\Http\Controllers;

use App\campaign;
use Illuminate\Http\Request;
use App\Core\PageOptimization;
use App\Core\PageConnector;
use App\optimization;
use Carbon\Carbon;

class optimizerController extends Controller{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('auth');
    }

    // View Method
    public function index(){
        return view('dashboard.pageOptimization');
    }

    /**
     * Optimizer endpoint method that returns the report in json
     */
    public function check(Request $request){
        $inputUrl = $request->get('u');
        $keyword = rawurldecode($request->get('k'));
        if (empty($keyword)) {
            return "Empty keyword";
        }
        $connector = new PageConnector($inputUrl);
        $connector->connectPage();
        if (!$connector->isGoodUrl) {
            return "Not Valid URL";
        }
        $connector->setIsGoodStatus();
        $connector->httpCodes;
        $connector->urlRedirects;

        $optimizer = new PageOptimization($connector->url, $keyword, $connector->parsedUrl, end($connector->httpCodes), $connector->header, $connector->doc);
        $class_methods = get_class_methods($optimizer);

        foreach ($class_methods as $method_name) {
            if ($method_name != "__construct")
                $optimizer->$method_name();
        }

        return json_encode($optimizer, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    public function viewChecksUsingAjax(Request $request){
        if (!$request->ajax()) {
            return "This page isn't for you ! ^_^";
        }
        $json = $this->check($request);
        $array = json_decode($json);
        $newRequest = array();
        $counter = 0;
        foreach ($array as $key => $value) {
            if (gettype($value) == "boolean" ) {
                $newRequest['checks'][$counter]["type"] = empty($value) ? "glyphicon-remove-sign text-danger" : "glyphicon-ok-sign text-success";
                $newRequest['checks'][$counter]["title"] = __($key);
                $newRequest['checks'][$counter]["infosection"]["infoword"] =__('about-issue');
                $newRequest['checks'][$counter]["infosection"]["info"] =__($key."Info"); 
                $newRequest['checks'][$counter]["text_before_attributes"] =  '<h4>'.__('how-to-fix').'</h4>'.'<p>'.__($key."Fix").'</p>';

                // $newRequest['checks'][$counter]["list_before_attributes"] =  array_fill(0, 6, 'banana');
                $counter++;
            }
            else{
                $newRequest[$key] = $value;
            }
        }
        //    var_dump($newRequest);
        return json_encode($newRequest, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);         
    }


    /**
     * @return report in json
     * 
     * Get the page optimization of a URL and given keyword
     * 
     * if url and keyword is not existed
     * override the parameter from request object
     * 
     * interval = -1 --- Get stored metrics if available (Default)
     * interval = 0  --- Get the new metrics of the site now and update the database
     * interval > 0  --- Get the stored metrics of the site if interval(days) doesn't passed since last update 
     *               ---      Or update the metrics of the site         
     * 
     * campaignId --- The Id of the campaign that this page optimization belongs to       
     * * type Request before $request so it can be run as endpoint method  
     */
     
    public function checkForSite($request,$inputUrl = null,$keyword = null,$interval = -1,$campaignId = null){
        // if url and keyword is not existed
        // override the parameter from request object
        if($inputUrl === null || $keyword === null){
            $inputUrl = $request->get('u');
            $keyword = rawurldecode($request->get('k'));
        }

        // override interval parameter if it's present in the request
        if($request !== null && $request->has('interval')){
            // update interval parameter
            $interval = $request->get('interval');
        }

        // validate keyword
        if (empty($keyword)) {
            return "Empty keyword";
        }

        // remove trailing slashes in URL
        $inputUrl = rtrim($inputUrl,"/");

        // validate url
        $isGoodUrl = !empty(filter_var($inputUrl, FILTER_VALIDATE_URL));
        if(!$isGoodUrl){
            return "Not valid URL !";
        }

        // search if this optimization exist in db
        $foundOptimization = campaign::find($campaignId)->optimization()->where('url',$inputUrl)->where('keyword',$keyword)->first();

        if($foundOptimization === null){
            // if not existed create new one

            // connect the page and get the response
            $connector = new PageConnector($inputUrl);
            $connector->connectPage();

            // validate the url response
            if (!$connector->isGoodUrl) {
                return "Not Valid URL Response";
            }

            $connector->setIsGoodStatus();
            $connector->httpCodes;
            $connector->urlRedirects;

            $optimizer = new PageOptimization($connector->url, $keyword, $connector->parsedUrl, end($connector->httpCodes), $connector->header, $connector->doc);
            $class_methods = get_class_methods($optimizer);

            foreach ($class_methods as $method_name) {
                if ($method_name != "__construct")
                    $optimizer->$method_name();
            }

            // save the optimization to db
            $optimization = new optimization();

            $optimization->campaign_id = $campaignId;
            $optimization->url = $inputUrl;
            $optimization->keyword = $keyword;

            // save optimizer opject (after json encoding) into report attribute
            $report = json_encode($optimizer, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

            $optimization->report = $report;

            // save score
            $optimization->score = $optimizer->score;

            // save the record
            $optimization->save();

            // return the optimization to the user
            return $optimization;
        }

        // case that optimization are found and the user wants the stored version
        else if($foundOptimization->report !== null && ($interval == -1 || $foundOptimization->updated_at >= Carbon::now()->subDay($interval))){
            return $foundOptimization;
        }

        // case that optimization is found but the user wants the updated new version
        // or it's not completed so make the report 
        else if($foundOptimization->report === null || ($foundOptimization->report !== null && ($interval == 0  || $foundOptimization->updated_at <  Carbon::now()->subDay($interval)))){
            // call core class

            // connect the page and get the response
            $connector = new PageConnector($inputUrl);
            $connector->connectPage();

            // validate the url response
            if (!$connector->isGoodUrl) {
                return "Not Valid URL Response";
            }

            $connector->setIsGoodStatus();
            $connector->httpCodes;
            $connector->urlRedirects;

            $optimizer = new PageOptimization($connector->url, $keyword, $connector->parsedUrl, end($connector->httpCodes), $connector->header, $connector->doc);
            $class_methods = get_class_methods($optimizer);

            foreach ($class_methods as $method_name) {
                if ($method_name != "__construct")
                    $optimizer->$method_name();
            }

            // save optimizer opject (after json encoding) into report attribute
            $report = json_encode($optimizer, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

            $foundOptimization->report = $report;
            $foundOptimization->score = $optimizer->score;

            // Add this optimization to the campaign that owns them
            $foundOptimization->campaign_id = $campaignId;

            // update time
            $foundOptimization->updated_at = Carbon::now();

            $foundOptimization->save(); 
            return $foundOptimization;
        }
    }

}
