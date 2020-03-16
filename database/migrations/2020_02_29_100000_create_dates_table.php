<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dates', function (Blueprint $table) {
          $table->bigIncrements('id');
          $table->string('name');
          $table->string('date');
          $table->string('day');
          $table->string('month');
          $table->string('year');
          $table->integer('creatoruserid');
          $table->string('yeargang');
          $table->integer('lessonid')->nullable();
          $table->integer('datecalc');
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
        Schema::dropIfExists('dates');
    }
}
