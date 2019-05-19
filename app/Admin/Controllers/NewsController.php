<?php

namespace App\Admin\Controllers;

use App\Models\News;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class NewsController extends Controller
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

        $grid->id('ID')->sortable();
        $grid->title('新闻标题');
        $grid->type('新闻分类')->display(function ($type) {
            return News::$newsType[$type];
        });
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
        $grid->filter(function($filter){

            // 去掉默认的id过滤器
            $filter->disableIdFilter();

            $filter->like('title', '新闻标题');
            $filter->equal('type', '新闻分类')->select(News::$newsType);
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
        $form = new Form(new News);

        $form->text('title', '新闻标题')->rules('required');
        $form->select('type', '新闻分类')->options(News::$newsType);
        $form->UEditor('content', '新闻详情')->rules('required');
        $form->image('image', '封面图')->rules('required|image');

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
