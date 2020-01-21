<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOptimizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('optimizations', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('campaign_id')->nullable();
            $table->foreign('campaign_id')
            ->references('id')->on('campaigns')
            ->onDelete('cascade');
            $table->string('url');
            $table->string('keyword');
            $table->json('report')->nullable();
            $table->unsignedInteger('score')->nullable();
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
        Schema::dropIfExists('optimizations');
    }
}
