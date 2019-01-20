<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Core\Metrics;
use App\Metric;

class metricsController extends Controller
{
    //

    public function getMetrics(Request $request){
        // get url parameter
        $url = $request->get('url');
        // validate url
        $isGoodUrl = !empty(filter_var($url, FILTER_VALIDATE_URL));
        if($isGoodUrl){
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

                return json_encode($metrics,JSON_PRETTY_PRINT |JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            }
            else
                return $foundMetrics;           
            
        }
        else
            return "Not valid URL !";
  
    }
}
