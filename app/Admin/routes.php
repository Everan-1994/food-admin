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

    // 商超合作
    $router->get('super', 'SuperStoreController@index');
    $router->get('super/create', 'SuperStoreController@create');
    $router->post('super', 'SuperStoreController@store');
    $router->get('super/{id}/edit', 'SuperStoreController@edit');
    $router->put('super/{id}', 'SuperStoreController@update');
    $router->delete('super/{id}', 'SuperStoreController@destroy');

    // 商超服务
    $router->get('super_server/{id}/edit', 'SuperServerController@edit');
    $router->put('super_server/{id}', 'SuperServerController@update');

    // 自有品牌
    $router->get('own_brand', 'OwnBrandController@index');
    $router->get('own_brand/create', 'OwnBrandController@create');
    $router->post('own_brand', 'OwnBrandController@store');
    $router->get('own_brand/{id}/edit', 'OwnBrandController@edit');
    $router->put('own_brand/{id}', 'OwnBrandController@update');
    $router->delete('own_brand/{id}', 'OwnBrandController@destroy');

    // 品牌介绍
    $router->get('brand_intro/{id}/edit', 'BrandIntroController@edit');
    $router->put('brand_intro/{id}', 'BrandIntroController@update');

    // 招商代理
    $router->get('merchants_proxy/{id}/edit', 'MerchantsProxyController@edit');
    $router->put('merchants_proxy/{id}', 'MerchantsProxyController@update');

    // 新闻
    $router->get('news', 'NewsController@index');
    $router->get('news/create', 'NewsController@create');
    $router->post('news', 'NewsController@store');
    $router->get('news/{id}/edit', 'NewsController@edit');
    $router->put('news/{id}', 'NewsController@update');
    $router->delete('news/{id}', 'NewsController@destroy');

    // 新闻
    $router->get('contact_us', 'ContactUsController@index');
    $router->get('contact_us/create', 'ContactUsController@create');
    $router->post('contact_us', 'ContactUsController@store');
    $router->get('contact_us/{id}/edit', 'ContactUsController@edit');
    $router->put('contact_us/{id}', 'ContactUsController@update');
    $router->delete('contact_us/{id}', 'ContactUsController@destroy');

    // 合作申请
    $router->get('cooperation_review', 'CooperationReviewController@index');
    $router->get('cooperation_review/{id}', 'CooperationReviewController@show');
    $router->delete('cooperation_review/{id}', 'CooperationReviewController@destroy');
});
