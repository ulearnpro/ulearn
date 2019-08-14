<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseProgress extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_progress', function (Blueprint $table) {
            $table->increments('progress_id');
            $table->integer('user_id');
            $table->integer('course_id');
            $table->integer('lecture_id');
            $table->tinyInteger('status')->default(0)->comment('0-incomplete,1-complete');
            $table->dateTime('created_at');
            $table->dateTime('modified_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('course_progress');
    }
}
