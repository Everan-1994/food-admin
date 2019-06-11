<?php

namespace App\Admin\Controllers;

use App\Models\AboutUs;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class AboutUsController extends Controller
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
            ->header('企业相关')
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
        $this->imageOrVideoShow();
        Admin::script($this->removeCancelButton());

        return $content
            ->header('信息编辑')
            ->body($this->form()->edit($id));
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new AboutUs);

        $grid->title('模块');
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
        $form = new Form(new AboutUs);

        $form->text('title', '标题')->rules('required');
        $form->UEditor('content', '介绍')->rules('required');
        $form->file('video', '视频')->rules('mimetypes:video/avi,video/mp4');

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

    protected function imageOrVideoShow() {
        return Admin::script('
            $(document).ready(() => {
                if ($("select[name=resource_type]").val() == 1) {
                    $(".form-group").eq(5).hide();
                } else {
                    $(".form-group").eq(4).hide();
                }
            
                $("select[name=resource_type]").change(function() {
                  if (this.value == 1) {
                     $(".form-group").eq(4).show();
                     $(".form-group").eq(5).hide();
                  }
                  
                  if (this.value == 2) {
                     $(".form-group").eq(4).hide();
                     $(".form-group").eq(5).show();
                  }
                });
            });
        ');
    }
}
