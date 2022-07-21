<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCourseCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unsigned();
            $table->foreign('user_id')
            ->references('id')->on('users');
            $table->unsignedBigInteger('course_id')->unsigned();
            $table->foreign('course_id')
            ->references('id')->on('courses');
            $table->longText("comment");
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
        Schema::dropIfExists('course_comments');
    }
}
