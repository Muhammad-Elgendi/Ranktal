<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLimitsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->string('plan')->default('Trial')->change();
            $table->string('image')->nullable();
            $table->string('company')->nullable();
            $table->json('limits')->nullable();
            $table->json('usage')->nullable();
            $table->unsignedTinyInteger('is_admin')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //            
            $table->string('plan')->default(null)->change();
            if (Schema::hasColumn('users', 'image'))
            {
                Schema::table('users', function (Blueprint $table)
                {
                    $table->dropColumn('image');
                });
            }

            if (Schema::hasColumn('users', 'company'))
            {
                Schema::table('users', function (Blueprint $table)
                {
                    $table->dropColumn('company');
                });
            }

            if (Schema::hasColumn('users', 'limits'))
            {
                Schema::table('users', function (Blueprint $table)
                {
                    $table->dropColumn('limits');
                });
            }

            if (Schema::hasColumn('users', 'usage'))
            {
                Schema::table('users', function (Blueprint $table)
                {
                    $table->dropColumn('usage');
                });
            }

            if (Schema::hasColumn('users', 'is_admin'))
            {
                Schema::table('users', function (Blueprint $table)
                {
                    $table->dropColumn('is_admin');
                });
            }

        });
    }
}
