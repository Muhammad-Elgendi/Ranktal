<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAlexaAttributesToAudits extends Migration
{

    /**
     *
     * Developed by :
     * 	Muhammad Elgendi
     *
     * -Capabilities                    -Return-type   Type      -Column-name
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
     * -alexaBackLinks                      array
     * -hasAlexaBackLinks                   boolean
     *
     *Alexa rank is fetched by
     * 1-Alexa API (available free)
     * 2-Alexa API (available restricted usage) credit card is required
     * 3-Rank signals API
     **/

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('audits', function (Blueprint $table) {
            $table->integer('pageRank')->nullable();
            $table->boolean('hasPageRank');
            $table->integer('rankSignalsUniqueDomainLinksCount')->nullable();
            $table->boolean('hasRankSignalsUniqueDomainLinksCount');
            $table->integer('globalAlexaRank')->nullable();
            $table->boolean('hasGlobalAlexaRank');
            $table->integer('rankSignalsTotalBackLinks')->nullable();
            $table->boolean('hasRankSignalsTotalBackLinks');
            $table->integer('alexaReach')->nullable();
            $table->boolean('hasAlexaReach');
            $table->integer('countryRank')->nullable();
            $table->boolean('hasCountryRank');
            $table->integer('alexaBackLinksCount')->nullable();
            $table->boolean('hasAlexaBackLinksCount');
            $table->json('alexaBackLinks')->nullable();
            $table->boolean('hasAlexaBackLinks');
            $table->string('rankDelta')->nullable();
            $table->boolean('hasRankDelta');
            $table->string('countryName')->nullable();
            $table->boolean('hasCountryName');
            $table->string('countryCode')->nullable();
            $table->boolean('hasCountryCode');

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
            'pageRank',
            'hasPageRank',
            'rankSignalsUniqueDomainLinksCount',
            'hasRankSignalsUniqueDomainLinksCount',
            'globalAlexaRank',
            'hasGlobalAlexaRank',
            'rankSignalsTotalBackLinks',
            'hasRankSignalsTotalBackLinks',
            'alexaReach',
            'hasAlexaReach',
            'countryRank',
            'hasCountryRank',
            'alexaBackLinksCount',
            'hasAlexaBackLinksCount',
            'alexaBackLinks',
            'hasAlexaBackLinks',
            'rankDelta',
            'hasRankDelta',
            'countryName',
            'hasCountryName',
            'countryCode',
            'hasCountryCode',
            ]);
        });
    }
}
