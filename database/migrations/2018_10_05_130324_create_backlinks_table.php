<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBacklinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('backlinks', function (Blueprint $table) {
            $table->string('source_url',2083);
            $table->string('target_url',2083);
            $table->string('anchor_text',2500)->nullable();            
            $table->boolean('is_dofollow')->nullable();
            $table->primary(['source_url', 'target_url','anchor_text','is_dofollow']);
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
        Schema::dropIfExists('backlinks');
    }
}
