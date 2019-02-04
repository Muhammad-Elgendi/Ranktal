<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Site;
use App\CrawlingJob;

class SitesController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function addSite(Request $request){
        $site = $request->get('site');
        $exact = $request->get('exact');
        // validate url
        $site = (stripos($site,"https://") === false && stripos($site,"http://") === false) ? "http://".$site : $site;
        $isGoodUrl = !empty(filter_var($site, FILTER_VALIDATE_URL));
        if(!$isGoodUrl){
            return "Not vaild site";
        }
       
        $userId = Auth::user()->id;
        // Check if the site already exist
        $existedSite = Site::where('host',$site)->where('user_id',$userId)->first();
        if($existedSite === null){
            $newSite = new Site;
            $newSite->user_id = $userId;
            $newSite->host = $site;
            $newSite->exact_match = boolval($exact);
            $newSite->save();

            // Add crawling job to queue

            $job = new CrawlingJob;
            $job->site_id =$newSite->id;
            $job->status = "Waiting";
            $job->node = "default";
            $job->save();
            return "Added success";
        }
        else return "Already Exist!";
        
    }

    public function distributeJobs(){
        // distrbute Crawling jobs to nodes 
    }

    public function getSite(Request $request){
        $siteId = $request->get('id');
        $job = Site::find($siteId)->crawlingJob();
        if($job->status !== "Finished"){
            return "Some Things take time";
        }else{
            $this->showChecks($siteId);
        }
    }

    private function showChecks($siteId){
        // prepare readable checks for user in json 
    }
}
