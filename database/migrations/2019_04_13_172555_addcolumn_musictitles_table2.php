<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddcolumnMusictitlesTable2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('musictitles', function (Blueprint $table) {
            //
            $table->string('title_furikana')->after('title')->nullable();
            $table->string('composer_furikana')->after('composer')->nullable();
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
