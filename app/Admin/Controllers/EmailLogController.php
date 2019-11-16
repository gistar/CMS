<?php

namespace App\Admin\Controllers;

use App\EmailLog;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class EmailLogController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'App\EmailLog';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new EmailLog);

        $grid->column('id', __('Id'));
        $grid->column('email', __('Email'));
        $grid->column('templateid', __('Templateid'));
        $grid->column('status', __('Status'));
        $grid->column('service', __('Service'));
        $grid->column('sender', __('Sender'));
        $grid->column('message', __('Message'));
        $grid->column('openstatus', __('Openstatus'));
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
        $show = new Show(EmailLog::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('email', __('Email'));
        $show->field('templateid', __('Templateid'));
        $show->field('status', __('Status'));
        $show->field('service', __('Service'));
        $show->field('sender', __('Sender'));
        $show->field('message', __('Message'));
        $show->field('openstatus', __('Openstatus'));
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
        $form = new Form(new EmailLog);

        $form->email('email', __('Email'));
        $form->number('templateid', __('Templateid'));
        $form->text('status', __('Status'));
        $form->number('service', __('Service'));
        $form->number('sender', __('Sender'));
        $form->text('message', __('Message'));
        $form->text('openstatus', __('Openstatus'));

        return $form;
    }
}
