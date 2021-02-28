<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecitalProgramMusicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recital_program_musics', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('recital_id');
            $table->integer('player_id');
            $table->integer('musictitle_id');
            $table->integer('rank')->default(0)->nullable();
            $table->integer('admin_user_id');
            $table->integer('age')->default(0)->nullable();
            $table->string('school_year')->default('')->nullable();
            $table->string('chair_hight')->default('')->nullable();
            $table->string('foot_hight')->default('')->nullable();
            $table->string('pedal_hight')->default('')->nullable();
            $table->string('stand_hight')->default('')->nullable();
            $table->string('subplayer_chair')->default('')->nullable();
            $table->string('paging_chair')->default('')->nullable();
            $table->string('remark')->default('')->nullable();
            $table->string('comment')->default('')->nullable();            
            $table->integer('enabled')->default(0)->nullable();
            $table->integer('looked')->default(0)->nullable();
            $table->string('comment1')->default('')->nullable();
            $table->string('comment2')->default('')->nullable();
            $table->string('comment3')->default('')->nullable();

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
        Schema::dropIfExists('recital_program_musics');
    }
}
