<?php

namespace App\Admin\Controllers;

use App\Models\CooperationReview;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class CooperationReviewController extends Controller
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
            ->header('合作审核列表')
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
            ->header('合作详情')
            ->body($this->detail($id));
    }


    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new CooperationReview);

        $grid->title('需求标题');
        $grid->user_name('姓名');
        $grid->user_tel('联系方式');
        $grid->user_email('邮箱');
        $grid->user_address('详细地址');
        $grid->created_at('提交时间')->sortable();

        $grid->actions(function ($actions) {
            $actions->disableEdit(); // 禁用编辑
        });

        $grid->tools(function ($tools) {
            // 禁用批量删除按钮
            $tools->batch(function ($batch) {
                $batch->disableDelete();
            });
        });

        // 禁用新增按钮
        $grid->disableCreateButton();

        // 查询
        $grid->filter(function ($filter) {

            // 去掉默认的id过滤器
            $filter->disableIdFilter();

            $filter->like('user_name', '姓名');
            $filter->like('user_tel', '联系方式');
            $filter->like('user_email', '邮箱');

        });

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(CooperationReview::findOrFail($id));

        $show->title('需求标题');
        $show->user_name('姓名');
        $show->user_tel('联系方式');
        $show->user_email('邮箱');
        $show->user_address('详细地址');
        $show->images_url('图片描述')->unescape()->as(function ($images_url) {
            $url = env('QINIU_DOMAIN');
            $imgs = '';
            foreach ($images_url as $img) {
                $imgs .=  "<img class='img-rounded' style='max-width: 30%; height: 150px; 
                            border: 1px solid #f0f0f0;
                            margin: 5px;' src='http://{$url}/{$img}' />";
            }
            return $imgs;
        });
        $show->created_at('提交时间');

        $show->panel()->tools(function ($tools) {
            $tools->disableEdit();
        });

        return $show;
    }

    public function form()
    {
        $form = new Form(new CooperationReview());

//        $form->text('title', '需求标题')->rules('required');
//        $form->text('user_name', '姓名')->rules('required');
//        $form->text('user_tel', '联系方式')->rules('required');
//        $form->text('user_email', '邮箱')->rules('required');
//        $form->text('user_address', '详细地址')->rules('required');
//        $form->multipleImage('images_url', '品牌图片')->removable()->rules(function ($form) {
//            // 如果不是编辑状态，则添加字段必填验证
//            if (!$id = $form->model()->id) {
//                return 'required|image';
//            } else {
//                return 'image';
//            }
//        });

        return $form;
    }

}
