<?php

namespace App\Http\Controllers;

use App\campaign;
use App\optimization;
use App\Site;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CampaignsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // View Method
    public function index()
    {
        $campaigns = campaign::where('user_id', Auth::user()->id)->get();
        return view('dashboard.campaigns')->with('campaigns', $campaigns);
    }

    // Return Create New Campaign View
    public function create(){
        return view('dashboard.campaigns.create');
    }

    /**
     * Return True if inputs are in correct format 
     * False if not
     */
    private function filterInputs(Request $request, $site = null, $exact = null){
        if ($site == null && $exact == null) {
            $site = $request->get('site');
            $exact = $request->get('exact');
        }

        if(!is_bool($exact)){
            $exactText = strtolower($exact);
            if ($exactText === "true") {
                $exact = true;
            } elseif ($exactText === "false") {
                $exact = false;
            } else {
                $exact = boolval($exactText);
            }
        }

        // validate url parameter
        $site = (stripos($site, "https://") === false && stripos($site, "http://") === false) ? "http://" . $site : $site;
        $isGoodUrl = !empty(filter_var($site, FILTER_VALIDATE_URL));

        if (!$isGoodUrl) {
            return false;
        } else {
            return true;
        }
    }

    public function store(Request $request){

        $campaign = new campaign();
        $campaign->user_id = Auth::user()->id;
        $campaign->name = $request->get('name');

        $interval = (int)$request->get('interval');
        // validate interval
        if($interval > 30)
            $interval = 30;
        if($interval < 7)
            $interval = 7;

        $campaign->interval = $interval;
        // validate exact check box        
        $exact = $request->get('exact') !== null;
        $site = $request->get('url');

        // validate inputs
        $areGoodInputs = $this->filterInputs($request,$site,$exact);
        if(!$areGoodInputs){
            return;
        }

        $crawlingController = new CrawlingController();
        // check if site data is existed
        $existedSite = Site::where('host', $site)->first();

        if ($existedSite === null) {
            // create new site
            $siteId = $crawlingController->createNewSite($site,$exact);
            // assign campaign to the site
            $campaign->site_id = $siteId;
            // save campaign data
            $campaign->save();

            // send crawling request
            $crawlingController->sendCrawlingRequest($site,Auth::user()->id,$siteId,$exact);
            
        }else{
            // site is existed
            // assign campaign to the site
            $campaign->site_id = $existedSite->id;
            // save campaign data
            $campaign->save();
        }
    
        // check if there are pages to optimize
        if(!empty($request->get('keyword')[0]) && !empty($request->get('page-link')[0])){
            // there are pages to optimize
            for($i = 0 ; $i < count($request->get('page-link')) ;$i++){
                $optimization = new optimization();
                $optimization->campaign_id = $campaign->id;
                $optimization->url = $request->get('page-link')[$i];
                $optimization->keyword = $request->get('keyword')[$i];
                $optimization->save();
            } // end for
        } // end if
    
        // Add the job of geting metrics , pageInsights , page optimizations and sending email to queue
        
        // Simulate that campaign updating is done
        $campaign->last_track_at = Carbon::now();
        $campaign->save();

        // redirect to seo campaigns view
        return redirect(route('lang.seo-campaigns',app()->getLocale()));
    }

    /**
     * Delete the campain and all of its data
     */
    public function destroy($id){
        $site = campaign::findOrFail($id);
        $site->delete();
        return redirect(route('lang.seo-campaigns',app()->getLocale()));
    }

    // Return Edit Campaign View
    public function edit($id){
        $campaign = campaign::findOrFail($id);
        return view('dashboard.campaigns.edit')->with('campaign',$campaign);
    }

    // store the edits of the campaign
    public function saveEdit(Request $request){
        $id = $request->get('id');
        $campaign = campaign::where('id',$id)->where('user_id',Auth::user()->id)->first();
        if($campaign === null){
            return;
        }
        $campaign->name = $request->get('name');
        $interval = (int)$request->get('interval');
        // validate interval
        if($interval > 30)
            $interval = 30;
        if($interval < 7)
            $interval = 7;

        $campaign->interval = $interval;
        // save changes
        $campaign->save();
        // delete all previous optimization
        $campaign->optimization()->delete();

        // check if there are pages to optimize
        if(!empty($request->get('keyword')[0]) && !empty($request->get('page-link')[0])){
            // there are pages to optimize
            for($i = 0 ; $i < count($request->get('page-link')) ;$i++){
                $optimization = new optimization();
                $optimization->campaign_id = $campaign->id;
                $optimization->url = $request->get('page-link')[$i];
                $optimization->keyword = $request->get('keyword')[$i];
                $optimization->save();
            } // end for
        } // end if

        // redirect to seo campaigns view
        return redirect(route('lang.seo-campaigns',app()->getLocale()));
    }
}
