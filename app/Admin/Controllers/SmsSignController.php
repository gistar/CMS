<?php

namespace App\Admin\Controllers;

use App\Smssign;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class SmsSignController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '短信签名';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Smssign);

        $grid->column('id', __('Id'));
        $grid->column('name', __('Title'));
//        $grid->column('SignSource', __('SignSource'))->using([
////            0 => '企事业单位的全称或简称',
////            1 => '工信部备案网站的全称或简称',
////            2 => 'APP应用的全称或简称',
////            3 => '公众号或小程序的全称或简称',
////            4 => '电商平台店铺名的全称或简称',
////            5 => '商标名的全称或简称'
////        ])->label();
        $grid->column('Remark', __('Remark'));
        $grid->column('status', __('Status'))->using([
            0 => '未通过', 1 => '通过'
        ])->label();
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

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
        $show = new Show(Smssign::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Title'));
//        $show->field('SignSource', __('SignSource'))->using([
//            0 => '企事业单位的全称或简称',
//            1 => '工信部备案网站的全称或简称',
//            2 => 'APP应用的全称或简称',
//            3 => '公众号或小程序的全称或简称',
//            4 => '电商平台店铺名的全称或简称',
//            5 => '商标名的全称或简称'
//        ])->label();
        $show->field('Remark', __('Remark'));
        $show->field('status', __('Status'))->using([
            0 => '未通过', 1 => '通过'
        ])->label();
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Smssign);

        $form->text('name', __('Title'));
//        $form->select('SignSource', __('SignSource'))->options([
//            0 => '企事业单位的全称或简称',
//            1 => '工信部备案网站的全称或简称',
//            2 => 'APP应用的全称或简称',
//            3 => '公众号或小程序的全称或简称',
//            4 => '电商平台店铺名的全称或简称',
//            5 => '商标名的全称或简称'
//        ])->label();
        $form->text('Remark', __('Remark'));
        $form->select('status', __('Status'))->options([
            0 => '未通过', 1 => '通过'
        ])->label();

        return $form;
    }
}
