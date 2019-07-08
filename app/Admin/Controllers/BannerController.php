<?php

namespace App\Admin\Controllers;

use App\Models\Banner;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    use HasResourceActions, ScriptTrait;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('轮播图')
            ->body($this->grid());
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        Admin::script($this->addTips('img_url', '1920', '636'));
        Admin::script($this->removeCancelButton());

        return $content
            ->header('轮播图编辑')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        Admin::script($this->addTips('img_url', '1920', '636'));
        Admin::script($this->removeCancelButton());

        return $content
            ->header('新建轮播图')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Banner);

        // $grid->id('#')->sortable();
        $grid->sort('排序')->editable()->sortable();
        $grid->img_url('图片')->image();
        $grid->jump_url('外部链接');
        $grid->is_show('是否显示')->editable('select', [1 => '显示', 0 => '隐藏']);

        $grid->actions(function ($actions) {
            $actions->disableView(); // 禁用查看
        });

        $grid->tools(function ($tools) {
            // 禁用批量删除按钮
            $tools->batch(function ($batch) {
                $batch->disableDelete();
            });
        });

        // 禁用查询过滤器
        $grid->disableFilter();

        return $grid;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Banner);

        // 创建一个选择图片的框
        $form->image('img_url', '图片')->rules('required|image');
        // 创建一个输入框，第一个参数 title 是模型的字段名，第二个参数是该字段描述
        $form->url('jump_url', '外部链接')->placeholder('https://www.baidu.com')->rules('required|url');
        $form->radio('is_show', '显示&隐藏')->options([1 => '显示', 0 => '隐藏'])->default(1);
        $form->text('sort', '排序')->default(0);

        $form->tools(function (Form\Tools $tools) {
            // 去掉`查看`按钮
            $tools->disableView();
        });

        return $form;
    }

    /**
     * wangEditor 图片上传
     * @param Request $request
     * @return string
     */
    public function uploads(Request $request)
    {
        $files = $request->file("images");
        $res = ['errno' => 1, 'errmsg' => '上传图片错误'];
        $data = [];
        foreach ($files as $key => $file) {
            $ext = strtolower($file->extension());
            $exts = ['jpg', 'png', 'gif', 'jpeg'];
            if (!in_array($ext, $exts)) {
                $res = ['errno' => 1, 'errmsg' => '请上传正确的图片类型，支持jpg, png, gif, jpeg类型'];
                return json_encode($res);
            }
        }

        foreach ($files as $k => $_file) {
            $data[] = 'http://' . env('QINIU_DOMAIN') . '/' . Storage::disk('qiniu')->put('apply', $_file);
        }

        $res = ['errno' => 0, 'data' => $data];
        return json_encode($res);
    }
}
