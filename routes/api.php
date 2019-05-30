<?php

Route::group([
    'namespace'     => 'Api',
    'middleware' => ['cors'],
], function (\Illuminate\Routing\Router $router) {
    // 留言申请
    $router->post('uploads', 'CooperationController@uploads');
    $router->post('submit_cooperation', 'CooperationController@store');

    // banner
    $router->get('banner', 'EveranController@getBannerList');
    // 企业文化
    $router->get('company_culture', 'EveranController@getCompanyCulture');
    // 底部内如
    $router->get('footer', 'EveranController@getFooter');

    // 合作品牌
    $router->get('brand', 'EveranController@getBrandList');
    // 合作品牌详情
    $router->get('brand/{id}', 'EveranController@getBrandById');
    // 品牌服务理念
    $router->get('brand_server', 'EveranController@getBrandServer');
    // 品牌合作流程
    $router->get('brand_cooperation', 'EveranController@getBrandCooperation');

    // 商超合作
    $router->get('super', 'EveranController@getSuperList');
    // 商超合作详情
    $router->get('super/{id}', 'EveranController@getSuperById');
    // 商超服务理念
    $router->get('super_server', 'EveranController@getSuperServer');

    // 自由品牌
    $router->get('own_brand', 'EveranController@getOwnBrandList');
    $router->get('own_brand/{id}', 'EveranController@getOwnBrandById')->where(['id' => '[0-9]+']);
    // 品牌介绍 文案 + 图片&视频 轮播
    $router->get('own_brand/intro', 'EveranController@getOwnBrandIntro');
    // 招商代理
    $router->get('merchants_proxy', 'EveranController@getMerchantsProxy');

    // 新闻列表
    $router->get('news_list', 'EveranController@getNewsList');
    $router->get('news_list/{id}', 'EveranController@getNewsById');

    // 门店列表
    $router->get('contact_us', 'EveranController@getContactUsList');

    // 关于我们 & 常见问题
    $router->get('us_problem', 'EveranController@getAboutUsAndCommonProblem');
});
