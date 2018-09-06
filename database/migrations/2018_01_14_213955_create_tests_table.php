<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tests', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('hasTitle')->nullable();
            $table->boolean('duplicateTitle')->nullable();
            $table->json('checkLengthTitle')->nullable();
            $table->json('lengthTitle')->nullable();
            $table->json('title')->nullable();
            $table->boolean('checkTitle')->nullable();
            $table->timestamps();

            $table->string('url')->nullable();
            $table->string('domain')->nullable();
            $table->integer('domainLength')->nullable();
            $table->integer('lengthUrl')->nullable();
            $table->string('statusUrl')->nullable();
            $table->string('googleCacheUrl')->nullable();
            $table->integer('spacesUrl')->nullable();
            $table->boolean('checkLengthUrl')->nullable();
            $table->boolean('checkSpacesUrl')->nullable();
            $table->boolean('checkStatusUrl')->nullable();
            $table->boolean('checkUrl')->nullable();

            $table->boolean('hasDescription')->nullable();
            $table->boolean('hasKeywords')->nullable();
            $table->boolean('hasNews_keywords')->nullable();
            $table->boolean('hasRobots')->nullable();
            $table->boolean('hasViewport')->nullable();
            $table->boolean('duplicateDescription')->nullable();
            $table->boolean('duplicateKeywords')->nullable();
            $table->boolean('duplicateNews_keywords')->nullable();
            $table->boolean('checkLengthDescription')->nullable();
            $table->boolean('checkDescription')->nullable();
            $table->string('descriptionMata')->nullable();
            $table->string('keywordsMeta')->nullable();
            $table->string('news_keywordsMeta')->nullable();
            $table->string('robotsMeta')->nullable();
            $table->string('viewportMeta')->nullable();
            $table->integer('lengthDescription')->nullable();
            $table->integer('lengthKeywords')->nullable();
            $table->integer('lengthNews_keywords')->nullable();
            $table->integer('descriptionCount')->nullable();
            $table->integer('keywordsCount')->nullable();
            $table->integer('news_keywordsCount')->nullable();
            $table->json('metas')->nullable();

            $table->float('loadTime')->nullable();
            $table->float('ratio')->nullable();
            $table->boolean('checkTextHtmlRatio')->nullable();
            $table->boolean('hasCanonical')->nullable();
            $table->boolean('hasLanguage')->nullable();
            $table->boolean('hasDocType')->nullable();
            $table->boolean('hasEncoding')->nullable();
            $table->boolean('hasCountry')->nullable();
            $table->boolean('hasCity')->nullable();
            $table->boolean('hasIpAddress')->nullable();
            $table->string('canonical')->nullable();
            $table->string('language')->nullable();
            $table->string('docType')->nullable();
            $table->string('encoding')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('IpAddress')->nullable();

            $table->json('h1')->nullable();
            $table->json('h2')->nullable();
            $table->json('h3')->nullable();
            $table->json('h4')->nullable();
            $table->json('h5')->nullable();
            $table->json('h6')->nullable();
            $table->boolean('hasH1')->nullable();
            $table->boolean('hasH2')->nullable();
            $table->boolean('hasH3')->nullable();
            $table->boolean('hasH4')->nullable();
            $table->boolean('hasH5')->nullable();
            $table->boolean('hasH6')->nullable();
            $table->boolean('hasManyH1')->nullable();
            $table->boolean('hasGoodHeadings')->nullable();
            $table->integer('countH1')->nullable();
            $table->integer('countH2')->nullable();
            $table->integer('countH3')->nullable();
            $table->integer('countH4')->nullable();
            $table->integer('countH5')->nullable();
            $table->integer('countH6')->nullable();

            $table->json('alt')->nullable();
            $table->json('emptyAlt')->nullable();
            $table->integer('altCount')->nullable();
            $table->integer('imgCount')->nullable();
            $table->integer('emptyAltCount')->nullable();
            $table->boolean('hasImg')->nullable();
            $table->boolean('hasAlt')->nullable();
            $table->boolean('hasEmptyAlt')->nullable();
            $table->boolean('hasNoAltWithImg')->nullable();
            $table->boolean('hasGoodImg')->nullable();

            $table->boolean('hasIFrame')->nullable();
            $table->boolean('hasFrameSet')->nullable();
            $table->boolean('hasFrame')->nullable();
            $table->boolean('hasAmpLink')->nullable();
            $table->boolean('hasOG')->nullable();
            $table->boolean('hasTwitterCard')->nullable();
            $table->boolean('hasFavicon')->nullable();
            $table->boolean('hasMicroData')->nullable();
            $table->boolean('hasRDFa')->nullable();
            $table->boolean('hasJson')->nullable();
            $table->boolean('hasStructuredData')->nullable();
            $table->boolean('hasMicroFormat')->nullable();
            $table->boolean('hasRobotsFile')->nullable();
            $table->boolean('hasSiteMap')->nullable();
            $table->boolean('hasFormattedText')->nullable();
            $table->boolean('hasFlash')->nullable();
            $table->boolean('isIndexAble')->nullable();
            $table->integer('iFrameCount')->nullable();
            $table->integer('frameSetCount')->nullable();
            $table->integer('frameCount')->nullable();
            $table->integer('anchorCount')->nullable();
            $table->string('ampLink')->nullable();
            $table->string('favicon')->nullable();
            $table->string('robotsFile')->nullable();
            $table->string('defaultRel')->nullable();
            $table->json('openGraph')->nullable();
            $table->json('twitterCard')->nullable();
            $table->json('siteMap')->nullable();
            $table->json('bItems')->nullable();
            $table->json('iItems')->nullable();
            $table->json('emItems')->nullable();
            $table->json('strongItems')->nullable();
            $table->json('URLRedirects')->nullable();
            $table->json('redirectStatus')->nullable();
            $table->json('aText')->nullable();
            $table->json('aHref')->nullable();
            $table->json('aRel')->nullable();
            $table->json('aStatus')->nullable();

            $table->integer('pageRank')->nullable();
            $table->boolean('hasPageRank')->nullable();
            $table->integer('rankSignalsUniqueDomainLinksCount')->nullable();
            $table->boolean('hasRankSignalsUniqueDomainLinksCount')->nullable();
            $table->integer('globalAlexaRank')->nullable();
            $table->boolean('hasGlobalAlexaRank')->nullable();
            $table->integer('rankSignalsTotalBackLinks')->nullable();
            $table->boolean('hasRankSignalsTotalBackLinks')->nullable();
            $table->integer('alexaReach')->nullable();
            $table->boolean('hasAlexaReach')->nullable();
            $table->integer('countryRank')->nullable();
            $table->boolean('hasCountryRank')->nullable();
            $table->integer('alexaBackLinksCount')->nullable();
            $table->boolean('hasAlexaBackLinksCount')->nullable();
            $table->json('alexaBackLinks')->nullable();
            $table->boolean('hasAlexaBackLinks')->nullable();
            $table->string('rankDelta')->nullable();
            $table->boolean('hasRankDelta')->nullable();
            $table->string('countryName')->nullable();
            $table->boolean('hasCountryName')->nullable();
            $table->string('countryCode')->nullable();
            $table->boolean('hasCountryCode')->nullable();

            $table->json('mozMetrics')->nullable();
            $table->json('mozLinks')->nullable();
            $table->json('olpLinks')->nullable();
            $table->boolean('hasMozMetrics')->nullable();
            $table->boolean('hasMozLinks')->nullable();
            $table->boolean('hasOlpLinks')->nullable();

            $table->boolean('hasPageInsightDesktop')->nullable();
            $table->boolean('hasScreenShotSrcDesktop')->nullable();
            $table->boolean('hasScreenShotWidthDesktop')->nullable();
            $table->boolean('hasScreenShotHeightDesktop')->nullable();
            $table->boolean('hasPageInsightMobile')->nullable();
            $table->boolean('hasScreenShotSrcMobile')->nullable();
            $table->boolean('hasScreenShotWidthMobile')->nullable();
            $table->boolean('hasScreenShotHeightMobile')->nullable();
            $table->boolean('hasProblemsListDesktop')->nullable();
            $table->boolean('hasProblemsListMobile')->nullable();
            $table->boolean('hasImpactsListDesktop')->nullable();
            $table->boolean('hasImpactsListMobile')->nullable();
            $table->json('pageInsightDesktop')->nullable();
            $table->json('optimizableResourcesDesktop')->nullable();
            $table->json('impactsListDesktop')->nullable();
            $table->json('problemsListDesktop')->nullable();
            $table->json('pageInsightMobile')->nullable();
            $table->json('optimizableResourcesMobile')->nullable();
            $table->json('impactsListMobile')->nullable();
            $table->json('problemsListMobile')->nullable();
            $table->text('screenShotSrcDesktop')->nullable();
            $table->text('screenShotSrcMobile')->nullable();
            $table->smallInteger('screenShotWidthDesktop')->nullable();
            $table->smallInteger('screenShotHeightDesktop')->nullable();
            $table->smallInteger('screenShotWidthMobile')->nullable();
            $table->smallInteger('screenShotHeightMobile')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tests');
    }
}
