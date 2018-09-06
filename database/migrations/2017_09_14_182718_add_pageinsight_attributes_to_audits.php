<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPageinsightAttributesToAudits extends Migration
{

    /**
     *
     * Developed by :
     * 	Muhammad Elgendi
     *
     * -Capabilities                 -Return-type
     *
     * pageInsightDesktop            array
     * hasPageInsightDesktop         boolean
     * screenShotSrcDesktop          text
     * hasScreenShotSrcDesktop       boolean
     * screenShotWidthDesktop        int
     * screenShotHeightDesktop       int
     * hasScreenShotWidthDesktop     boolean
     * hasScreenShotHeightDesktop    boolean
     * optimizableResourcesDesktop   array
     * impactsListDesktop            array
     * problemsListDesktop           array
     * pageInsightMobile             array
     * hasPageInsightMobile          boolean
     * screenShotSrcMobile           text
     * hasScreenShotSrcMobile        boolean
     * screenShotWidthMobile         int
     * screenShotHeightMobile        int
     * hasScreenShotWidthMobile      boolean
     * hasScreenShotHeightMobile     boolean
     * optimizableResourcesMobile    array
     * impactsListMobile             array
     * problemsListMobile            array
     * hasProblemsListDesktop        boolean
     * hasProblemsListMobile         boolean
     * hasImpactsListDesktop         boolean
     * hasImpactsListMobile          boolean
     *
     *
     **/


    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('audits', function (Blueprint $table) {
            $table->boolean('hasPageInsightDesktop');
            $table->boolean('hasScreenShotSrcDesktop');
            $table->boolean('hasScreenShotWidthDesktop');
            $table->boolean('hasScreenShotHeightDesktop');
            $table->boolean('hasPageInsightMobile');
            $table->boolean('hasScreenShotSrcMobile');
            $table->boolean('hasScreenShotWidthMobile');
            $table->boolean('hasScreenShotHeightMobile');
            $table->boolean('hasProblemsListDesktop');
            $table->boolean('hasProblemsListMobile');
            $table->boolean('hasImpactsListDesktop');
            $table->boolean('hasImpactsListMobile');
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
        Schema::table('audits', function (Blueprint $table) {
            $table->dropColumn([

           'hasPageInsightDesktop',
           'hasScreenShotSrcDesktop',
           'hasScreenShotWidthDesktop',
           'hasScreenShotHeightDesktop',
           'hasPageInsightMobile',
           'hasScreenShotSrcMobile',
           'hasScreenShotWidthMobile',
           'hasScreenShotHeightMobile',
           'hasProblemsListDesktop',
           'hasProblemsListMobile',
           'hasImpactsListDesktop',
           'hasImpactsListMobile',
           'pageInsightDesktop',
           'optimizableResourcesDesktop',
           'impactsListDesktop',
           'problemsListDesktop',
           'pageInsightMobile',
           'optimizableResourcesMobile',
           'impactsListMobile',
           'problemsListMobile',
           'screenShotSrcDesktop',
           'screenShotSrcMobile',
           'screenShotWidthDesktop',
           'screenShotHeightDesktop',
           'screenShotWidthMobile',
           'screenShotHeightMobile'

            ]);
        });
    }
}
