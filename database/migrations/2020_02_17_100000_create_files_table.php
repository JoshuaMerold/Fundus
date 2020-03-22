<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
          $table->string('id');
          $table->bigIncrements('counter');
          $table->string('name');
          $table->string('extension');
          $table->string('path');
          $table->string('type');
          $table->string('lessonid');
          $table->integer('creatoruserid');
          $table->integer('courseid');
          $table->integer('voting');
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
        Schema::dropIfExists('files');
    }
}
