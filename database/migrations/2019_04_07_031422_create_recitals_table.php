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
        Schema::dropIfExists('recitals');
    }
}
