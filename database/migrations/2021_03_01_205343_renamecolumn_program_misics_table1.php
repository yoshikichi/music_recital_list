<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameColumnProgramMusicsTable1 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('recital_program_musics', function (Blueprint $table) {
            $table->renameColumn('comment', 'comment0');//<-記述
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('recital_program_musics', function (Blueprint $table) {
            $table->renameColumn('comment0', 'comment');//<-記述
        });
    }
}
