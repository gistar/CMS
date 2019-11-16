<?php

namespace App\Admin\Controllers;

use App\SmsLog;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class SmsLogsController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\SmsLog';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new SmsLog);

        $grid->column('id', __('Id'));
        $grid->column('phone', __('Phone'));
        $grid->column('templateId', __('TemplateId'));
        $grid->column('content', __('Content'));
        $grid->column('status', __('Status'));
        $grid->column('message', __('Message'));
        $grid->column('sender', __('Sender'));
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
        $show = new Show(SmsLog::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('phone', __('Phone'));
        $show->field('templateId', __('TemplateId'));
        $show->field('content', __('Content'));
        $show->field('status', __('Status'));
        $show->field('message', __('Message'));
        $show->field('sender', __('Sender'));
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
        $form = new Form(new SmsLog);

        $form->mobile('phone', __('Phone'));
        $form->number('templateId', __('TemplateId'));
        $form->text('content', __('Content'));
        $form->text('status', __('Status'));
        $form->text('message', __('Message'));
        $form->text('sender', __('Sender'));

        return $form;
    }
}
