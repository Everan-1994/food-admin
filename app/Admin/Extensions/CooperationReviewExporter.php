<?php
/**
 * User: everan
 * Date: 2019/8/20
 * Time: 7:21 PM
 */

namespace App\Admin\Extensions;

use Encore\Admin\Grid\Exporters\ExcelExporter;

class CooperationReviewExporter extends ExcelExporter
{
    protected $fileName = '留言列表.xlsx';

    protected $columns = [
        'title' => '需求标题',
        'user_name' => '姓名',
        'user_tel' => '联系方式',
        'user_email' => '邮箱',
        'user_address' => '详细地址',
        'created_at' => '提交时间',
    ];

    protected $headings = [
        '需求标题', '姓名',
        '联系方式', '邮箱',
        '详细地址', '提交时间'
    ];
}