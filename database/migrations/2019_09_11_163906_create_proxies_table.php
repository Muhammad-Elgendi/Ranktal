<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProxiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proxies', function (Blueprint $table) {
            $table->string('proxy');
            $table->string('country')->nullable();
            $table->string('type')->nullable();
            $table->string('anonymity')->nullable();
            $table->integer('speed')->nullable();
            $table->boolean('is_working')->nullable();    
            $table->boolean('google_pass')->nullable();
            $table->boolean('bing_pass')->nullable();
            $table->timestamp('last_use')->nullable();
            $table->timestamps();
            $table->primary('proxy');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proxies');
    }
}
