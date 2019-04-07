<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecitalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recitals', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->date('planeddate');
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
        Schema::dropIfExists('recitals');
    }
}
