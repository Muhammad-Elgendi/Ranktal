<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Core\PageOptimization;
use App\Core\PageConnector;

class optimizerController extends Controller
{
    // View Method
    public function index(){
       return view('dashboard.pageOptimization');
    }



    public function check(Request $request){
        $inputUrl = $request->get('u');
        $keyword = rawurldecode($request->get('k'));
        if(empty($keyword)){
            return "Empty keyword";
        }
        $connector =new PageConnector($inputUrl);
        $connector->connectPage();
        if(!$connector->isGoodUrl){
            return "Not Valid URL";
        }
        $connector->setIsGoodStatus();       
        $connector->httpCodes;
        $connector->urlRedirects;

        $optimizer =new PageOptimization($connector->url,$keyword,$connector->parsedUrl,end($connector->httpCodes),$connector->header,$connector->doc);
        $class_methods = get_class_methods($optimizer);

        foreach ($class_methods as $method_name) {
            if($method_name != "__construct")
                $optimizer->$method_name();
        }

        return json_encode($optimizer,JSON_PRETTY_PRINT |JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }

    public function viewChecksUsingAjax(Request $request){
        if($request->ajax()){   
           $json = $this->check($request);
           $array = json_decode($json);
           $newRequest = array(array());
           $counter = 0;
           foreach($array as $key => $value){
                $newRequest[$counter]["type"] = empty($value) ? "glyphicon-remove-sign text-danger" : "glyphicon-ok-sign text-success";
                $newRequest[$counter]["title"] = __($key);
                $counter++;
            }

        //    print_r($newRequest);
            return json_encode($newRequest,JSON_PRETTY_PRINT |JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE); 
        }
        else
            return "This page isn't for you ! ^_^";        
    }
}