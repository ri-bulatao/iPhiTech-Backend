<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_courses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unsigned();
            $table->foreign('user_id')
            ->references('id')->on('users');
            $table->unsignedBigInteger('course_id')->unsigned();
            $table->foreign('course_id')
            ->references('id')->on('courses');
            $table->string('status')->default('Ready'); // Ready, Inprogress, Completed
            $table->string('grade_status')->nullable(); // Passed or Failed
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
        Schema::dropIfExists('user_courses');
    }
}
