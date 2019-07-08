<?php

namespace App\Admin\Controllers;

use App\Models\MerchantsProxy;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class MerchantsProxyController extends Controller
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
        Admin::script($this->addTips('business_license', '354', '250'));

        return $content
            ->header('招商代理')
            ->body($this->form()->edit($id));
    }

    public function update($id)
    {
        $this->form()->update($id);

        admin_toastr('内容更新成功', 'success');

        return redirect('/admin/merchants_proxy/1/edit');
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new MerchantsProxy());

        $form->text('name', '公司名称')->rules('required');
        $form->text('contact', '联系人')->rules('required');
        $form->text('tel', '联系电话')->rules('required');
        $form->text('address', '公司地址')->rules('required');
        $form->image('business_license', '公司营业执照 *')->rules('required|image');
        $form->text('range', '经营范围')->rules('required');

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
