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

    // 企业文化
    $router->get('company_culture/{id}/edit', 'CompanyCultureController@edit');
    $router->put('company_culture/{id}', 'CompanyCultureController@update');

    // 底部内容
    $router->get('culture/{id}/edit', 'CultureController@edit');
    $router->put('culture/{id}', 'CultureController@update');

    // 品牌合作
    $router->get('brand', 'BrandCooperationController@index');
    $router->get('brand/create', 'BrandCooperationController@create');
    $router->post('brand', 'BrandCooperationController@store');
    $router->get('brand/{id}/edit', 'BrandCooperationController@edit');
    $router->put('brand/{id}', 'BrandCooperationController@update');
    $router->get('brand/{id}', 'BrandCooperationController@show');
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
    $router->get('super/{id}', 'SuperStoreController@show');
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
    $router->get('own_brand/{id}', 'OwnBrandController@show');
    $router->delete('own_brand/{id}', 'OwnBrandController@destroy');

    // 品牌介绍 文本轮播
    $router->get('brand_intro', 'BrandIntroController@index');
    $router->get('brand_intro/create', 'BrandIntroController@create');
    $router->post('brand_intro', 'BrandIntroController@store');
    $router->get('brand_intro/{id}/edit', 'BrandIntroController@edit');
    $router->put('brand_intro/{id}', 'BrandIntroController@update');

    // 品牌介绍 视频&图片 轮播
    $router->get('brand_intro_pv/{id}/edit', 'PictureVideoController@edit');
    $router->put('brand_intro_pv/{id}', 'PictureVideoController@update');

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

    // 联系我们
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

    // 关于我们
    $router->get('about_us', 'AboutUsController@index');
    $router->get('about_us/{id}/edit', 'AboutUsController@edit');
    $router->put('about_us/{id}', 'AboutUsController@update');

    // 常见问题
    $router->get('common_problem', 'CommonProblemController@index');
    $router->get('common_problem/create', 'CommonProblemController@create');
    $router->post('common_problem', 'CommonProblemController@store');
    $router->get('common_problem/{id}/edit', 'CommonProblemController@edit');
    $router->put('common_problem/{id}', 'CommonProblemController@update');
    $router->delete('common_problem/{id}', 'CommonProblemController@destroy');

    // wangEditor 上传图片
    $router->post('uploads', 'BannerController@uploads');
});


