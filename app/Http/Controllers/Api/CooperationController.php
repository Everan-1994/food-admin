<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CooperationReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CooperationController extends Controller
{

    public function store(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'title'        => 'required',
            'user_name'    => 'required',
            'user_tel'     => 'required',
            'user_email'   => 'required|email',
            'user_address' => 'required',
            'user_message' => 'required',
        ]);

        if ($validator->fails()) {
            return response([
                'code'    => 0,
                'message' => '留言信息不全',
                'error' => $validator->errors()
            ], 400);
        }

        $images_url = $request->input('images_url', '');

        if (empty($images_url)) {
            $images_url = json_encode([]);
        } else {
            if (is_array($images_url)) {
                $images_url = json_encode($images_url);
            } else {
                $images_url = json_encode(explode(',', $images_url));
            }
        }

        $data = [
            'title'        => $request->input('title'),
            'user_name'    => $request->input('user_name'),
            'user_tel'     => $request->input('user_tel'),
            'user_email'   => $request->input('user_email'),
            'user_address' => $request->input('user_address'),
            'user_message' => $request->input('user_message'),
            'images_url'   => $images_url,
        ];

        try {

            \DB::transaction(function () use ($data) {
                CooperationReview::query()->create($data);
            });

            return response([
                'code'    => 1,
                'message' => '提交成功',
            ], 201);

        } catch (\Exception $exception) {
            // Storage::delete($images_url); // 移除文件
            return response([
                'code'    => 0,
                'message' => '提交失败'
            ], 400);
        }
    }

    public function uploads(Request $request)
    {
        $images_url = []; // 图片地址

        if ($request->exists('images_url')) {
            foreach ($request->file('images_url') as $k => $file) {
                $images_url[] = Storage::disk('qiniu')->put('apply', $file);
            }
        }

        return response($images_url);
    }
}
