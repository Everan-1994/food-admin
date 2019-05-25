<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use App\Models\Banner;
use App\Models\BrandCooperation;
use App\Models\BrandIntro;
use App\Models\CommonProblem;
use App\Models\ContactUs;
use App\Models\Cooperation;
use App\Models\MerchantsProxy;
use App\Models\News;
use App\Models\OwnBrand;
use App\Models\PictureVideo;
use App\Models\Server;
use App\Models\SuperStore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EveranController extends Controller
{
    /**
     * 获取 banner 列表
     * @param Banner $banner
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function getBannerList(Banner $banner)
    {
        $banner = $banner::query()->select(['id', 'img_url', 'jump_url'])->get();

        return response($banner);
    }

    /**
     * 获取品牌合作列表
     * @param Request $request
     * @param BrandCooperation $brandCooperation
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function getBrandList(Request $request, BrandCooperation $brandCooperation)
    {
        $brand = $brandCooperation::query()->select(['id', 'name', 'logo', 'logo_hover'])->paginate($request->input('pageSize', 9));

        return response($brand);
    }

    public function getBrandById($id, BrandCooperation $brandCooperation)
    {
        $brand = $brandCooperation::query()->select(['id', 'name', 'content'])->find($id);

        return response($brand);
    }

    /**
     * 获取品牌服务理念
     * @param Server $server
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function getBrandServer(Server $server)
    {
        $servers = $server::query()->select(['id', 'content', 'images_url'])->find(1);

        return response($servers);
    }

    public function getBrandCooperation(Cooperation $cooperation)
    {
        $brand_cooperation = $cooperation::query()->select(['id', 'content', 'image_url'])->find(1);

        return response($brand_cooperation);
    }

    /**
     * 商超合作列表
     * @param SuperStore $superStore
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function getSuperList(SuperStore $superStore)
    {
        $super = $superStore::query()->select(['id', 'name', 'logo', 'content'])->get();

        return response($super);
    }

    public function getSuperById($id, SuperStore $superStore)
    {
        $super = $superStore::query()->select(['id', 'name', 'logo', 'content'])->find($id);

        return response($super);
    }

    /**
     * 获取品牌服务理念
     * @param SuperStore $superStore
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function getSuperServer(SuperStore $superStore)
    {
        $super = $superStore::query()->select(['id', 'content', 'images_url'])->find(1);

        return response($super);
    }

    /**
     * 自有品牌
     * @param Request $request
     * @param OwnBrand $ownBrand
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function getOwnBrandList(Request $request, OwnBrand $ownBrand)
    {
        $list = $ownBrand::query()
            ->select(['id', 'goods_name', 'goods_img', 'goods_intro'])
            ->paginate($request->input('pageSize', 6), ['*'], 'page', $request->input('page', 1));

        return response($list);
    }

    public function getOwnBrandById($id, OwnBrand $ownBrand)
    {
        $brand = $ownBrand::query()
            ->select(['id', 'goods_name', 'goods_img', 'goods_intro'])
            ->find($id);

        return response($brand);
    }

    /**
     * 自由品牌介绍 视频&图片 轮播
     * @param BrandIntro $brandIntro
     * @param PictureVideo $pictureVideo
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function getOwnBrandIntro(BrandIntro $brandIntro, PictureVideo $pictureVideo)
    {
        $brand_intro = $brandIntro::query()
            ->select(['title', 'intro', 'feature', 'idea'])
            ->get();

        $picture_video = $pictureVideo::query()
            ->select(['brand_image', 'brand_video'])
            ->find(1);

        $picture_videos = [];
        if (!empty($picture_video)) {
            $iamges = [];
            foreach ($picture_video['brand_image'] as $image) {
                $iamges[] = [
                    'type' => 1,
                    'url' => $image
                ];
            }

            $videos = [];
            foreach ($picture_video['brand_video'] as $video) {
                $videos[] = [
                    'type' => 2,
                    'url' => $video
                ];
            }
            $picture_videos = array_merge($iamges, $videos);
        }

        return response([
            'brand_intro' => $brand_intro,
            'picture_video' => $picture_videos
        ]);
    }

    public function getMerchantsProxy(MerchantsProxy $merchantsProxy)
    {
        $merchants_proxy = $merchantsProxy::query()
            ->select(['name', 'contact', 'tel', 'address', 'business_license', 'range'])
            ->find(1);

        return response($merchants_proxy);
    }

    /**
     * 获取新闻列表
     * @param Request $request
     * @param News $news
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function getNewsList(Request $request, News $news)
    {
        $list = $news::query()
            ->select(['id', 'type', 'title', 'image', 'content',])
            ->where('type', $request->input('type', 0))
            ->get();

        return response($list);
    }

    public function getNewsById($id, News $news)
    {
        $news_detail = $news::query()
            ->select(['id', 'type', 'title', 'image', 'content',])
            ->find($id);

        return response($news_detail);
    }

    /**
     * 门店列表
     * @param Request $request
     * @param ContactUs $contactUs
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function getContactUsList(Request $request, ContactUs $contactUs)
    {
        $list = $contactUs::query()
            ->select(['name', 'tel', 'contact', 'address', 'latitude_longitude'])
            ->when($request->exists('name'), function ($query) use ($request) {
                $query->where('name', 'like', '%'. $request->input('name') .'%');
            })
            ->get();

        return response($list);
    }

    public function getAboutUsAndCommonProblem(AboutUs $aboutUs, CommonProblem $commonProblem)
    {
        // 关于我们
        $about_us = $aboutUs::query()
            ->select(['title', 'content'])
            ->get();

        // 常见问题
        $common_problem = $commonProblem::query()
            ->select(['question', 'answer'])
            ->get();

        return response([
            'about_us' => $about_us,
            'common_problem' => $common_problem
        ]);
    }
}