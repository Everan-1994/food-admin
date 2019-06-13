<?php

namespace App\Admin\Controllers;

use App\Models\BrandIntro;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;

class BrandIntroController extends Controller
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
            ->header('品牌介绍')
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
            ->header('品牌介绍编辑')
            ->body($this->form()->edit($id));
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new BrandIntro());

        $grid->id('#');
        $grid->title('页面')->editable();
        $grid->is_show('是否显示')->editable('select', [1 => '显示', 0 => '隐藏']);
        $grid->created_at('添加时间');

        $grid->actions(function ($actions) {
            $actions->disableView(); // 禁用查看
            $actions->disableDelete(); // 禁用删除
        });

        // 禁用新增按钮
        $grid->disableCreateButton();
        // 禁用筛选
        $grid->disableFilter();

        $grid->tools(function ($tools) {
            // 禁用批量删除按钮
            $tools->batch(function ($batch) {
                $batch->disableDelete();
            });
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
        $form = new Form(new BrandIntro());

        $form->hidden('title', '页面')->rules('required');
        $form->textarea('intro', '品牌介绍')->rules('required');
        $form->textarea('feature', '品牌特征')->rules('required');
        $form->textarea('idea', '品牌理念')->rules('required');
        $form->hidden('is_show', '显示&隐藏')->options([1 => '显示', 0 => '隐藏'])->default(1);

        $form->tools(function (Form\Tools $tools) {
            // 去掉`删除`按钮
            $tools->disableDelete();
            // 去掉`查看`按钮
            $tools->disableView();
        });

        $form->footer(function ($footer) {
            // 去掉 重置 按钮
            $footer->disableReset();
            // 去掉`查看`checkbox
            $footer->disableViewCheck();
            // 去掉`继续编辑`checkbox
            $footer->disableEditingCheck();
            // 去掉`继续创建`checkbox
            $footer->disableCreatingCheck();
        });

        return $form;
    }
}
