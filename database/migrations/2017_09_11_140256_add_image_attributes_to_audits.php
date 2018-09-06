<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddImageAttributesToAudits extends Migration
{

    /**
     *
     * Developed by :
     * 	Muhammad Elgendi
     *
     * -Capabilities               -Return-type
     *
     * -alt                        -array
     * -emptyAlt                   -array
     * -altCount                   -integer
     * -imgCount                   -integer
     * -emptyAltCount              -integer
     * -hasImg                     -boolean
     * -hasAlt                     -boolean
     * -hasEmptyAlt                -boolean
     * -hasNoAltWithImg            -boolean
     * -hasGoodImg                 -boolean
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
            $table->json('alt')->nullable();
            $table->json('emptyAlt')->nullable();
            $table->integer('altCount');
            $table->integer('imgCount');
            $table->integer('emptyAltCount');
            $table->boolean('hasImg');
            $table->boolean('hasAlt');
            $table->boolean('hasEmptyAlt');
            $table->boolean('hasNoAltWithImg');
            $table->boolean('hasGoodImg');
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

            'alt',
            'emptyAlt',
            'altCount',
            'imgCount',
            'emptyAltCount',
            'hasImg',
            'hasAlt',
            'hasEmptyAlt',
            'hasNoAltWithImg',
            'hasGoodImg'

            ]);
        });
    }
}
