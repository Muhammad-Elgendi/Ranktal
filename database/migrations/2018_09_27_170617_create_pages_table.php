<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('url',3000)->unique();
            $table->unsignedInteger('httpCode');
            $table->json('parsedUrl');
            $table->string('title')->nullable();
            $table->boolean('isMultiTitle');
            $table->string('description',500)->nullable();
            $table->boolean('isMultiDescription');
            $table->string('contentType')->nullable();
            $table->string('charset')->nullable();
            $table->string('viewport')->nullable();
            $table->string('robotsMeta')->nullable();
            $table->string('xRobots')->nullable();
            $table->string('refreshMeta')->nullable();
            $table->string('refreshHeader')->nullable();
            $table->string('canonical')->nullable();
            $table->float('ratio');
            $table->string('language')->nullable();
            $table->string('docType')->nullable();
            $table->json('h1')->nullable();
            $table->json('h2')->nullable();
            $table->json('h3')->nullable();
            $table->json('h4')->nullable();
            $table->json('h5')->nullable();
            $table->json('h6')->nullable();
            $table->json('alt')->nullable();
            $table->json('emptyAlt')->nullable();
            $table->string('ampLink')->nullable();
            $table->json('openGraph')->nullable();
            $table->json('twitterCard')->nullable();
            $table->unsignedInteger('framesCount');
            $table->json('bItems')->nullable();
            $table->json('iItems')->nullable();
            $table->json('emItems')->nullable();
            $table->json('strongItems')->nullable();
            $table->json('markItems')->nullable();
            $table->boolean('isFlashExist');
            $table->json('links')->nullable();
            $table->boolean('isAllowedFromRobots');
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
        Schema::dropIfExists('pages');
    }
}
