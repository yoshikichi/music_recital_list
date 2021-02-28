<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddindexMusictitlesTable1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('musictitles', function (Blueprint $table) {
            $table->unique(['title', 'composer'], 'uq_idx_musictitles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('musictitles', function (Blueprint $table) {
            //
        });
    }
}
