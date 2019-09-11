<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUrlsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('urls', function (Blueprint $table) {
            $table->string('url',3000);
            $table->unsignedInteger('status');
            $table->unsignedInteger('site_id');
            $table->foreign('site_id')
            ->references('id')->on('sites')
            ->onDelete('cascade');
            $table->unsignedInteger('crawl_depth')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->primary('url');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('urls');
    }
}
