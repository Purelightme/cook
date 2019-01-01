<?php

Route::group(['middleware' => 'web', 'prefix' => 'user', 'namespace' => 'Modules\User\Http\Controllers'], function()
{
    Route::get('/', 'UserController@index');

    Route::prefix('auth')->group(function (){
        Route::post('login','AuthController@login');
    });

    //留言
    Route::resource('suggests','SuggestController');

});
