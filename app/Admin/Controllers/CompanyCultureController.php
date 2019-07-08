<?php

namespace App\Admin\Controllers;

use App\Models\CompanyCulture;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class CompanyCultureController extends Controller
{
    use HasResourceActions, ScriptTrait;

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        Admin::script($this->addTips('image_url', '705', '438'));
        Admin::script($this->removeCancelButton());

        return $content
            ->header('企业文化')
            ->body($this->form()->edit($id));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id)
    {
        $this->form()->update($id);

        admin_toastr('内容更新成功', 'success');

        return redirect('/admin/company_culture/1/edit');
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new CompanyCulture());

        $form->text('name', '企业名称')->rules('required');
        $form->text('en_name', '企业名称(en)')->rules('required');
        $form->image('image_url', '图片')->rules('required|image');
        $form->editor('content', '内容')->rules('required');

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
