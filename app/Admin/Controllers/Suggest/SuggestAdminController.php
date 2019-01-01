<?php

namespace App\Admin\Controllers\Suggest;

use App\Http\Constant\Constant;
use App\Models\Suggest;

use App\Models\User;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class SuggestAdminController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('header');
            $content->description('description');

            $content->body($this->grid());
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('header');
            $content->description('description');

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('header');
            $content->description('description');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Suggest::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->user()->nickname('用户');
            $grid->content('内容')->limit(20);
            $grid->response('回复')->display(function ($response){
                if (!$response)
                    return '暂未回复';
                return $response;
            });
            $grid->created_at('留言时间');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Suggest::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->select('user_id','用户id')->options(User::options());
            $form->text('content','留言内容');
            $form->text('response','回复');
            $form->switch('is_readed','是否已读')->states(Constant::SWITCH_STATE);
            $form->display('created_at', '留言时间');
            $form->display('updated_at', '回复时间');

        });
    }
}
