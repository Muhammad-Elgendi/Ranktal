<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         *
         * Developed by :
         * 	Muhammad Elgendi
         *
         * -Capabilities   -Properties    -Return-type  Type (Conditional-output) -Column-name
         * 	-check existence   -hasTitle       -boolean field
         * 	-check duplication -duplicateTitle -boolean field
         * 	-check length(s)   -checkLength    -boolean field (var or array) -checkLengthTitle
         * 	-get length(s)     -length         -integer field (var or array) -lengthTitle
         * 	-get title(s)      -title          -string  field (var or array)
         * 	-make final check  -check          -boolean function             -checkTitle
         *
         **/
        Schema::create('audits', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('hasTitle');
            $table->boolean('duplicateTitle');
            $table->json('checkLengthTitle');
            $table->json('lengthTitle');
            $table->json('title');
            $table->boolean('checkTitle');
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
        Schema::dropIfExists('audits');
    }
}
