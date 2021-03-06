<?php

namespace App\Admin\Controllers;

use App\Models\SuperStore;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class SuperStoreController extends Controller
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
            ->header('商超合作列表')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('商超详情')
            ->body($this->detail($id));
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
        Admin::script($this->removeCancelButton());
        Admin::script($this->addTips('images_url', 1100, 500));

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
        Admin::script($this->removeCancelButton());
        Admin::script($this->addTips('images_url', 1100, 500));

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

        $grid->sort('排序')->editable()->sortable();
        $grid->name('商超名称');
        $grid->is_show('是否显示')->editable('select', [1 => '显示', 0 => '隐藏']);
        $grid->created_at('添加时间')->sortable();

//        $grid->actions(function ($actions) {
//            $actions->disableView(); // 禁用查看
//        });

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
        $form = new Form(new SuperStore());

        $form->text('name', '商超名称')->rules('required');
        $form->textarea('intro', '商超简介')->rules('required');
        $form->editor('content', '商超详情')->rules('required');
        $form->image('logo', '商超图标')->rules('required|image');
        $form->multipleImage('images_url', '商超图片')->removable()->rules(function ($form) {
            // 如果不是编辑状态，则添加字段必填验证
            if (!$id = $form->model()->id) {
                return 'required|image';
            } else {
                return 'image';
            }
        });
        $form->radio('is_show', '显示&隐藏')->options([1 => '显示', 0 => '隐藏'])->default(1);
        $form->text('sort', '排序')->default(0);

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

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(SuperStore::findOrFail($id));

        $show->name('商超名称');
        $show->content('商超详情')->unescape()->as(function ($content) {
            return $content;
        });
        $show->logo('商超图标')->unescape()->as(function ($logo) {
            $url = env('QINIU_DOMAIN');
            $imgs = "<img class='img-rounded' style='max-width: 30%; height: 150px; 
                            border: 1px solid #f0f0f0;
                            margin: 5px;' src='http://{$url}/{$logo}' />";
            return $imgs;
        });
        $show->images_url('商超图片')->unescape()->as(function ($images_url) {
            if (!empty($images_url)) {
                $url = env('QINIU_DOMAIN');
                $imgs = '';
                foreach ($images_url as $img) {
                    $imgs .= "<img class='img-rounded' style='max-width: 30%; height: 150px;
                            border: 1px solid #f0f0f0;
                            margin: 5px;' src='http://{$url}/{$img}' />";
                }
                return $imgs;
            }

            return '无图片';
        });
        $show->created_at('添加时间');

        $show->panel()->tools(function ($tools) {
            $tools->disableEdit();
        });

        return $show;
    }
}
