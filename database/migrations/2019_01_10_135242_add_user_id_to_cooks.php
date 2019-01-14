<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 菜谱表添加user_id记录上传者身份
 * Class AddUserIdToCooks
 */
class AddUserIdToCooks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cooks', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->nullable();

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
        Schema::table('cooks', function (Blueprint $table) {
            $table->dropColumn('user_id');

            $table->dropForeign('cooks_user_id_foreign');
        });
    }
}
