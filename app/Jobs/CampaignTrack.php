<?php

namespace App\Jobs;

use Exception;
use App\campaign;
use App\Http\Controllers\CampaignsController;
use App\Http\Controllers\CrawlingController;
use App\Http\Controllers\metricsController;
use App\Http\Controllers\optimizerController;
use App\Http\Controllers\pageInsightsController;
use App\Mail\CampaignNotification;
use Illuminate\Support\Facades\Mail;
use App\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\DB;

class CampaignTrack implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $onDemandCrawl;
    protected $optimization;
    protected $pageInsight;
    protected $metrics;
    protected $campaignId;
    protected $pages_limit;
    // protected $campaign;

    /**
     * The number of seconds to wait before retrying the job.
     *
     * @var int
     */
    public $retryAfter = 3;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 1;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($campaignId,$pages_limit = null, $onDemandCrawl = true,$optimization = true,$pageInsight = true,$metrics = true){
        // set the campaign id which this job for
        $this->campaignId    = $campaignId; 
        // set the pages_limit of the user which this job for
        $this->pages_limit    = $pages_limit; 
        // set job flags
        $this->onDemandCrawl = $onDemandCrawl;
        $this->optimization  = $optimization;
        $this->pageInsight   = $pageInsight;
        $this->metrics       = $metrics;  
    }

    /**
     * Execute the job.
     *
     * Parameters with default values
     * $campaignId,
     * $pages_limit = null
     * $onDemandCrawl = true,
     * $optimization = true,
     * $pageInsight = true,
     * $metrics = true 
     * 
     * @return void
     */
    public function handle()
    {
        // Get the campaign that this job for
        $campaign = campaign::findOrFail($this->campaignId);
        // change the status of the campaign
        $campaign->status = "updating";
        // save changes
        $campaign->save();

        // On-Demand crawl
        if($this->onDemandCrawl){
            // Check if there is a Crawling request that sent before dispatching or not 
            // And  if the interval days of the campaign passed than the updated_at time
            if($campaign->site->crawlingJob->status == "Finished and Viewable" ||$campaign->site->crawlingJob->status == "Finished" && $campaign->site->crawlingJob->finished_at <  Carbon::now()->subDay($campaign->interval)){
                $crawlingController = new CrawlingController();

                // Get the user that this job for
                $user = User::findOrFail($campaign->user_id);

                // check if we got a pages_limit
                if(isset($this->pages_limit)){                   
                    // Send crawling request
                    $crawlingController->sendCrawlingRequest($campaign->site->host,$campaign->site->id,$campaign->site->exact_match,$this->pages_limit);
                }else{
                    // Send crawling request
                    $crawlingController->sendCrawlingRequest($campaign->site->host,$campaign->site->id,$campaign->site->exact_match,$user->available_credit('crawl_monthly'));
                }
                
            }          
        }
        
        // Update page optimizations score and reports
        if($this->optimization){
            foreach($campaign->optimization as $page){ 
                $optimizerController = new optimizerController();
                $optimizerController->checkForSite(null,$page->url,$page->keyword,$campaign->interval,$campaign->id);
            }               
        }

        /**
         * Call pageInsight endpoint then metrics endpoints then pageInsight endpoint
         * so we don't hit the same endpoint intensively
         */

        // Update desktop pageInsight of the home page
        if($this->pageInsight){
            $pageInsightController = new pageInsightsController();
            // make the desktop version
            $pageInsightController->getPageInsightsForSite(null,$campaign->site->host,"desktop",$campaign->interval,$campaign->site->id);
        }

        // Update the site metrics
        if($this->metrics){
            $metricsController = new metricsController();
            $metricsController->getMetricsForSite(null,$campaign->site->host,$campaign->interval,$campaign->site->id);
        }

        // Update mobile pageInsight of the home page
        if($this->pageInsight){
            // make the mobile version
            $pageInsightController->getPageInsightsForSite(null,$campaign->site->host,"mobile",$campaign->interval,$campaign->site->id);
        }

        // notify that campaign updating is done
        $campaign->last_track_at = Carbon::now();

        // change the status of the campaign
        $campaign->status = "Finished";     

        // check if last email send the day before if so skip
        if(empty($campaign->last_email_at) || $campaign->last_email_at < Carbon::now()->subDay(1) ){

            // Send an email for the user
            Mail::to($campaign->user->email)->queue(new CampaignNotification($campaign));

            // update last email attribute
            $campaign->last_email_at = Carbon::now();

        }

        // save changes
        $campaign->save();
    }

    /**
     * The job failed to process.
     *
     * @param  Exception  $exception
     * @return void
     */
    public function failed(Exception $exception)
    {
        // Get the campaign that this job for
        $campaign = campaign::findOrFail($this->campaignId);
        // change the status of the campaign
        $campaign->status = "failed";
        // save changes
        $campaign->save();
    }
}
