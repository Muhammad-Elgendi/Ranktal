<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHeadingAttributesToAudits extends Migration
{
    /**
     *
     * Developed by :
     * 	Muhammad Elgendi
     *
     * -Capabilities               -Return-type   Type      -Column-name
     *
     * -h1                         -array
     * -h2                         -array
     * -h3                         -array
     * -h4                         -array
     * -h5                         -array
     * -h6                         -array
     * -hasH1                      -boolean
     * -hasH2                      -boolean
     * -hasH3                      -boolean
     * -hasH4                      -boolean
     * -hasH5                      -boolean
     * -hasH6                      -boolean
     * -countH1                    -integer
     * -countH2                    -integer
     * -countH3                    -integer
     * -countH4                    -integer
     * -countH5                    -integer
     * -countH6                    -integer
     * -hasManyH1                  -boolean
     * -hasGoodHeadings            -boolean
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
            $table->json('h1')->nullable();
            $table->json('h2')->nullable();
            $table->json('h3')->nullable();
            $table->json('h4')->nullable();
            $table->json('h5')->nullable();
            $table->json('h6')->nullable();
            $table->boolean('hasH1');
            $table->boolean('hasH2');
            $table->boolean('hasH3');
            $table->boolean('hasH4');
            $table->boolean('hasH5');
            $table->boolean('hasH6');
            $table->boolean('hasManyH1');
            $table->boolean('hasGoodHeadings');
            $table->integer('countH1');
            $table->integer('countH2');
            $table->integer('countH3');
            $table->integer('countH4');
            $table->integer('countH5');
            $table->integer('countH6');
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
                'h1',
                'h2',
                'h3',
                'h4',
                'h5',
                'h6',
                'hasH1',
                'hasH2',
                'hasH3',
                'hasH4',
                'hasH5',
                'hasH6',
                'hasManyH1',
                'hasGoodHeadings',
                'countH1',
                'countH2',
                'countH3',
                'countH4',
                'countH5',
                'countH6'
            ]);
        });
    }
}
