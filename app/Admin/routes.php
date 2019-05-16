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

    // 品牌合作
    $router->get('brand', 'BrandCooperationController@index');
    $router->get('brand/create', 'BrandCooperationController@create');
    $router->post('brand', 'BrandCooperationController@store');
    $router->get('brand/{id}/edit', 'BrandCooperationController@edit');
    $router->put('brand/{id}', 'BrandCooperationController@update');
    $router->delete('brand/{id}', 'BrandCooperationController@destroy');

    // 服务理念
    $router->get('servers/{id}/edit', 'ServersController@edit');
    $router->put('servers/{id}', 'ServersController@update');

    // 合作流程
    $router->get('cooperation/{id}/edit', 'CooperationController@edit');
    $router->put('cooperation/{id}', 'CooperationController@update');

});
