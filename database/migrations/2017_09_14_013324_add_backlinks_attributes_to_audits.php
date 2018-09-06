<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBacklinksAttributesToAudits extends Migration
{

    /**
     *
     * Developed by :
     * 	Muhammad Elgendi
     *
     * -Capabilities                 -Return-type
     *
     * mozMetrics                     array
     * hasMozMetrics                  boolean
     * mozLinks                       array
     * hasMozLinks                    boolean
     * olpLinks                       array
     * hasOlpLinks                    boolean
     *
     * BackLinks constructor.
     * @param $url
     *
     */

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('audits', function (Blueprint $table) {
            $table->json('mozMetrics')->nullable();
            $table->json('mozLinks')->nullable();
            $table->json('olpLinks')->nullable();
            $table->boolean('hasMozMetrics');
            $table->boolean('hasMozLinks');
            $table->boolean('hasOlpLinks');
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
                'mozMetrics',
                'mozLinks',
                'olpLinks',
                'hasMozMetrics',
                'hasMozLinks',
                'hasOlpLinks'
            ]);
        });
    }
}
