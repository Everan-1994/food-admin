<?php

namespace App\Admin\Controllers;

use App\Models\SuperStore;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class SuperStoreController extends Controller
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
            ->header('商超合作列表')
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
            ->header('商超合作编辑')
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
            ->header('商超合作新增')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new SuperStore());

        $grid->id('Id')->sortable();
        $grid->name('商超名称');
        $grid->created_at('添加时间')->sortable();

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

            $filter->like('name', '商超名称');
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
        $form = new Form(new SuperStore());

        $form->text('name', '商超名称')->rules('required');
        $form->UEditor('content', '商超详情')->rules('required');
        $form->image('logo', '商超图标')->rules('required|image');
        $form->multipleImage('images_url', '商超图片')->removable()->rules(function ($form) {
            // 如果不是编辑状态，则添加字段必填验证
            if (!$id = $form->model()->id) {
                return 'required|image';
            } else {
                return 'image';
            }
        });
        $form->text('company_name', '厂家名称')->disable();
        $form->text('contact', '联系人')->disable();
        $form->text('tel', '联系电话')->disable();
        $form->text('address', '厂家地址')->disable();

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
