<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCrawlingJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crawling_jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('site_id')->unique();
            $table->foreign('site_id')
            ->references('id')->on('sites')
            ->onDelete('cascade');
            $table->string('status');
            $table->string('node')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('crawling_jobs');
    }
}
