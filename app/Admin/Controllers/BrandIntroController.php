<?php

namespace App\Admin\Controllers;

use App\Models\BrandIntro;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class BrandIntroController extends Controller
{
    use HasResourceActions;

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
            ->header('品牌介绍')
            ->body($this->form()->edit($id));
    }

    public function update($id)
    {
        $this->form()->update($id);

        admin_toastr('内容更新成功', 'success');

        return redirect('/admin/brand_intro/1/edit');
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new BrandIntro());

        $form->textarea('intro', '品牌介绍')->rules('required');
        $form->textarea('feature', '品牌特征')->rules('required');
        $form->textarea('idea', '品牌理念')->rules('required');
        $form->image('brand_image', '品牌图片')->rules('required|image');
        $form->file('brand_video', '品牌视频')->rules('required|mimetypes:video/avi,video/mp4');

        $form->tools(function (Form\Tools $tools) {
            // 去掉`列表`按钮
            $tools->disableList();
            // 去掉`删除`按钮
            $tools->disableDelete();
            // 去掉`查看`按钮
            $tools->disableView();
        });

        $form->footer(function ($footer) {
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
