<?php

namespace App\Admin\Controllers;

use App\Models\News;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;

class NewsController extends Controller
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
            ->header('新闻列表')
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

        Admin::script($this->script());
        Admin::script($this->removeCancelButton());
        Admin::script($this->addTips('image', '503', '387'));

        return $content
            ->header('编辑新闻')
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
        $this->imageOrVideoShow();
        Admin::script($this->removeCancelButton());
        Admin::script($this->addTips('image', '503', '387'));

        return $content
            ->header('添加新闻')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new News);

        $grid->sort('排序')->editable()->sortable();
        $grid->title('新闻标题');
        $grid->type('新闻分类')->display(function ($type) {
            return News::$newsType[$type];
        });
        $grid->from('新闻来源');
        $grid->is_show('是否显示')->editable('select', [1 => '显示', 0 => '隐藏']);
        $grid->created_at('添加时间')->sortable();

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

            $filter->like('title', '新闻标题');
            $filter->equal('type', '新闻分类')->select(News::$newsType);
            $filter->equal('is_show', '显隐')->radio([1 => '显示', 0 => '隐藏']);
        });

        return $grid;
    }

    /**
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new News);

        $form->text('title', '新闻标题')->rules('required');
        $form->select('type', '新闻分类')->options(News::$newsType)->rules('required');
        $form->textarea('intro', '新闻简介')->rules('required');
        $form->text('from', '新闻来源')->rules('required');
        $form->UEditor('content', '新闻详情')->rules('required');

        $form->select('resource_type', '封面')->options([1 => '图片', 2 => '视频'])->default(1);

        $form->image('image', '图片')->rules('image');
        $form->file('video', '视频')->rules('mimetypes:video/avi,video/mp4');

        $form->radio('is_show', '显示&隐藏')->options([1 => '显示', 0 => '隐藏'])->default(1);
        // $form->text('sort', '排序')->default(0);

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
