<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePageInsightsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('page_insights', function (Blueprint $table) {
            $table->increments('id');
            $table->string('url',3000);
            $table->string('type');
            $table->json('pageInsight')->nullable();
            $table->longText('screenShotSrc')->nullable();
            $table->unsignedInteger('screenShotWidth')->nullable();
            $table->unsignedInteger('screenShotHeight')->nullable();
            $table->json('optimizableResources')->nullable();
            $table->json('impactsList')->nullable();
            $table->json('problemsList')->nullable();
            $table->timestamps();
            $table->unique(['url', 'type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('page_insights');
    }
}
