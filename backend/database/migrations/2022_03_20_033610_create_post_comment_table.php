<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostCommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_comment', function (Blueprint $table) {
            $table->bigIncrements('id');        
            $table->unsignedBigInteger('post_id');
            $table->unsignedBigInteger('comment_id')->nullable();
            $table->string('username');
            $table->string('comment');
            $table->timestamps();

            $table->foreign('post_id')->references('id')->on('post')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_comment');
    }
}
