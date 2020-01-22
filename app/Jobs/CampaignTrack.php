<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CampaignTrack implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // On-Demand crawl

        // Check if there is a Crawling request that sent before dispatching or not
        // if yes skip On-Demand crawl

        // if the interval days of the campaign passed than the updated_at time
        // Send Crawling request
        
        // if No go to the next step

        // Update page optimizations score and reports

        // Update pageInsight of the home page

        // Update the site metrics

        // Send an email for the user
        
    }
}
