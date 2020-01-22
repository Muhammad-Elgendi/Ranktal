<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Core\PageInsights;
use App\PageInsight;
use Carbon\Carbon;

class pageInsightsController extends Controller{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    //
    public function getPageInsights(Request $request){
        $url = $request->get('url');

        // remove trailing slashes in URL
        $url = rtrim($url,"/");

        $type = $request->get('type') == null ? "desktop" : $request->get('type');
        // validate url
        $isGoodUrl = !empty(filter_var($url, FILTER_VALIDATE_URL));

        // validate type
        $isGoodType = $type == "desktop" || $type == "mobile";

        if(!$isGoodUrl || !$isGoodType){
            return;
        }     

        $foundInsights = PageInsight::where('url', $url)->where('type', $type)->first();

        // if not exist in database
        if ($foundInsights === null) {

            $pageInsights =new PageInsights($url,$type);


            $class_methods = get_class_methods($pageInsights);

            foreach ($class_methods as $method_name) {
                if($method_name != "__construct")
                    $pageInsights->$method_name();
            }

            // create a new instance of the model
            $Pi = new PageInsight();

            foreach($pageInsights as $key => $value) {
                $Pi->$key = $value;
            }

            $Pi->save();        

            return $Pi;
        }
        else
            return $foundInsights; 
    }

    /**
     * Get the pageInsight of URL
     * If url parameter is not provided get the url from the request

     * interval = -1 --- Get stored metrics if available (Default)
     * interval = 0  --- Get the new metrics of the site now and update the database
     * interval > 0  --- Get the stored metrics of the site if interval(days) doesn't passed since last update 
     *               ---      Or update the metrics of the site         
     * 
     * SiteId --- The Id of the site that these metrics belongs to       
     */
    public function getPageInsightsForSite(Request $request,$url = null,$type = null,$interval = -1,$siteId = null){

        // if url parameter is not provided get the url from the request
        if($url === null){
            // get url parameter
            $url = $request->get('url');
        }

        // remove trailing slashes in URL
        $url = rtrim($url,"/");


        // if type parameter is not provided get the type from the request
        if($type === null){
            // get type parameter
            $type = $request->get('type') == null ? "desktop" : strtolower($request->get('type'));
        }

        // override interval parameter if it's present in the request
        if($request->has('interval')){
            // update interval parameter
            $interval = $request->get('interval');
        }

        // validate url
        $isGoodUrl = !empty(filter_var($url, FILTER_VALIDATE_URL));

        // validate type
        $isGoodType = $type == "desktop" || $type == "mobile";

        if(!$isGoodUrl || !$isGoodType){
            return;
        }

        $foundInsights = PageInsight::where('url', $url)->where('type', $type)->first();

        // if not exist in database
        if ($foundInsights === null) {

            $pageInsights =new PageInsights($url,$type);


            $class_methods = get_class_methods($pageInsights);

            foreach ($class_methods as $method_name) {
                if($method_name != "__construct")
                    $pageInsights->$method_name();
            }

            // create a new instance of the model
            $Pi = new PageInsight();

            foreach($pageInsights as $key => $value) {
                $Pi->$key = $value;
            }

            // Add this page Insight for the site that own it
            $Pi->site_id = $siteId;

            $Pi->save();        

            return $Pi;
        }

        // case that pageInsight are found and the user wants the stored version
        else if($foundInsights !== null && ($interval == -1 || $foundInsights->updated_at >= Carbon::now()->subDay($interval))){
            return $foundInsights;
        }

        // case that pageInsight are found but the user wants the updated new version
        else if($foundInsights !== null && ($interval == 0  || $foundInsights->updated_at <  Carbon::now()->subDay($interval))){
            // call core class
       
            $pageInsights =new PageInsights($url,$type);

            $class_methods = get_class_methods($pageInsights);

            foreach ($class_methods as $method_name) {
                if($method_name != "__construct")
                    $pageInsights->$method_name();
            }

            foreach($pageInsights as $key => $value) {
                $foundInsights->$key = $value;
            }

            // Add this pageInsight to the site that owns them
            $foundInsights->site_id = $siteId;

            // update time
            $foundInsights->updated_at = Carbon::now();

            $foundInsights->save();            

            return $foundInsights;
        }
    }
}