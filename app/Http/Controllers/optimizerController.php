<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Core\PageOptimization;
use App\Core\PageConnector;

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
        if ($request->ajax()) {
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
        } else
            return "This page isn't for you ! ^_^";
    }
}
