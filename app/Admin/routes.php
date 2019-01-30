<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index');

    //留言管理
    $router->resource('suggest','Suggest\SuggestAdminController');

    //用户管理
    $router->resource('user','User\UserAdminController');

    //分类管理
    $router->resource('category','Category\CategoryAdminController');

    //Banner
    $router->resource('banner','Banner\BannerAdminController');

    //故事
    $router->resource('story','Story\StoryAdminController');
});
