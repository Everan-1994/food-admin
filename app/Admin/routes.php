<?php

use Illuminate\Routing\Router;

Admin::registerAuthRoutes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
], function (Router $router) {

    $router->get('/', 'HomeController@index')->name('admin.home');

    // 轮播图
    $router->get('banners', 'BannerController@index');
    $router->get('banners/create', 'BannerController@create');
    $router->post('banners', 'BannerController@store');
    $router->get('banners/{id}/edit', 'BannerController@edit');
    $router->put('banners/{id}', 'BannerController@update');
    $router->delete('banners/{id}', 'BannerController@destroy');

    // 底部内容
    $router->get('culture/{id}/edit', 'CultureController@edit');
    $router->put('culture/{id}', 'CultureController@update');

});
