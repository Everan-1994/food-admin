<?php

namespace App\Admin\Controllers;

use App\Models\Server;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class ServersController extends Controller
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
        Admin::script($this->removeCancelButton());
        Admin::script($this->addTextTips('images_url', '最多上传5张图片'));

        return $content
            ->header('服务理念')
            ->body($this->form()->edit($id));
    }

    public function update($id)
    {
        $result = $this->form()->update($id);

        if (optional(json_decode($result->getContent()))->status) {
            return $result;
        } else {
            admin_toastr('内容更新成功', 'success');
            return redirect('/admin/servers/1/edit');
        }
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Server);

        $form->UEditor('content', '内容')->rules('required');
        $form->multipleImage('images_url', '轮播图')->removable()->rules('image');

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
