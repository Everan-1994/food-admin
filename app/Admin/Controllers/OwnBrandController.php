<?php

namespace App\Admin\Controllers;

use App\Models\OwnBrand;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class OwnBrandController extends Controller
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
            ->header('产品列表')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('产品详情')
            ->body($this->detail($id));
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
        Admin::script($this->removeCancelButton());
        Admin::script($this->addTips('goods_img', '189', '235'));
        Admin::script($this->addTextTips('images_url', '最多上传5张图片'));

        return $content
            ->header('产品编辑')
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
        Admin::script($this->removeCancelButton());
        Admin::script($this->addTips('goods_img', '189', '235'));
        Admin::script($this->addTextTips('images_url', '最多上传5张图片'));

        return $content
            ->header('产品新增')
            ->body($this->form());
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(OwnBrand::findOrFail($id));

        $show->goods_name('产品名称');
        $show->goods_type('产品种类');
        $show->goods_img('产品图片')->unescape()->as(function ($goods_img) {
            $url = env('QINIU_DOMAIN');
            $imgs = "<img class='img-rounded' style='max-width: 30%; height: 150px; 
                            border: 1px solid #f0f0f0;
                            margin: 5px;' src='http://{$url}/{$goods_img}' />";
            return $imgs;
        });
        $show->goods_intro('产品介绍');
//        $show->images_url('轮播图')->unescape()->as(function ($images_url) {
//            if (!empty($images_url)) {
//                $url = env('QINIU_DOMAIN');
//                $imgs = '';
//                foreach ($images_url as $img) {
//                    $imgs .=  "<img class='img-rounded' style='max-width: 30%; height: 150px;
//                            border: 1px solid #f0f0f0;
//                            margin: 5px;' src='http://{$url}/{$img}' />";
//                }
//                return $imgs;
//            }
//            return '未上传轮播图';
//        });
//        $show->goods_content('产品详情')->unescape()->as(function ($goods_content) {
//            return $goods_content;
//        });
        $show->created_at('添加时间');

        $show->panel()->tools(function ($tools) {
            $tools->disableEdit();
        });

        return $show;
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new OwnBrand());

        $grid->sort('排序')->editable()->sortable();
        $grid->goods_name('产品名称');
        $grid->goods_img('产品图片')->image();
        $grid->is_show('是否显示')->editable('select', [1 => '显示', 0 => '隐藏']);

//        $grid->actions(function ($actions) {
//            $actions->disableView(); // 禁用查看
//        });

        $grid->tools(function ($tools) {
            // 禁用批量删除按钮
            $tools->batch(function ($batch) {
                $batch->disableDelete();
            });
        });

        // 查询
        $grid->filter(function($filter){

            // 去掉默认的id过滤器
            $filter->disableIdFilter();

            $filter->like('goods_name', '产品名称');
            $filter->equal('is_show', '显隐')->radio([1 => '显示', 0 => '隐藏']);
        });

        // 设置默认显示数
        $grid->paginate(10);

        return $grid;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new OwnBrand());

        $form->text('goods_name', '产品名称')->rules('required');
        $form->textarea('goods_intro', '产品介绍')->rules('required');
        $form->UEditor('goods_content', '产品详情')->rules('required');
        $form->image('goods_img', '产品图片')->rules('required|image');
        $form->multipleImage('images_url', '轮播图')->removable()->rules(function ($form) {
            // 如果不是编辑状态，则添加字段必填验证
            if (!$id = $form->model()->id) {
                return 'required|image';
            } else {
                return 'image';
            }
        });
        $form->radio('is_show', '显示&隐藏')->options([1 => '显示', 0 => '隐藏'])->default(1);
        $form->text('sort', '排序')->default(0);

        $form->text('goods_type', '产品种类')->disable();

        $form->tools(function (Form\Tools $tools) {
            // 去掉`查看`按钮
            $tools->disableView();
        });

        $form->footer(function ($footer) {
            // 去掉`查看`checkbox
            $footer->disableViewCheck();
        });

        return $form;
    }
}
