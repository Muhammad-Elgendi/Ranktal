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
            $table->unsignedInteger('http_code');
            $table->json('parsed_url');
            $table->string('title');
            $table->boolean('is_multi_title');
            $table->string('description',500);
            $table->boolean('is_multi_description');
            $table->string('content_type');
            $table->string('charset');
            $table->string('viewport');
            $table->string('robots_meta');
            $table->string('xrobots');
            $table->string('refresh_meta');
            $table->string('refresh_header');
            $table->string('canonical');
            $table->float('ratio');
            $table->string('language');
            $table->string('doc_type');
            $table->json('h1');
            $table->json('h2');
            $table->json('h3');
            $table->json('h4');
            $table->json('h5');
            $table->json('h6');
            $table->json('alt');
            $table->json('empty_alt');
            $table->string('amp_link');
            $table->json('open_graph');
            $table->json('twitter_card');
            $table->unsignedInteger('frames_count');
            $table->json('b_items');
            $table->json('i_items');
            $table->json('em_items');
            $table->json('strong_items');
            $table->json('mark_items');
            $table->json('url_redirects');
            $table->boolean('is_flash_exist');
            $table->json('links');
            $table->boolean('is_allowed_from_robots_txt');
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
