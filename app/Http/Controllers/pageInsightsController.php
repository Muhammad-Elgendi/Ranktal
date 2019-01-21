<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Core\PageInsights;
use App\PageInsight;

class pageInsightsController extends Controller
{
    //
    public function getPageInsights(Request $request){
        $url = $request->get('url');
        $type = $request->get('type') == null ? "desktop" : $request->get('type');
        // validate url
        $isGoodUrl = !empty(filter_var($url, FILTER_VALIDATE_URL));

        if($isGoodUrl){
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

                return json_encode($pageInsights,JSON_PRETTY_PRINT |JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

            }
            else
            return $foundInsights; 
        }
    }
}