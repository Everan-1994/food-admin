<?php

namespace App\Admin\Controllers;

use App\Models\ContactUs;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class ContactUsController extends Controller
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
            ->header('门店列表')
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
            ->header('编辑门店')
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
            ->header('添加门店')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new ContactUs);

        $grid->sort('排序')->editable()->sortable();
        $grid->name('门店名称');
        $grid->contact('联系人');
        $grid->tel('联系电话');
        $grid->address('详细地址');
        $grid->is_show('是否显示')->editable('select', [1 => '显示', 0 => '隐藏']);

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
        $grid->filter(function ($filter) {

            // 去掉默认的id过滤器
            $filter->disableIdFilter();

            $filter->like('name', '门店名称');
            $filter->like('contact', '联系人');
            $filter->like('tel', '联系电话');

            $filter->equal('is_show', '显隐')->radio([1 => '显示', 0 => '隐藏']);
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
        $form = new Form(new ContactUs);

        $form->text('name', '门店名称')->rules('required');
        $form->text('tel', '联系电话')->rules('required');
        $form->text('contact', '联系人')->rules('required');
        $form->text('address', '公司地址')->rules('required');
        $form->radio('is_show', '显示&隐藏')->options([1 => '显示', 0 => '隐藏'])->default(1);
        $form->hidden('sort', '排序')->default(0);

        $form->latlong('latitude', 'longitude', '门店定位')->rules('required');

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
