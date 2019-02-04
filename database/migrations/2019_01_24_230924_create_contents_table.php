<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->string('url',3000);
            $table->boolean('is_H1_exist');
            $table->boolean('is_canonical_exist');
            $table->string('url_query');
            $table->unsignedInteger("content_length");
            $table->text('content_hash');
            $table->primary('url');
            $table->foreign('url')
            ->references('url')->on('urls')
            ->onDelete('cascade');
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
        Schema::dropIfExists('contents');
    }
}
