<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Core\Metrics;
use App\Metric;
use Carbon\Carbon;

class metricsController extends Controller
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

    /**
     * Endpoint method to get metrics of given site
     */
    public function getMetrics(Request $request){
        // get url parameter
        $url = $request->get('url');

        // remove trailing slashes in URL
        $url = rtrim($url,"/");

        // validate url
        $isGoodUrl = !empty(filter_var($url, FILTER_VALIDATE_URL));
        if(!$isGoodUrl){
            return "Not valid URL !";
        }
        $foundMetrics = Metric::where('url', $url)->first();

        // if not exist in database
        if ($foundMetrics === null) {
            // call core class
            $metrics =new Metrics($url);

            $class_methods = get_class_methods($metrics);
    
            foreach ($class_methods as $method_name) {
                if($method_name != "__construct")
                    $metrics->$method_name();
            }
            // create a new instance of the model
            $metric = new Metric();

            foreach($metrics as $key => $value) {
                $metric->$key = $value;
            }

            $metric->save();        

            return $metric;
        }
        else
            return $foundMetrics;
    }

    /**
     * Get the metrics of URL
     * If url parameter is not provided get the url from the request

     * interval = -1 --- Get stored metrics if available (Default)
     * interval = 0  --- Get the new metrics of the site now and update the database
     * interval > 0  --- Get the stored metrics of the site if interval(days) doesn't passed since last update 
     *               ---      Or update the metrics of the site         
     * 
     * SiteId --- The Id of the site that these metrics belongs to  
     * * type Request before $request so it can be run as endpoint method       
     */
    public function getMetricsForSite($request,$url = null,$interval = -1,$siteId = null){
        
        // if url parameter is not provided get the url from the request
        if($url === null){
            // get url parameter
            $url = $request->get('url');
        }

        // remove trailing slashes in URL
        $url = rtrim($url,"/");

        // override interval parameter if it's present in the request
        if($request !== null && $request->has('interval')){
            // update interval parameter
            $interval = $request->get('interval');
        }

        // validate url
        $isGoodUrl = !empty(filter_var($url, FILTER_VALIDATE_URL));
        if(!$isGoodUrl){
            return "Not valid URL !";
        }

        $foundMetrics = Metric::where('url', $url)->first();

        // if not exist in database
        if ($foundMetrics === null) {
            // call core class
            $metrics =new Metrics($url);

            $class_methods = get_class_methods($metrics);
    
            foreach ($class_methods as $method_name) {
                if($method_name != "__construct")
                    $metrics->$method_name();
            }
            // create a new instance of the model
            $metricdb = new Metric();

            foreach($metrics as $key => $value) {
                $metricdb->$key = $value;
            }

            // Add this metrics to the site that owns them
            $metricdb->site_id = $siteId;
            $metricdb->save();        

            return $metricdb;
        }

        // case that metrics are found and the user wants the stored version
        else if($foundMetrics !== null && ($interval == -1 || $foundMetrics->updated_at >= Carbon::now()->subDay($interval))){
            return $foundMetrics;
        }

        // case that metrics are found but the user wants the updated new version
        else if($foundMetrics !== null && ($interval == 0  || $foundMetrics->updated_at <  Carbon::now()->subDay($interval))){
            // call core class
            $metrics =new Metrics($url);

            $class_methods = get_class_methods($metrics);
    
            foreach ($class_methods as $method_name) {
                if($method_name != "__construct")
                    $metrics->$method_name();
            }

            foreach($metrics as $key => $value) {
                $foundMetrics->$key = $value;
            }

            // Add this metrics to the site that owns them
            $foundMetrics->site_id = $siteId;

            // update time
            $foundMetrics->updated_at = Carbon::now();

            $foundMetrics->save(); 
            return $foundMetrics;
        }
    }
}
