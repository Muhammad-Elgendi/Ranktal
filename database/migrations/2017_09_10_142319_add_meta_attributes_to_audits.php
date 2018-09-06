<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMetaAttributesToAudits extends Migration
{
    /**
     *
     * Developed by :
     * 	Muhammad Elgendi
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
     **/

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('audits', function (Blueprint $table) {
            $table->boolean('hasDescription');
            $table->boolean('hasKeywords');
            $table->boolean('hasNews_keywords');
            $table->boolean('hasRobots');
            $table->boolean('hasViewport');
            $table->boolean('duplicateDescription');
            $table->boolean('duplicateKeywords');
            $table->boolean('duplicateNews_keywords');
            $table->boolean('checkLengthDescription');
            $table->boolean('checkDescription');
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
            $table->json('metas');
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
                'hasDescription',
                'hasKeywords',
                'hasNews_keywords',
                'hasRobots',
                'hasViewport',
                'duplicateDescription',
                'duplicateKeywords',
                'duplicateNews_keywords',
                'checkLengthDescription',
                'checkDescription',
                'descriptionMata',
                'keywordsMeta',
                'news_keywordsMeta',
                'robotsMeta',
                'viewportMeta',
                'lengthDescription',
                'lengthKeywords',
                'lengthNews_keywords',
                'descriptionCount',
                'keywordsCount',
                'news_keywordsCount',
                'metas'
            ]);
        });
    }
}
