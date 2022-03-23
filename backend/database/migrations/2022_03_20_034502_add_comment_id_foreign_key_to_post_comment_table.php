<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCommentIdForeignKeyToPostCommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('post_comment', function (Blueprint $table) {
            $table->foreign('comment_id')->references('id')->on('post_comment')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('post_comment', function (Blueprint $table) {
            $table->dropForeign(['comment_id']);
        });
    }
}
