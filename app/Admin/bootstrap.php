<?php

/**
 * Laravel-admin - admin builder based on Laravel.
 * @author z-song <https://github.com/z-song>
 *
 * Bootstraper for Admin.
 *
 * Here you can remove builtin form field:
 * Encore\Admin\Form::forget(['map', 'editor']);
 *
 * Or extend custom form field:
 * Encore\Admin\Form::extend('php', PHPEditor::class);
 *
 * Or require js and css assets:
 * Admin::css('/packages/prettydocs/css/styles.css');
 * Admin::js('/packages/prettydocs/js/main.js');
 *
 */

Encore\Admin\Form::forget(['map', 'editor']);

\Encore\Admin\Form::extend('ueditor',\App\Admin\Extensions\Editors\UEditor::class);

\Encore\Admin\Grid\Column::extend('expand',\App\Admin\Extensions\Columns\ExpandRow::class);
\Encore\Admin\Grid\Column::extend('enlargeimage',\App\Admin\Extensions\Columns\EnlargeImage::class);

\Encore\Admin\Admin::css('css/admin_widget.css');
\Encore\Admin\Admin::js('js/admin_widget.js');
