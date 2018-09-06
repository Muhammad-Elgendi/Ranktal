<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCheckAttributesToAudits extends Migration
{
    /**
     *
     * Developed by :
     * 	Muhammad Elgendi
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
     * -og                                             array  openGraph
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
     **/

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('audits', function (Blueprint $table) {
            $table->boolean('hasIFrame');
            $table->boolean('hasFrameSet');
            $table->boolean('hasFrame');
            $table->boolean('hasAmpLink');
            $table->boolean('hasOG');
            $table->boolean('hasTwitterCard');
            $table->boolean('hasFavicon');
            $table->boolean('hasMicroData');
            $table->boolean('hasRDFa');
            $table->boolean('hasJson');
            $table->boolean('hasStructuredData');
            $table->boolean('hasMicroFormat');
            $table->boolean('hasRobotsFile');
            $table->boolean('hasSiteMap');
            $table->boolean('hasFormattedText');
            $table->boolean('hasFlash');
            $table->boolean('isIndexAble');
            $table->integer('iFrameCount');
            $table->integer('frameSetCount');
            $table->integer('frameCount');
            $table->integer('anchorCount');
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

            'hasIFrame',
            'hasFrameSet',
            'hasFrame',
            'hasAmpLink',
            'hasOG',
            'hasTwitterCard',
            'hasFavicon',
            'hasMicroData',
            'hasRDFa',
            'hasJson',
            'hasStructuredData',
            'hasMicroFormat',
            'hasRobotsFile',
            'hasSiteMap',
            'hasFormattedText',
            'hasFlash',
            'isIndexAble',
            'iFrameCount',
            'frameSetCount',
            'frameCount',
            'anchorCount',
            'ampLink',
            'favicon',
            'robotsFile',
            'defaultRel',
            'openGraph',
            'twitterCard',
            'siteMap',
            'bItems',
            'iItems',
            'emItems',
            'strongItems',
            'URLRedirects',
            'redirectStatus',
            'aText',
            'aHref',
            'aRel',
            'aStatus'
            
            ]);
        });
    }
}
