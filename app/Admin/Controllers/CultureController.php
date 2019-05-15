<?php

namespace App\Admin\Controllers;

use App\Models\Culture;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Layout\Content;

class CultureController extends Controller
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
            ->header('底部内容')
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

        return redirect('/admin/culture/1/edit');
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Culture);

        $form->image('logo', '企业logo')->rules('required|image');
        $form->text('name', '企业名称')->rules('required');
        $form->text('tel', '企业热线')->rules('required');
        $form->text('address', '企业地址')->rules('required');
        $form->image('wx_qrcode', '微信二维码')->rules('required|image');
        $form->image('kf_qrcode', '客服二维码')->rules('required|image');

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
