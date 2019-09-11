<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Core\PageConnector;
use Illuminate\Support\Facades\DB;


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

    public function vkeywordTrackerUsingAjax(Request $request){
        if ($request->ajax()) {
           
        } 
        else
            return "This page isn't for you ! ^_^";
    }

    private function prepareViewArray($catagory,&$json,&$response){
        $array = [];
       
        return $array;
    }

}