<?php

namespace App\Admin\Controllers;

use App\Models\OwnBrand;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class OwnBrandController extends Controller
{
    use HasResourceActions;

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
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
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
        return $content
            ->header('产品新增')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new OwnBrand());

        $grid->id('ID')->sortable()->style('vertical-align: middle;');
        $grid->goods_name('产品名称')->style('vertical-align: middle;');
        $grid->goods_img('产品图片')->style('vertical-align: middle;')->image();
        $grid->is_show('是否显示')->editable('select', [1 => '显示', 0 => '隐藏']);
        $grid->sort('排序')->editable()->sortable();

        $grid->actions(function ($actions) {
            $actions->disableView(); // 禁用查看
        });

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

            $filter->like('name', '产品名称');
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
