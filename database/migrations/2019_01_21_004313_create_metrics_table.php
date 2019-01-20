<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMetricsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('metrics', function (Blueprint $table) {
            $table->increments('id');
            $table->string('url',3000)->unique();
            $table->unsignedInteger('pageRank')->nullable();
            $table->unsignedInteger('rankSignalsUniqueDomainLinksCount')->nullable();
            $table->unsignedInteger('rankSignalsTotalBackLinks')->nullable();
            $table->unsignedInteger('globalAlexaRank')->nullable();
            $table->unsignedInteger('alexaReach')->nullable();
            $table->string('rankDelta')->nullable();
            $table->string('countryName')->nullable();
            $table->unsignedInteger('countryRank')->nullable();
            $table->unsignedInteger('alexaBackLinksCount')->nullable();
            $table->float('MozRankURL',3,3)->nullable();
            $table->float('MozRankSubdomain',3,3)->nullable();
            $table->unsignedInteger('PageAuthority')->nullable();
            $table->unsignedInteger('DomainAuthority')->nullable();
            $table->unsignedInteger('MozTotalLinks')->nullable();
            $table->unsignedInteger('MozExternalEquityLinks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('metrics');
    }
}
