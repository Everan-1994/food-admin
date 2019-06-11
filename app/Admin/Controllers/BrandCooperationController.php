<?php

namespace App\Admin\Controllers;

use App\Models\BrandCooperation;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class BrandCooperationController extends Controller
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
            ->header('品牌合作列表')
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
            ->header('品牌详情')
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
        Admin::script($this->addTips('logo', '196', '124'));
        Admin::script($this->addTips('logo_hover', '196', '124'));

        return $content
            ->header('品牌合作编辑')
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
        Admin::script($this->addTips('logo', '196', '124'));
        Admin::script($this->addTips('logo_hover', '196', '124'));

        return $content
            ->header('品牌合作新增')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new BrandCooperation);

        $grid->sort('排序')->editable()->sortable();
        $grid->name('品牌名称');
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

            $filter->like('name', '品牌名称');
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
        $form = new Form(new BrandCooperation);

        $form->text('name', '品牌名称')->rules('required');
        $form->UEditor('content', '品牌详情')->rules('required');
        $form->image('logo', '品牌图标')->rules('required|image');
        $form->image('logo_hover', '品牌图标(hover)')->rules('required|image');
//        $form->multipleImage('images_url', '品牌图片')->removable()->rules(function ($form) {
//            // 如果不是编辑状态，则添加字段必填验证
//            if (!$id = $form->model()->id) {
//                return 'required|image';
//            } else {
//                return 'image';
//            }
//        });
        $form->file('video', '视频')->rules('mimetypes:video/avi,video/mp4');
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
        $show = new Show(BrandCooperation::findOrFail($id));

        $show->name('品牌名称');
        $show->content('品牌详情')->unescape()->as(function ($content) {
            return $content;
        });
        $show->logo('品牌图标')->unescape()->as(function ($logo) {
            $url = env('QINIU_DOMAIN');
            $imgs = "<img class='img-rounded' style='max-width: 30%; height: 150px; 
                            border: 1px solid #f0f0f0;
                            margin: 5px;' src='http://{$url}/{$logo}' />";
            return $imgs;
        });
        $show->logo_hover('品牌图标(hover)')->unescape()->as(function ($logo_hover) {
            $url = env('QINIU_DOMAIN');
            $imgs = "<img class='img-rounded' style='max-width: 30%; height: 150px; 
                            border: 1px solid #f0f0f0;
                            margin: 5px;' src='http://{$url}/{$logo_hover}' />";
            return $imgs;
        });
        $show->created_at('添加时间');

        $show->panel()->tools(function ($tools) {
            $tools->disableEdit();
        });

        return $show;
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
