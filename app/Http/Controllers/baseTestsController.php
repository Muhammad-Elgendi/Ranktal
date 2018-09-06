<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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


use App\audit;
use App\test as test;

class baseTestsController extends Controller
{

    public function test(){

        $url='   http://islamland.net  ';
        $url=trim($url);
        $headers = get_headers($url, 1);
        if ($headers !== false && isset($headers['Location'])) {
            $url= is_array($headers['Location']) ? array_pop($headers['Location']) : $headers['Location'];
        }
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $html = curl_exec($ch);
        if ( $html === false | empty($html)){
            die('Failed to connect the site');
        }

        $page=new PageSpeed($url);
        $report=get_object_vars($page);

        return $report;
    }

    /**
     * @return string
     */
    public function store(){

        /**
         * page load time is set from the following connection only
         * the Raw URL is supplied directly to check constructor after trim it
         */

        $url='   https://7ail.net  ';


        $rawURL=$url=trim($url);

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
        /**
         *
         * Developed by :
         * 	Muhammad Elgendi
         *
         * -Capabilities   -Properties    -Return-type  Type (Conditional-output) -Column-name
         *
         * 	-check existence   -hasTitle       -boolean field
         * 	-check duplication -duplicateTitle -boolean field
         * 	-check length(s)   -checkLength    -boolean field (var or array) -checkLengthTitle
         * 	-get length(s)     -length         -integer field (var or array) -lengthTitle
         * 	-get title(s)      -title          -string  field (var or array)
         * 	-make final check  -check          -boolean function             -checkTitle
         *
         * -Capabilities   -Properties           -Return-type   Type      -Column-name
         *
         * 	-Decoded Url       -url              -string        field
         *  -Domain name       -domain           -string        field
         *  -Domain length     -domainLength     -integer       field
         * 	-length of Url     -urlLength        -integer       field     -lengthUrl
         * 	-status of Url     -status           -string        field     -statusUrl
         * 	-google_cache_url  -google_cache_url -string        field     -googleCacheUrl
         * 	-count_of_spaces   -count_of_spaces  -integer       field     -spacesUrl
         *  -check length      -check_length     -boolean       function  -checkLengthUrl
         *  -check spaces      -check_spaces     -boolean       function  -checkSpacesUrl
         *  -check status      -check_status     -boolean       function  -checkStatusUrl
         * 	-make final check  -check            -boolean       function  -checkUrl
         *
         * Ideas :
         *  use trim() to remove any thing from the beginning and ending of the url
         *
         * -Capabilities               -Return-type   Type      -Column-name
         *
         * 	-get('description')        -string        function  -descriptionMata
         *  -get('keywords')           -string        function  -keywordsMeta
         *  -get('viewport')           -string        function  -viewportMeta
         * 	-get('robots')             -string        function  -robotsMeta
         *  -get('news_keywords')      -string        function  -news_keywordsMeta
         *  -get('lengthDescription')  -integer       function  -lengthDescription
         *  -get('lengthKeywords')     -integer       function  -lengthKeywords
         *  -get('lengthNews_keywords')-integer       function  -lengthNews_keywords
         *  -get('descriptionCount')   -integer       function  -descriptionCount
         *  -get('keywordsCount')      -integer       function  -keywordsCount
         *  -get('news_keywordsCount') -integer       function  -news_keywordsCount
         *  -hasDescription            -boolean          field  -
         *  -duplicateDescription      -boolean          field  -
         *  -hasKeywords               -boolean          field  -
         *  -duplicateKeywords         -boolean          field  -
         *  -hasRobots                 -boolean          field  -
         *  -hasViewport               -boolean          field  -
         *  -hasNews_keywords          -boolean          field  -
         *  -duplicateNews_keywords    -boolean          field  -
         * 	-getAll()                  -array         function  -metas
         *  -checkLengthDescription()  -boolean       function  -checkLengthDescription
         *  -checkDescription()        -boolean       function  -checkDescription
         *
         * Notes :
         *
         *  lack of check robots and the follow and index for the page
         *
         * -Capabilities               -Return-type   Type      -Column-name
         *
         * 	-get('canonical')          -string        function  -canonical
         *  -get('language')           -string        function  -language
         *  -get('docType')            -string        function  -docType
         * 	-get('encoding')           -string        function  -encoding
         *  -get('country')            -string        function  -country
         *  -get('city')               -string        function  -city
         *  -get('IpAddress')          -string        function  -IpAddress
         *  -checkTextHtmlRatio()      -boolean       function  -checkTextHtmlRatio
         *  -hasCanonical              -boolean       field
         *  -ratio                     -float         field
         *  -hasLanguage               -boolean       field
         *  -hasDocType                -boolean       field
         *  -hasEncoding               -boolean       field
         *  -hasCountry                -boolean       field
         *  -hasCity                   -boolean       field
         *  -hasIpAddress              -boolean       field
         *                             -float                   -loadTime
         *
         * -Capabilities               -Return-type   Type      -Column-name
         *
         * -h1                         -array
         * -h2                         -array
         * -h3                         -array
         * -h4                         -array
         * -h5                         -array
         * -h6                         -array
         * -hasH1                      -boolean
         * -hasH2                      -boolean
         * -hasH3                      -boolean
         * -hasH4                      -boolean
         * -hasH5                      -boolean
         * -hasH6                      -boolean
         * -countH1                    -integer
         * -countH2                    -integer
         * -countH3                    -integer
         * -countH4                    -integer
         * -countH5                    -integer
         * -countH6                    -integer
         * -hasManyH1                  -boolean
         * -hasGoodHeadings            -boolean
         *
         * -Capabilities               -Return-type
         *
         * -alt                        -array
         * -emptyAlt                   -array
         * -altCount                   -integer
         * -imgCount                   -integer
         * -emptyAltCount              -integer
         * -hasImg                     -boolean
         * -hasEmptyAlt                -boolean
         * -hasAlt                     -boolean
         * -hasNoAltWithImg            -boolean
         * -hasGoodImg                 -boolean
         *
         * -Capabilities               -Return-type   Type      -Column-name
         *
         * -iFrameCount                                 integer
         * -frameSetCount                               integer
         * -frameCount                                   integer
         * -hasIFrame                                    boolean
         * -hasFrameSet                                   boolean
         * -hasFrame                                      boolean
         * -ampLink                                       string
         * -og                                             array   openGraph
         * -twitterCard                                    array
         * -favicon                                        string
         * -hasAmpLink                                        boolean
         * -hasOG                                             boolean
         * -hasTwitterCard                                    boolean
         * -hasFavicon                                        boolean
         * -hasMicroData                                      boolean
         * -hasRDFa                                           boolean
         * -hasJson                                           boolean
         * -hasStructuredData                                 boolean
         * -hasMicroFormat                                    boolean
         * -robotsFile                                      string
         * -siteMap                                         array
         * -bItems                                         array
         * -iItems                                         array
         * -emItems                                        array
         * -strongItems                                    array
         * -URLRedirects                                    array
         * -redirectStatus                                 array
         * -anchorCount                                     integer
         * -defaultRel                                   string
         * -aText                                        array
         * -aHref                                         array
         * -aRel                                          array
         * -aStatus                                       array
         * -hasRobotsFile                                  boolean
         * -hasSiteMap                                     boolean
         * -hasFormattedText                              boolean
         * -hasFlash                                     boolean
         * -isIndexAble                                  boolean
         *
         * -Capabilities                    -Return-type
         *
         * -pageRank                              int
         * -rankSignalsUniqueDomainLinksCount     int
         * -globalAlexaRank                       int
         * -rankSignalsTotalBackLinks             int
         * -alexaReach                            int
         * -rankDelta                           string
         * -countryName                         string
         * -countryCode                         string
         * -countryRank                           int
         * -alexaBackLinksCount                   int
         * -alexaBackLinks                        array
         * -hasAlexaBackLinks                   boolean
         *
         * -Capabilities                 -Return-type
         *
         * mozMetrics                     array
         * hasMozMetrics                  boolean
         * mozLinks                       array
         * hasMozLinks                    boolean
         * olpLinks                       array
         * hasOlpLinks                    boolean
         *
         * BackLinks constructor.
         * @param $url
         *
         **/

        $audit=new audit;

        $title=new Title($html);
        $audit->hasTitle=$title->hasTitle;
        $audit->duplicateTitle=$title->duplicateTitle;
        $audit->checkLengthTitle=$title->checkLength;
        $audit->lengthTitle=$title->length;
        $audit->title=$title->title;
        $audit->checkTitle=$title->check();

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

       $backLinks=new BackLinks($url);

       $audit->mozMetrics=$backLinks->mozMetrics;
       $audit->mozLinks=$backLinks->mozLinks;
       $audit->olpLinks=$backLinks->olpLinks;
       $audit->hasMozMetrics=$backLinks->hasMozMetrics;
       $audit->hasMozLinks=$backLinks->hasMozLinks;
       $audit->hasOlpLinks=$backLinks->hasOlpLinks;

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

        $audit->save();
        return 'The record saved successfully';

    }


    /**
     * Shows the reports from db
     * With convention boolean in migration must be casted into (bool)
     * and decoded json
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model     *
     */
    public function view($id){
        $audit=audit::findOrFail($id);
        return $audit;
    }

    public function storeInt(){
        $url='http://www.islamland.net';

        /**
         * page load time is set from the following connection only
         * the Raw URL is supplied directly to check constructor after trim it
         */
        $tempURL=trim($url);

        if(stripos($tempURL,'http://')=== false)
            $tempURL='http://'.$tempURL;

        $rawURL=$url=$tempURL;


//        $headers = get_headers($url, 1);
//        if ($headers !== false && isset($headers['Location'])) {
//            $url= is_array($headers['Location']) ? array_pop($headers['Location']) : $headers['Location'];
//        }
        $started_at = microtime(true);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $html = curl_exec($ch);
        if ( $html === false | empty($html)){
            die('Failed to connect the site');
        }
        $loadTime=round((microtime(true) - $started_at),2);


        $audit=new test();

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

//        $meta= new Meta($url,$html);
//        $audit->descriptionMata=$meta->description;
//        $audit->keywordsMeta=$meta->keywords;
//        $audit->viewportMeta=$meta->viewport;
//        $audit->robotsMeta=$meta->robots;
//        $audit->news_keywordsMeta=$meta->news_keywords;
//        $audit->lengthDescription=$meta->lengthDescription;
//        $audit->lengthKeywords=$meta->lengthKeywords;
//        $audit->lengthNews_keywords=$meta->lengthNews_keywords;
//        $audit->descriptionCount=$meta->descriptionCount;
//        $audit->keywordsCount=$meta->keywordsCount;
//        $audit->news_keywordsCount=$meta->news_keywordsCount;
//        $audit->hasDescription=$meta->hasDescription;
//        $audit->duplicateDescription=$meta->duplicateDescription;
//        $audit->hasKeywords=$meta->hasKeywords;
//        $audit->duplicateKeywords=$meta->duplicateKeywords;
//        $audit->hasRobots=$meta->hasRobots;
//        $audit->hasViewport=$meta->hasViewport;
//        $audit->hasNews_keywords=$meta->hasNews_keywords;
//        $audit->duplicateNews_keywords=$meta->duplicateNews_keywords;
//        $audit->metas=$meta->metas;
//        $audit->checkLengthDescription=$meta->checkLengthDescription();
//        $audit->checkDescription=$meta->checkDescription();
//
//        $audit->save();
//
//        $page= new Page($url,$html);
//        $audit->canonical=$page->canonical;
//        $audit->language=$page->language;
//        $audit->docType=$page->docType;
//        $audit->encoding=$page->encoding;
//        $audit->country=$page->country;
//        $audit->city=$page->city;
//        $audit->IpAddress=$page->IpAddress;
//        $audit->checkTextHtmlRatio=$page->checkTextHtmlRatio();
//        $audit->hasCanonical=$page->hasCanonical;
//        $audit->ratio=$page->ratio;
//        $audit->hasLanguage=$page->hasLanguage;
//        $audit->hasDocType=$page->hasDocType;
//        $audit->hasEncoding=$page->hasEncoding;
//        $audit->hasCountry=$page->hasCountry;
//        $audit->hasCity=$page->hasCity;
//        $audit->hasIpAddress=$page->hasIpAddress;
//        $audit->loadTime=$loadTime;
//
//        $heading=new Heading($html);
//        $audit->h1=$heading->h1;
//        $audit->h2=$heading->h2;
//        $audit->h3=$heading->h3;
//        $audit->h4=$heading->h4;
//        $audit->h5=$heading->h5;
//        $audit->h6=$heading->h6;
//        $audit->hasH1=$heading->hasH1;
//        $audit->hasH2=$heading->hasH2;
//        $audit->hasH3=$heading->hasH3;
//        $audit->hasH4=$heading->hasH4;
//        $audit->hasH5=$heading->hasH5;
//        $audit->hasH6=$heading->hasH6;
//        $audit->hasManyH1=$heading->hasManyH1;
//        $audit->hasGoodHeadings=$heading->hasGoodHeadings;
//        $audit->countH1=$heading->countH1;
//        $audit->countH2=$heading->countH2;
//        $audit->countH3=$heading->countH3;
//        $audit->countH4=$heading->countH4;
//        $audit->countH5=$heading->countH5;
//        $audit->countH6=$heading->countH6;
//
//        $image=new Image($html);
//        $audit->alt=$image->alt;
//        $audit->emptyAlt=$image->emptyAlt;
//        $audit->altCount=$image->altCount;
//        $audit->imgCount=$image->imgCount;
//        $audit->emptyAltCount=$image->emptyAltCount;
//        $audit->hasImg=$image->hasImg;
//        $audit->hasAlt=$image->hasAlt;
//        $audit->hasEmptyAlt=$image->hasEmptyAlt;
//        $audit->hasNoAltWithImg=$image->hasNoAltWithImg;
//        $audit->hasGoodImg=$image->hasGoodImg;
//
//        $check=new Check($rawURL,$html);
//
//        $audit->hasIFrame=$check->hasIFrame;
//        $audit->hasFrameSet=$check->hasFrameSet;
//        $audit->hasFrame=$check->hasFrame;
//        $audit->hasAmpLink=$check->hasAmpLink;
//        $audit->hasOG=$check->hasOG;
//        $audit->hasTwitterCard=$check->hasTwitterCard;
//        $audit->hasFavicon=$check->hasFavicon;
//        $audit->hasMicroData=$check->hasMicroData;
//        $audit->hasRDFa=$check->hasRDFa;
//        $audit->hasJson=$check->hasJson;
//        $audit->hasStructuredData=$check->hasStructuredData;
//        $audit->hasMicroFormat=$check->hasMicroFormat;
//        $audit->hasRobotsFile=$check->hasRobotsFile;
//        $audit->hasSiteMap=$check->hasSiteMap;
//        $audit->hasFormattedText=$check->hasFormattedText;
//        $audit->hasFlash=$check->hasFlash;
//        $audit->isIndexAble=$check->isIndexAble;
//        $audit->iFrameCount=$check->iFrameCount;
//        $audit->frameSetCount=$check->frameSetCount;
//        $audit->frameCount=$check->frameCount;
//        $audit->anchorCount=$check->anchorCount;
//        $audit->ampLink=$check->ampLink;
//        $audit->favicon=$check->favicon;
//        $audit->robotsFile=$check->robotsFile;
//        $audit->defaultRel=$check->defaultRel;
//        $audit->openGraph=$check->og;
//        $audit->twitterCard=$check->twitterCard;
//        $audit->siteMap=$check->siteMap;
//        $audit->bItems=$check->bItems;
//        $audit->iItems=$check->iItems;
//        $audit->emItems=$check->emItems;
//        $audit->strongItems=$check->strongItems;
//        $audit->URLRedirects=$check->URLRedirects;
//        $audit->redirectStatus=$check->redirectStatus;
//        $audit->aText=$check->aText;
//        $audit->aHref=$check->aHref;
//        $audit->aRel=$check->aRel;
//        $audit->aStatus=$check->aStatus;
//
//        $alexa=new Alexa($url);
//        $audit->pageRank=$alexa->pageRank;
//        $audit->hasPageRank=$alexa->hasPageRank;
//        $audit->rankSignalsUniqueDomainLinksCount=$alexa->rankSignalsUniqueDomainLinksCount;
//        $audit->hasRankSignalsUniqueDomainLinksCount=$alexa->hasRankSignalsUniqueDomainLinksCount;
//        $audit->globalAlexaRank=$alexa->globalAlexaRank;
//        $audit->hasGlobalAlexaRank=$alexa->hasGlobalAlexaRank;
//        $audit->rankSignalsTotalBackLinks=$alexa->rankSignalsTotalBackLinks;
//        $audit->hasRankSignalsTotalBackLinks=$alexa->hasRankSignalsTotalBackLinks;
//        $audit->alexaReach=$alexa->alexaReach;
//        $audit->hasAlexaReach=$alexa->hasAlexaReach;
//        $audit->countryRank=$alexa->countryRank;
//        $audit->hasCountryRank=$alexa->hasCountryRank;
//        $audit->alexaBackLinksCount=$alexa->alexaBackLinksCount;
//        $audit->hasAlexaBackLinksCount=$alexa->hasAlexaBackLinksCount;
//        $audit->alexaBackLinks=$alexa->alexaBackLinks;
//        $audit->hasAlexaBackLinks=$alexa->hasAlexaBackLinks;
//        $audit->rankDelta=$alexa->rankDelta;
//        $audit->countryName=$alexa->countryName;
//        $audit->countryCode=$alexa->countryCode;
//        $audit->hasRankDelta=$alexa->hasRankDelta;
//        $audit->hasCountryName=$alexa->hasCountryName;
//        $audit->hasCountryCode=$alexa->hasCountryCode;
//        $audit->hasAlexaBackLinks=$alexa->hasAlexaBackLinks;
//
//        $backLinks=new BackLinks($url);
//
//        $audit->mozMetrics=$backLinks->mozMetrics;
//        $audit->mozLinks=$backLinks->mozLinks;
//        $audit->olpLinks=$backLinks->olpLinks;
//        $audit->hasMozMetrics=$backLinks->hasMozMetrics;
//        $audit->hasMozLinks=$backLinks->hasMozLinks;
//        $audit->hasOlpLinks=$backLinks->hasOlpLinks;
//
//        $pageSpeed=new PageSpeed($url);
//
//        $audit->hasPageInsightDesktop=$pageSpeed->hasPageInsightDesktop;
//        $audit->hasScreenShotSrcDesktop=$pageSpeed->hasScreenShotSrcDesktop;
//        $audit->hasScreenShotWidthDesktop=$pageSpeed->hasScreenShotWidthDesktop;
//        $audit->hasScreenShotHeightDesktop=$pageSpeed->hasScreenShotHeightDesktop;
//        $audit->hasPageInsightMobile=$pageSpeed->hasPageInsightMobile;
//        $audit->hasScreenShotSrcMobile=$pageSpeed->hasScreenShotSrcMobile;
//        $audit->hasScreenShotWidthMobile=$pageSpeed->hasScreenShotWidthMobile;
//        $audit->hasScreenShotHeightMobile=$pageSpeed->hasScreenShotHeightMobile;
//        $audit->hasProblemsListDesktop=$pageSpeed->hasProblemsListDesktop;
//        $audit->hasProblemsListMobile=$pageSpeed->hasProblemsListMobile;
//        $audit->hasImpactsListDesktop=$pageSpeed->hasImpactsListDesktop;
//        $audit->hasImpactsListMobile=$pageSpeed->hasImpactsListMobile;
//        $audit->pageInsightDesktop=$pageSpeed->pageInsightDesktop;
//        $audit->optimizableResourcesDesktop=$pageSpeed->optimizableResourcesDesktop;
//        $audit->impactsListDesktop=$pageSpeed->impactsListDesktop;
//        $audit->problemsListDesktop=$pageSpeed->problemsListDesktop;
//        $audit->pageInsightMobile=$pageSpeed->pageInsightMobile;
//        $audit->optimizableResourcesMobile=$pageSpeed->optimizableResourcesMobile;
//        $audit->impactsListMobile=$pageSpeed->impactsListMobile;
//        $audit->problemsListMobile=$pageSpeed->problemsListMobile;
//        $audit->screenShotSrcDesktop=$pageSpeed->screenShotSrcDesktop;
//        $audit->screenShotSrcMobile=$pageSpeed->screenShotSrcMobile;
//        $audit->screenShotWidthDesktop=$pageSpeed->screenShotWidthDesktop;
//        $audit->screenShotHeightDesktop=$pageSpeed->screenShotHeightDesktop;
//        $audit->screenShotWidthMobile=$pageSpeed->screenShotWidthMobile;
//        $audit->screenShotHeightMobile=$pageSpeed->screenShotHeightMobile;

//        $id=$audit->id;
//        return redirect('view/'.$id);
    }

    public function insertAjax(){
        $test=new test();
        $test->save();
        return"another one added";
    }

    public function viewAjax(){
        return view('ajax');
    }

    public function loadData(){
        $test = test::all();
        return $test;
    }

    public function testing(){
        $url = 'https://7ail.net/';

        print_r(get_headers($url));

        print_r(get_headers($url, 1));
    }

}
