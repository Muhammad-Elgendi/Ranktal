<?php

namespace App\Jobs;


use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Core\Title;
use App\Core\Url;
use App\Core\Meta;
use App\Core\Page;
use App\Core\Heading;
use App\Core\Image;
use App\Core\Check;
use App\Core\Alexa;
use App\Core\BackLinks;
use App\Core\PageSpeed;
use App\Report;

class MakeReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 1;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 120;

    protected $url;

    protected $reportId;

    protected $report;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    /**
     * MakeReport constructor.
     * @param $url
     * @param $nextId
     * @param $isNew
     */
    public function __construct($url,$nextId,$isNew)
    {
        if (!$isNew){
            $audit=new Report();
            $audit->id=$nextId;
            \Auth::user()->reports()->save($audit);
            $this->reportId=$nextId;
        }
        else{
            $audit=new Report();
            \Auth::user()->reports()->save($audit);
            $this->reportId=$audit->id;
        }
        $this->url=$url;
        $this->report=$audit;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        $audit=$this->report;
        $url=$this->url;

        /**
         * page load time is set from the following connection only
         * the Raw URL is supplied directly to check constructor after trim it
         */
        $tempURL=trim($url);

        if(stripos($tempURL,'http://')=== false && stripos($tempURL,'https://')=== false)
            $tempURL='http://'.$tempURL;


        $rawURL=$url=$tempURL;

        $audit->inputURL=$rawURL;

        $headers = get_headers($url, 1);
        if ($headers !== false && isset($headers['Location'])) {
            $url= is_array($headers['Location']) ? array_pop($headers['Location']) : $headers['Location'];
        }
        $started_at = microtime(true);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $html = curl_exec($ch);
        if ( $html === false | empty($html)){
            die('Failed to connect the site');
        }
        $loadTime=round((microtime(true) - $started_at),2);


        $title=new Title($html);
        $audit->hasTitle=$title->hasTitle;
        $audit->duplicateTitle=$title->duplicateTitle;
        $audit->checkLengthTitle=$title->checkLength;
        $audit->lengthTitle=$title->length;
        $audit->title=$title->title;
        $audit->checkTitle=$title->check();

        $audit->save();

        $urlObj=new Url($url);
        $audit->url=$urlObj->url;
        $audit->domain=$urlObj->domain;
        $audit->domainLength=$urlObj->domainLength;
        $audit->lengthUrl=$urlObj->urlLength;
        $audit->statusUrl=$urlObj->status;
        $audit->googleCacheUrl=$urlObj->google_cache_url;
        $audit->spacesUrl=$urlObj->count_of_spaces;
        $audit->checkLengthUrl=$urlObj->check_length();
        $audit->checkSpacesUrl=$urlObj->check_spaces();
        $audit->checkStatusUrl=$urlObj->check_status();
        $audit->checkUrl=$urlObj->check();

        $audit->save();

        $meta= new Meta($url,$html);
        $audit->descriptionMata=$meta->description;
        $audit->keywordsMeta=$meta->keywords;
        $audit->viewportMeta=$meta->viewport;
        $audit->robotsMeta=$meta->robots;
        $audit->news_keywordsMeta=$meta->news_keywords;
        $audit->lengthDescription=$meta->lengthDescription;
        $audit->lengthKeywords=$meta->lengthKeywords;
        $audit->lengthNews_keywords=$meta->lengthNews_keywords;
        $audit->descriptionCount=$meta->descriptionCount;
        $audit->keywordsCount=$meta->keywordsCount;
        $audit->news_keywordsCount=$meta->news_keywordsCount;
        $audit->hasDescription=$meta->hasDescription;
        $audit->duplicateDescription=$meta->duplicateDescription;
        $audit->hasKeywords=$meta->hasKeywords;
        $audit->duplicateKeywords=$meta->duplicateKeywords;
        $audit->hasRobots=$meta->hasRobots;
        $audit->hasViewport=$meta->hasViewport;
        $audit->hasNews_keywords=$meta->hasNews_keywords;
        $audit->duplicateNews_keywords=$meta->duplicateNews_keywords;
        $audit->metas=$meta->metas;
        $audit->checkLengthDescription=$meta->checkLengthDescription();
        $audit->checkDescription=$meta->checkDescription();

        $audit->save();

        $page= new Page($url,$html);
        $audit->canonical=$page->canonical;
        $audit->language=$page->language;
        $audit->docType=$page->docType;
        $audit->encoding=$page->encoding;
        $audit->country=$page->country;
        $audit->city=$page->city;
        $audit->IpAddress=$page->IpAddress;
        $audit->checkTextHtmlRatio=$page->checkTextHtmlRatio();
        $audit->hasCanonical=$page->hasCanonical;
        $audit->ratio=$page->ratio;
        $audit->hasLanguage=$page->hasLanguage;
        $audit->hasDocType=$page->hasDocType;
        $audit->hasEncoding=$page->hasEncoding;
        $audit->hasCountry=$page->hasCountry;
        $audit->hasCity=$page->hasCity;
        $audit->hasIpAddress=$page->hasIpAddress;
        $audit->loadTime=$loadTime;

        $audit->save();

        $heading=new Heading($html);
        $audit->h1=$heading->h1;
        $audit->h2=$heading->h2;
        $audit->h3=$heading->h3;
        $audit->h4=$heading->h4;
        $audit->h5=$heading->h5;
        $audit->h6=$heading->h6;
        $audit->hasH1=$heading->hasH1;
        $audit->hasH2=$heading->hasH2;
        $audit->hasH3=$heading->hasH3;
        $audit->hasH4=$heading->hasH4;
        $audit->hasH5=$heading->hasH5;
        $audit->hasH6=$heading->hasH6;
        $audit->hasManyH1=$heading->hasManyH1;
        $audit->hasGoodHeadings=$heading->hasGoodHeadings;
        $audit->countH1=$heading->countH1;
        $audit->countH2=$heading->countH2;
        $audit->countH3=$heading->countH3;
        $audit->countH4=$heading->countH4;
        $audit->countH5=$heading->countH5;
        $audit->countH6=$heading->countH6;

        $audit->save();

        $image=new Image($html);
        $audit->alt=$image->alt;
        $audit->emptyAlt=$image->emptyAlt;
        $audit->altCount=$image->altCount;
        $audit->imgCount=$image->imgCount;
        $audit->emptyAltCount=$image->emptyAltCount;
        $audit->hasImg=$image->hasImg;
        $audit->hasAlt=$image->hasAlt;
        $audit->hasEmptyAlt=$image->hasEmptyAlt;
        $audit->hasNoAltWithImg=$image->hasNoAltWithImg;
        $audit->hasGoodImg=$image->hasGoodImg;

        $audit->save();

        $check=new Check($rawURL,$html);

        $audit->hasIFrame=$check->hasIFrame;
        $audit->hasFrameSet=$check->hasFrameSet;
        $audit->hasFrame=$check->hasFrame;
        $audit->hasAmpLink=$check->hasAmpLink;
        $audit->hasOG=$check->hasOG;
        $audit->hasTwitterCard=$check->hasTwitterCard;
        $audit->hasFavicon=$check->hasFavicon;
        $audit->hasMicroData=$check->hasMicroData;
        $audit->hasRDFa=$check->hasRDFa;
        $audit->hasJson=$check->hasJson;
        $audit->hasStructuredData=$check->hasStructuredData;
        $audit->hasMicroFormat=$check->hasMicroFormat;
        $audit->hasRobotsFile=$check->hasRobotsFile;
        $audit->hasSiteMap=$check->hasSiteMap;
        $audit->hasFormattedText=$check->hasFormattedText;
        $audit->hasFlash=$check->hasFlash;
        $audit->isIndexAble=$check->isIndexAble;
        $audit->iFrameCount=$check->iFrameCount;
        $audit->frameSetCount=$check->frameSetCount;
        $audit->frameCount=$check->frameCount;
        $audit->anchorCount=$check->anchorCount;
        $audit->ampLink=$check->ampLink;
        $audit->favicon=$check->favicon;
        $audit->robotsFile=$check->robotsFile;
        $audit->defaultRel=$check->defaultRel;
        $audit->openGraph=$check->og;
        $audit->twitterCard=$check->twitterCard;
        $audit->siteMap=$check->siteMap;
        $audit->bItems=$check->bItems;
        $audit->iItems=$check->iItems;
        $audit->emItems=$check->emItems;
        $audit->strongItems=$check->strongItems;
        $audit->URLRedirects=$check->URLRedirects;
        $audit->redirectStatus=$check->redirectStatus;
        $audit->aText=$check->aText;
        $audit->aHref=$check->aHref;
        $audit->aRel=$check->aRel;
        $audit->aStatus=$check->aStatus;

        $audit->save();

        $alexa=new Alexa($url);
        $audit->pageRank=$alexa->pageRank;
        $audit->hasPageRank=$alexa->hasPageRank;
        $audit->rankSignalsUniqueDomainLinksCount=$alexa->rankSignalsUniqueDomainLinksCount;
        $audit->hasRankSignalsUniqueDomainLinksCount=$alexa->hasRankSignalsUniqueDomainLinksCount;
        $audit->globalAlexaRank=$alexa->globalAlexaRank;
        $audit->hasGlobalAlexaRank=$alexa->hasGlobalAlexaRank;
        $audit->rankSignalsTotalBackLinks=$alexa->rankSignalsTotalBackLinks;
        $audit->hasRankSignalsTotalBackLinks=$alexa->hasRankSignalsTotalBackLinks;
        $audit->alexaReach=$alexa->alexaReach;
        $audit->hasAlexaReach=$alexa->hasAlexaReach;
        $audit->countryRank=$alexa->countryRank;
        $audit->hasCountryRank=$alexa->hasCountryRank;
        $audit->alexaBackLinksCount=$alexa->alexaBackLinksCount;
        $audit->hasAlexaBackLinksCount=$alexa->hasAlexaBackLinksCount;
        $audit->alexaBackLinks=$alexa->alexaBackLinks;
        $audit->hasAlexaBackLinks=$alexa->hasAlexaBackLinks;
        $audit->rankDelta=$alexa->rankDelta;
        $audit->countryName=$alexa->countryName;
        $audit->countryCode=$alexa->countryCode;
        $audit->hasRankDelta=$alexa->hasRankDelta;
        $audit->hasCountryName=$alexa->hasCountryName;
        $audit->hasCountryCode=$alexa->hasCountryCode;
        $audit->hasAlexaBackLinks=$alexa->hasAlexaBackLinks;

        $audit->save();

        $backLinks=new BackLinks($url);

        $audit->mozMetrics=$backLinks->mozMetrics;
        $audit->mozLinks=$backLinks->mozLinks;
        $audit->olpLinks=$backLinks->olpLinks;
        $audit->hasMozMetrics=$backLinks->hasMozMetrics;
        $audit->hasMozLinks=$backLinks->hasMozLinks;
        $audit->hasOlpLinks=$backLinks->hasOlpLinks;

        $audit->save();

        $pageSpeed=new PageSpeed($url);

        $audit->hasPageInsightDesktop=$pageSpeed->hasPageInsightDesktop;
        $audit->hasScreenShotSrcDesktop=$pageSpeed->hasScreenShotSrcDesktop;
        $audit->hasScreenShotWidthDesktop=$pageSpeed->hasScreenShotWidthDesktop;
        $audit->hasScreenShotHeightDesktop=$pageSpeed->hasScreenShotHeightDesktop;
        $audit->hasPageInsightMobile=$pageSpeed->hasPageInsightMobile;
        $audit->hasScreenShotSrcMobile=$pageSpeed->hasScreenShotSrcMobile;
        $audit->hasScreenShotWidthMobile=$pageSpeed->hasScreenShotWidthMobile;
        $audit->hasScreenShotHeightMobile=$pageSpeed->hasScreenShotHeightMobile;
        $audit->hasProblemsListDesktop=$pageSpeed->hasProblemsListDesktop;
        $audit->hasProblemsListMobile=$pageSpeed->hasProblemsListMobile;
        $audit->hasImpactsListDesktop=$pageSpeed->hasImpactsListDesktop;
        $audit->hasImpactsListMobile=$pageSpeed->hasImpactsListMobile;
        $audit->pageInsightDesktop=$pageSpeed->pageInsightDesktop;
        $audit->optimizableResourcesDesktop=$pageSpeed->optimizableResourcesDesktop;
        $audit->impactsListDesktop=$pageSpeed->impactsListDesktop;
        $audit->problemsListDesktop=$pageSpeed->problemsListDesktop;
        $audit->pageInsightMobile=$pageSpeed->pageInsightMobile;
        $audit->optimizableResourcesMobile=$pageSpeed->optimizableResourcesMobile;
        $audit->impactsListMobile=$pageSpeed->impactsListMobile;
        $audit->problemsListMobile=$pageSpeed->problemsListMobile;
        $audit->screenShotSrcDesktop=$pageSpeed->screenShotSrcDesktop;
        $audit->screenShotSrcMobile=$pageSpeed->screenShotSrcMobile;
        $audit->screenShotWidthDesktop=$pageSpeed->screenShotWidthDesktop;
        $audit->screenShotHeightDesktop=$pageSpeed->screenShotHeightDesktop;
        $audit->screenShotWidthMobile=$pageSpeed->screenShotWidthMobile;
        $audit->screenShotHeightMobile=$pageSpeed->screenShotHeightMobile;
        $audit->isCompleted=true;

        $audit->save();
    }

    /**
     * The job failed to process.
     *
     * @param  Exception  $exception
     * @return void
     */
    public function failed(Exception $exception)
    {

        $audit=Report::find($this->reportId);
        $audit->isFailed=true;
        $audit->save();

    }
}
