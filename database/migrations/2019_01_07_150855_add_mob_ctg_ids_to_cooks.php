<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 菜谱表添加mob分类ids
 * Class AddMobCtgIdsToCooks
 */
class AddMobCtgIdsToCooks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cooks', function (Blueprint $table) {
            $table->string('mob_ctg_ids')->comment('mob分类ids')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cooks', function (Blueprint $table) {
            $table->dropColumn('mob_ctg_ids');
        });
    }
}
