<?php

Encore\Admin\Form::forget(['map', 'editor']);
Encore\Admin\Form::extend('editor', \App\Admin\Extensions\WangEditor::class);

Encore\Admin\Grid::init(function (\Encore\Admin\Grid $grid) {
    // 禁用导出数据按钮
    $grid->disableExport();
    // 禁用 行选择
    // $grid->disableRowSelector();
});