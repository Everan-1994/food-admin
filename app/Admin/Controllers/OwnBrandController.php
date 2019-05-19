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
        $grid->goods_img('产品图片')->image()->style('vertical-align: middle;');

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
        });

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
        $form->UEditor('goods_intro', '产品详情')->rules('required');
        $form->image('goods_img', '产品图片')->rules('required|image');

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
