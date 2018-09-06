<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUrlAttributesToAudits extends Migration
{

    /**
     *
     * Developed by :
     * 	Muhammad Elgendi
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
     **/


    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('audits', function (Blueprint $table) {
            $table->string('url');
            $table->string('domain');
            $table->integer('domainLength');
            $table->integer('lengthUrl');
            $table->string('statusUrl');
            $table->string('googleCacheUrl');
            $table->integer('spacesUrl');
            $table->boolean('checkLengthUrl');
            $table->boolean('checkSpacesUrl');
            $table->boolean('checkStatusUrl');
            $table->boolean('checkUrl');
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
                'url',
                'domain',
                'domainLength',
                'lengthUrl',
                'statusUrl',
                'googleCacheUrl',
                'spacesUrl',
                'checkLengthUrl',
                'checkSpacesUrl',
                'checkStatusUrl',
                'checkUrl'
            ]);
        });
    }
}
