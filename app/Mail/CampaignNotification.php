<?php

namespace App\Mail;

use App\Http\Controllers\CampaignsController;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;
use App\campaign;
use Illuminate\Support\Facades\DB;

class CampaignNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($campaign)
    {
        //
        $this->campaign = $campaign;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $alphaCode = CampaignsController::countryToCode($this->campaign->site->metric->countryName);
        $alphaCode = ($alphaCode === false) ? null : strtolower($alphaCode); 
        $urls = DB::select('select url ,status , crawl_depth from urls where site_id = ?', [$this->campaign->site->id]);
        $pages = count((array) $urls);
        $title = $this->campaign->name." ".__('latest-updates');
        return $this->view('emails.campaignUpdates',
                        [
                        'campaign'=> $this->campaign,
                        'countryCode' => $alphaCode,                       
                        'pages' => $pages
                        ])                  
                    ->subject($title);
    }
}
