<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NewsResource;
use App\Models\AboutUs;
use App\Models\Banner;
use App\Models\BrandCooperation;
use App\Models\BrandIntro;
use App\Models\CommonProblem;
use App\Models\CompanyCulture;
use App\Models\ContactUs;
use App\Models\Cooperation;
use App\Models\Culture;
use App\Models\MerchantsProxy;
use App\Models\News;
use App\Models\OwnBrand;
use App\Models\PictureVideo;
use App\Models\Server;
use App\Models\SuperServer;
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
        $banners = $banner::query()->select(['id', 'img_url', 'jump_url'])
            ->where('is_show', 1)
            ->orderBy('sort', 'desc')
            ->get();

        return response($banners);
    }

    /**
     * 企业文化
     * @param CompanyCulture $companyCulture
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function getCompanyCulture(CompanyCulture $companyCulture)
    {
        $company_culture = $companyCulture::query()->select(['id', 'name', 'en_name', 'image_url', 'content'])->find(1);

        return response($company_culture);
    }

    public function getFooter(Culture $culture)
    {
        $_culture = $culture::query()->select(['id', 'logo', 'name', 'tel', 'address', 'wx_qrcode', 'kf_qrcode'])->find(1);

        return response($_culture);
    }

    /**
     * 获取品牌合作列表
     * @param Request $request
     * @param BrandCooperation $brandCooperation
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function getBrandList(Request $request, BrandCooperation $brandCooperation)
    {
        $brand = $brandCooperation::query()->select(['id', 'name', 'logo', 'logo_hover'])
            ->when($request->exists('key_word'), function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->input('key_word') . '%');
            })
            ->where('is_show', 1)
            ->orderBy('sort', 'desc')
            ->paginate($request->input('pageSize', 9));

        return response($brand);
    }

    public function getBrandById($id, BrandCooperation $brandCooperation)
    {
        $brand = $brandCooperation::query()->select(['id', 'name', 'content', 'video'])->find($id);

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
     * @param Request $request
     * @param SuperStore $superStore
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function getSuperList(Request $request, SuperStore $superStore)
    {
        $super = $superStore::query()->select(['id', 'name', 'logo', 'intro'])
            ->when($request->exists('key_word'), function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->input('key_word') . '%');
            })
            ->where('is_show', 1)
            ->orderBy('sort', 'desc')
            ->get();

        if ($request->input('chunk', false)) {
            return response(array_chunk($super->toArray(), 4));
        }

        return response($super);
    }

    public function getSuperById($id, SuperStore $superStore)
    {
        $super = $superStore::query()->select(['id', 'name', 'logo', 'images_url', 'intro', 'content'])->find($id);

        return response($super);
    }

    /**
     * 获取商超服务理念
     * @param SuperServer $superServer
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function getSuperServer(SuperServer $superServer)
    {
        $super = $superServer::query()->select(['id', 'content', 'images_url'])->find(1);

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
            ->when($request->exists('key_word'), function ($query) use ($request) {
                $query->where('goods_name', 'like', '%' . $request->input('key_word') . '%');
            })
            ->where('is_show', 1)
            ->orderBy('sort', 'desc')
            ->paginate($request->input('pageSize', 6), ['*'], 'page', $request->input('page', 1));

        return response($list);
    }

    public function getOwnBrandById($id, OwnBrand $ownBrand)
    {
        $brand = $ownBrand::query()
            ->select(['id', 'goods_name', 'goods_img', 'images_url', 'detail_img', 'goods_intro', 'goods_content'])
            ->find($id);

        return response($brand);
    }

    /**
     * 自有品牌介绍 视频&图片 轮播
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
            ->select(['id', 'type', 'title', 'image', 'video', 'detail_image', 'intro', 'resource_type', 'from', 'created_at'])
            ->when('', function ($query) use ($request) {
                $query->where('type', $request->input('type', 0));
            })
            ->when($request->exists('keyword'), function ($query) use ($request) {
                $query->where('title', 'like', '%'. $request->input('keyword') .'%');
            })
            ->where('is_show', 1)
            ->orderBy('sort', 'asc')
            ->paginate($request->input('pageSize', 10), ['*'], 'page', $request->input('page', 1));

        return response(NewsResource::collection($list));
    }

    public function getNewsById($id, News $news)
    {
        $news_detail = $news::query()
            ->select(['id', 'type', 'title', 'image', 'video', 'detail_image', 'intro', 'resource_type', 'from', 'content', 'created_at'])
            ->where('is_show', 1)
            ->find($id);

        return response(new NewsResource($news_detail));
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
            ->select(['name', 'tel', 'contact', 'address', 'latitude', 'longitude'])
            ->when($request->exists('name'), function ($query) use ($request) {
                $query->where('name', 'like', '%'. $request->input('name') .'%');
            })
            ->where('is_show', 1)
            ->orderBy('sort', 'desc')
            ->get();

        return response($list);
    }

    public function getAboutUsAndCommonProblem(Request $request, AboutUs $aboutUs, CommonProblem $commonProblem)
    {
        // 关于我们
        $about_us = $aboutUs::query()
            ->select(['title', 'content', 'image', 'video', 'resource_type'])
            ->get();

        // 常见问题
        $common_problem = $commonProblem::query()
            ->select(['question', 'answer'])
            ->where('is_show', 1)
            ->orderBy('sort', 'asc')
            ->paginate($request->input('pageSize', 10), ['*'], 'page', $request->input('page', 1));

        return response([
            'about_us' => $about_us,
            'common_problem' => $common_problem
        ]);
    }
}
