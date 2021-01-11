<?php
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\campaign;
use App\Http\Controllers\CampaignsController;
use App\Mail\CampaignNotification;
use Illuminate\Support\Carbon;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


$optionalLanguageRoutes = function () {

    // Home الرئيسية
    Route::get('/', function () {
        return redirect()->route('dashboard');
    })->name('home');

    // Membership system routes
    Auth::routes();

    //Views
    Route::get('dashboard', 'HomeController@index')->name('dashboard'); //Dashboard
    Route::get('dashboard/page-optimization', 'optimizerController@index')->name('page-optimization')->middleware('guard:optimizations_monthly'); //Page optimization view    
    Route::get('dashboard/seo-audit', 'checkerController@index')->name('seo-audit')->middleware('guard:audits_monthly'); //Seo audit view
    Route::get('dashboard/on-demand-crawl', 'CrawlingController@index')->name('on-demand-crawl')->middleware('guard:crawl_monthly'); // Site Crawl view
    Route::get('dashboard/seo-campaigns', 'CampaignsController@index')->name('seo-campaigns'); // SEO Campaigns view
    Route::get('dashboard/plans', 'CheckoutController@plans')->name('plans'); // plans view
    Route::get('settings', 'SettingsController@view')->name('settings'); // settings view

    // Route::get('dashboard/backlinks-checker', 'backlinksController@index')->name('backlinks-checker'); //Backlinks checker view
    // Route::get('dashboard/keyword-tracker', 'KeywordTrackerController@index')->name('keyword-tracker'); // Keyword Tracker View
    // Route::get('dashboard/keyword-research', 'KeywordResearchController@index')->name('keyword-research'); // Keyword Research View

    //Ajax Views Routes
    Route::get('optimizer-view', 'optimizerController@viewChecksUsingAjax')->name('optimizerAjax')->middleware(['updateUsage:optimizations_monthly','log']);
    Route::get('backlinks-view', 'backlinksController@viewBacklinksUsingAjax')->name('backlinksAjax');
    Route::get('seo-audit-view', 'checkerController@viewChecksUsingAjax')->name('seoAuditAjax')->middleware(['updateUsage:audits_monthly','log']);
    Route::get('demand-crawl-view', 'CrawlingController@viewSiteCrawlUsingAjax')->name('demandCrawlAjax')->middleware(['updateUsage:crawl_monthly','log']);
    // Route::get('keyword-tracker-view', 'KeywordTrackerController@viewkeywordTrackerUsingAjax')->name('keywordTrackerAjax');
    // Route::get('keyword-research-view', 'KeywordResearchController@viewkeywordResearchUsingAjax')->name('keywordResearchAjax');


    // Endpoints routes
    Route::get('checker', 'checkerController@viewChecksUsingAjax'); //Seo audit 
    Route::get('optimizer', 'optimizerController@check')->name('optimizer');  //Page optimization
    Route::get('metrics', 'metricsController@getMetrics');
    Route::get('pageInsights', 'pageInsightsController@getPageInsights');
    Route::get('backlinks', 'backlinksController@handleBacklinks'); //Backlinks checker
    Route::get('crawl', 'CrawlingController@doSiteCrawl'); //Site Crawl
    Route::get('demand-crawl-sitemap', 'CrawlingController@generateSitemap')->name('demandCrawlsitemap'); // Generate an XML site map of a site 

   

    // Actions routes - plans
    Route::post('dashboard/checkout', 'CheckoutController@updatePlan')->name('checkout'); // Update User Plan

    // Actions routes - Account settings
    Route::post('settings/edit', 'SettingsController@edit')->name('edit-settings'); // Edit Account settings

    // Actions routes - seo-audit
    Route::delete('seo-audit-delete/{id}', 'checkerController@destroy')->name('seoAuditDelete');
    Route::get('seo-audit-reaudit', 'checkerController@reaudit')->name('seoAuditReaudit')->middleware(['updateUsage:audits_monthly','guard:audits_monthly','log']);

    // Actions routes - demand-crawl
    Route::delete('demand-crawl-delete/{id}', 'CrawlingController@destroy')->name('demandCrawlDelete');
    Route::get('demand-crawl-recrawl', 'CrawlingController@recrawl')->name('demandCrawlRecrawl')->middleware(['updateUsage:crawl_monthly','guard:crawl_monthly','log']);

    // Actions routes - seo-campaigns
    Route::get('dashboard/seo-campaigns/create', 'CampaignsController@create')->name('seo-campaign-create')->middleware('guard:campaigns_monthly'); // create SEO Campaign view
    Route::post('dashboard/seo-campaigns/store', 'CampaignsController@store')->name('seo-campaign-store')->middleware(['updateUsage:campaigns_monthly','log']); // store SEO Campaign
    Route::delete('seo-campaigns-delete/{id}', 'CampaignsController@destroy')->name('seoCampaignDelete');
    Route::get('dashboard/seo-campaigns/edit/{id}', 'CampaignsController@edit')->name('seo-campaign-edit'); // Edit SEO Campaign view
    Route::post('dashboard/seo-campaigns/save', 'CampaignsController@saveEdit')->name('seo-campaign-saveEdit'); // save Edits SEO Campaign
    Route::get('dashboard/seo-campaigns/view/{id}', 'CampaignsController@view')->name('seo-campaign-view'); // View SEO Campaign
    Route::get('dashboard/seo-campaigns/view/{campaign_id}/optimization/{page_id}', 'CampaignsController@viewOptimization')->name('seo-campaign-view-optimization'); // View optimization of page in Campaign

 //------------------------------------------------------------------------------------------------------------

    /**
     * comprehensive-reports Routes
     */

    // //comprehensive-reports تقارير شاملة
    // Route::get('/comprehensive-reports', 'reportController@index');

    // //To send URL of comprehensive-report
    // Route::post('report', 'reportController@makeReport');

    // //view-comprehensive-reports عرض التقارير الشاملة
    // Route::get('comprehensive-report/{id}', 'reportController@view');

    // // To load comprehensive-reports models using ajax
    // Route::get('load-report/{id}', 'reportController@loadReport');

    // //To Regenerate comprehensive-report
    // Route::get('regenerate-report/{id}', 'reportController@regenerateReport');

    // /**
    //  * On-page report *MiniReport (Detailed)* Routes
    //  */

    // //on-page-reports تقارير السيو الداخلي
    // Route::get('on-page-reports', 'MiniReportController@index');

    // //To send URL of on-page-report
    // Route::post('on-page-report', 'MiniReportController@makeReport');

    // //view-on-page-reports عرض لتقارير السيو الداخلي
    // Route::get('on-page-report/{id}', 'MiniReportController@view');

    // // To load on-page-reports models using ajax
    // Route::get('load-on-page-report/{id}', 'MiniReportController@loadReport');

    // //To Regenerate on-page-report
    // Route::get('regenerate-on-page-report/{id}', 'MiniReportController@regenerateReport');

    // /**
    //  * Bulk-mini-report Rotes
    //  */

    // //To send URLs of bulk-on-page-report
    // Route::post('bulk-reports', 'MiniReportController@makeBulkReports');

    // //view-bulk-reports عرض لتقارير السيو المجمعه
    // Route::get('bulk-report/{id}', 'MiniReportController@bulkView');

    // // To load bulk-reports models using ajax
    // Route::get('load-bulk-report/{id}', 'MiniReportController@loadBulkReports');

    // // To load single-mini-reports models using ajax
    // Route::get('load-mini-bulk-report', 'MiniReportController@loadMiniReports');
};

// Add routes with lang-prefix
Route::group(['prefix' => '{lang}', 'where' => ['lang' => '[a-zA-Z]{2}'] , 'as' => 'lang.'], $optionalLanguageRoutes);

// Add routes without prefix
$optionalLanguageRoutes();