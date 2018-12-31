<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 菜谱
 * Class CreateCooksTable
 */
class CreateCooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cooks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('category_ids');
            $table->string('category_titles');
            $table->string('menu_id');
            $table->string('title');
            $table->string('img')->nullable()->comment('主图');
            $table->string('thumbnail')->nullable()->comment('缩略图');
            $table->string('introduction')->comment('介绍');
            $table->string('ingredients')->comment('原料');
            $table->string('method')->comment('做法');
            $table->tinyInteger('source')->comment('来源');
            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cooks');
    }
}
