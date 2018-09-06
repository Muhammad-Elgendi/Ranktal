<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPageAttributesToAudits extends Migration
{

    /**
     *
     * Developed by :
     * 	Muhammad Elgendi
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
     **/

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('audits', function (Blueprint $table) {
            $table->float('loadTime');
            $table->float('ratio');
            $table->boolean('checkTextHtmlRatio');
            $table->boolean('hasCanonical');
            $table->boolean('hasLanguage');
            $table->boolean('hasDocType');
            $table->boolean('hasEncoding');
            $table->boolean('hasCountry');
            $table->boolean('hasCity');
            $table->boolean('hasIpAddress');
            $table->string('canonical')->nullable();
            $table->string('language')->nullable();
            $table->string('docType')->nullable();
            $table->string('encoding')->nullable();
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('IpAddress')->nullable();
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
                'loadTime',
                'ratio',
                'checkTextHtmlRatio',
                'hasCanonical',
                'hasLanguage',
                'hasDocType',
                'hasEncoding',
                'hasCountry',
                'hasCity',
                'hasIpAddress',
                'canonical',
                'language',
                'docType',
                'encoding',
                'country',
                'city',
                'IpAddress'
            ]);
        });
    }
}
