<?php

namespace App\Admin\Controllers;

use App\EmailTemplate;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class EmailTemplateController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '邮件模板';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new EmailTemplate);

        $grid->column('id', __('Id'));
        $grid->column('title', __('Title'));
        $grid->column('content', __('Content'));
        //$grid->column('variable', __('Variable'));
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
        $show = new Show(EmailTemplate::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('title', __('Title'));
        $show->field('content', __('Content'));
        //$show->field('variable', __('Variable'));
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
        $form = new Form(new EmailTemplate);

        $form->text('title', __('Title'));
        $form->textarea('content', __('Content'));
        //$form->text('variable', __('Variable'));

        return $form;
    }
}
