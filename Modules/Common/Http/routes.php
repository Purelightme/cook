<?php

Route::group(['middleware' => 'web', 'prefix' => 'common', 'namespace' => 'Modules\Common\Http\Controllers'], function()
{
    Route::get('/', 'CommonController@index');

    //分类
    Route::prefix('category')->group(function (){
        Route::get('tree','CategoryController@tree');
    });

    //菜谱列表
    Route::get('categories/{category_id}/cooks','CookController@categoryCooks');
    //菜谱详情
    Route::get('cooks/{id}','CookController@detail');
    //菜谱搜索
    Route::get('cook/search','CookController@search');
});
