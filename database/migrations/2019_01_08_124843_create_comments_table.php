<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 菜谱评价
 * Class CreateCommentsTable
 */
class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('cook_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('star')->comment('推荐指数')->default(0);
            $table->json('imgs')->comment('成品图')->nullable();
            $table->string('content')->comment('评价内容');
            $table->timestamps();

            $table->foreign('cook_id')->reference('id')->on('cooks');
            $table->foreign('user_id')->reference('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
