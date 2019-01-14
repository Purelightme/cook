<?php

Route::group(['middleware' => 'web', 'prefix' => 'user', 'namespace' => 'Modules\User\Http\Controllers'], function()
{
    Route::get('/', 'UserController@index');

    Route::prefix('auth')->group(function (){
        Route::post('login','AuthController@login');
    });

    //留言
    Route::resource('suggests','SuggestController');

    //评论
    Route::resource('comments','CommentController');

    //收藏
    Route::resource('cook-collects','CookCollectController')->only(['index','store']);
    Route::delete('cook-collects','CookCollectController@destroy');

    //菜谱
    Route::resource('cooks','CookController');
});
