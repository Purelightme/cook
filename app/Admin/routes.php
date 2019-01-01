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
});
