<?php

namespace App\Http\Controllers;

use App\campaign;
use App\Jobs\CampaignTrack;
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

    // View user campaigns Method
    public function index()
    {
        $campaigns = campaign::where('user_id', Auth::user()->id)->get();
        return view('dashboard.campaigns')->with('campaigns', $campaigns);
    }

    // View campaign Method
    public function view($id)
    {
        $campaign = campaign::where('user_id', Auth::user()->id)->where('id',$id)->first();
        return view('dashboard.campaigns.view')->with('campaign', $campaign);
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
            // if site isn't exist

            // create new site
            $siteId = $crawlingController->createNewSite($site,$exact);
            // assign campaign to the site
            $campaign->site_id = $siteId;
            // save campaign data
            $campaign->save();

            // TODO : set the remaining pages of the user account as a limit for the crawling request

            // send crawling request
            $crawlingController->sendCrawlingRequest($site,$siteId,$exact);
            
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
                // remove trailing slashes in URL
                $inputUrl = rtrim($request->get('page-link')[$i],"/");
                $optimization->url = $inputUrl;
                $optimization->keyword = $request->get('keyword')[$i];
                $optimization->save();
            } // end for
        } // end if
    
        // change the status of the campaign
        $campaign->status = "Waiting";
        // save data
        $campaign->save();

        // Add the job of geting metrics , pageInsights , page optimizations and sending email to queue
        CampaignTrack::dispatch($campaign->id);

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
        // change the status of the campaign
        $campaign->status = "Waiting";
        // save changes
        $campaign->save();
        // keep ids of optimizations that will not be deleted
        $noDelete = [];
        // check if there are pages to optimize
        if(!empty($request->get('keyword')[0]) && !empty($request->get('page-link')[0])){
            // there are pages to optimize
            for($i = 0 ; $i < count($request->get('page-link')) ;$i++){
                // check if this optimization is not existed in the db
                $foundOptimization = $campaign->optimization()->where('url',$request->get('page-link')[$i])->where('keyword',$request->get('keyword')[$i])->first();
                if($foundOptimization === null){
                    $optimization = new optimization();
                    $optimization->campaign_id = $campaign->id;
                    // remove trailing slashes in URL
                    $inputUrl = rtrim($request->get('page-link')[$i],"/");
                    $optimization->url = $inputUrl;
                    $optimization->keyword = $request->get('keyword')[$i];
                    $optimization->save();
                    // add the id to noDelete
                    $noDelete[] = $optimization->id;
                }else{
                    // add the id of foundOptimization to noDelete
                    $noDelete[] = $foundOptimization->id;
                }
           
            } // end for
        } // end if

        // delete all optimizations from database if the user delete them
        if(empty($noDelete)){
            // delete all previous optimization
            $campaign->optimization()->delete();
        }

        // delete optimization from our database if the user delete it
        foreach($campaign->optimization as $optimization){
            if(!in_array($optimization->id, $noDelete)){
                $optimization->delete();
            }
        }

        // Add update optimization job to queue
        CampaignTrack::dispatch($campaign->id,false,true,false,false);

        // redirect to seo campaigns view
        return redirect(route('lang.seo-campaigns',app()->getLocale()));
    }

    /**
     * Add campaigns that has to be updated to queue
     */
    public static function scheduleCampaign(){
        $campaigns = campaign::where('status','Finished')->oldest('last_track_at')->get();
        foreach($campaigns as $campaign){
            if($campaign->last_track_at <  Carbon::now()->subDay($campaign->interval)){
                // this campaign has to be updated
                CampaignTrack::dispatch($campaign->id);
            }
        }
    }
}
