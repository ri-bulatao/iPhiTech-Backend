<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unsigned();
            $table->foreign('user_id')
            ->references('id')->on('users');
            $table->unsignedBigInteger('course_category_id')->unsigned();
            $table->foreign('course_category_id')
            ->references('id')->on('course_categories');
            $table->string('title');
            $table->longText('description')->nullable();
            $table->string('video_url')->nullable();
            $table->tinyInteger('is_embed')->default(1);
            $table->string('embed_code')->nullable();
            $table->string('featured_image')->nullable();
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
        Schema::dropIfExists('courses');
    }
}
