<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecitalProgramsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recital_programs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('recital_id');
            $table->integer('teacher_id');
            $table->integer('player_id');
            $table->string('age');
            $table->string('school_year');
            $table->integer('music1_id');
            $table->integer('music2_id');
            $table->integer('music3_id');
            $table->integer('music4_id');
            $table->integer('music5_id');
            $table->string('chair_hight');
            $table->string('foot_hight');
            $table->string('pedal_hight');
            $table->string('stand_hight');
            $table->string('subplayer_chair');
            $table->string('paging_chair');
            $table->string('remark');
            $table->string('comment');            
            $table->integer('enabled');
            $table->integer('looked');
            $table->string('comment1');
            $table->string('comment2');
            $table->string('comment3');
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
        Schema::dropIfExists('recital_programs');
    }
}
