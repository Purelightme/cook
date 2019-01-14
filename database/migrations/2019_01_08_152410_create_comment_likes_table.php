<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 评论点赞
 * Class CreateCommentLikesTable
 */
class CreateCommentLikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comment_likes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('comment_id');
            $table->unsignedInteger('user_id');
            $table->timestamps();

            $table->foreign('comment_id')->references('id')->on('comments');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comment_likes');
    }
}
