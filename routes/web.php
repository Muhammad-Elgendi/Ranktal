<?php

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

// Home الرئيسية
Route::get('/', function () {
    return view('welcome');
});

// Membership system routes
Auth::routes();

//Dashboard لوحة التحكم
Route::get('/dashboard', 'HomeController@index')->name('dashboard');

/**
 * comprehensive-reports Routes
 */

//comprehensive-reports تقارير شاملة
Route::get('/comprehensive-reports','reportController@index');

//To send URL of comprehensive-report
Route::post('report','reportController@makeReport');

//view-comprehensive-reports عرض التقارير الشاملة
Route::get('comprehensive-report/{id}','reportController@view');

// To load comprehensive-reports models using ajax
Route::get('load-report/{id}','reportController@loadReport');

//To Regenerate comprehensive-report
Route::get('regenerate-report/{id}','reportController@regenerateReport');

/**
 * On-page report *MiniReport (Detailed)* Routes
 */

//on-page-reports تقارير السيو الداخلي
Route::get('on-page-reports','MiniReportController@index');

//To send URL of on-page-report
Route::post('on-page-report','MiniReportController@makeReport');

//view-on-page-reports عرض لتقارير السيو الداخلي
Route::get('on-page-report/{id}','MiniReportController@view');

// To load on-page-reports models using ajax
Route::get('load-on-page-report/{id}','MiniReportController@loadReport');

//To Regenerate on-page-report
Route::get('regenerate-on-page-report/{id}','MiniReportController@regenerateReport');

/**
 * Bulk-mini-report Rotes
 */

//To send URLs of bulk-on-page-report
Route::post('bulk-reports','MiniReportController@makeBulkReports');

//view-bulk-reports عرض لتقارير السيو المجمعه
Route::get('bulk-report/{id}','MiniReportController@bulkView');

// To load bulk-reports models using ajax
Route::get('load-bulk-report/{id}','MiniReportController@loadBulkReports');

// To load single-mini-reports models using ajax
Route::get('load-mini-bulk-report','MiniReportController@loadMiniReports');

/*
 * Dev env routes
 * New endpoints routes
 */
Route::get('checker','checkerController@findOrCreateCheck');
Route::get('optimizer','optimizerController@check');
Route::get('metrics','metricsController@getMetrics');
Route::get('pageInsights','pageInsightsController@getPageInsights');
Route::get('backlinks','backlinksController@getBacklinks');
Route::get('add-site','SitesController@addSite');
Route::get('get-site','SitesController@getSite');
//Route::get('/report-generation', function () {
//    return view('report-generation');
//});
//Route::get('ajax','baseTestsController@viewAjax');
//Route::get('load','baseTestsController@loadData');
//Route::get('insert','baseTestsController@insertAjax');
//Route::get('test/{id}','baseTestsController@view');
//Route::get('generate','baseTestsController@storeInt');
//Route::get('testing','baseTestsController@testing');
//Route::get('store','baseTestsController@store');
//Route::get('test','baseTestsController@test');
//Route::get('search/{id}','reportController@search');

