<?php

namespace App\Admin\Controllers;

use App\Models\PictureVideo;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Layout\Content;

class PictureVideoController extends Controller
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
        Admin::script($this->script());
        Admin::script($this->removeCancelButton());
        Admin::script($this->addTextTips('brand_image', '最多可上传5张图片'));
        Admin::script($this->addTips('brand_image', '768', '450'));
        Admin::script($this->addTextTips('brand_video', '最多可上传1个视频'));

        return $content
            ->header('品牌图片&视频')
            ->body($this->form()->edit($id));
    }
    public function update($id)
    {
        $result = $this->form()->update($id);

        if (optional(json_decode($result->getContent()))->status) {
            return $result;
        } else {
            admin_toastr('内容更新成功', 'success');
            return redirect('/admin/brand_intro_pv/1/edit');
        }
    }
    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new PictureVideo());

         $form->multipleImage('brand_image', '品牌图片')->removable()->rules('image');
         $form->multipleFile('brand_video', '品牌视频')->removable()->rules('mimetypes:video/avi,video/mp4');

        $form->tools(function (Form\Tools $tools) {
            // 去掉`列表`按钮
            $tools->disableList();
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
