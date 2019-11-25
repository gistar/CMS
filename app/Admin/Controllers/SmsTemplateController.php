<?php

namespace App\Admin\Controllers;

use App\SmsTemplate;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;

class SmsTemplateController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '短信模板';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new SmsTemplate);

        $grid->column('id', __('Id'));
        //$grid->column('project.name', trans('admin.project_name'));
        $grid->column('title', __('Title'));
        $grid->column('content', __('Content'));
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
        $show = new Show(SmsTemplate::findOrFail($id));

        $show->field('id', __('Id'));
        //$show->field('project.name', trans('admin.project_name'));
        $show->field('title', __('Title'));
        $show->field('content', __('Content'));
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
        $form = new Form(new SmsTemplate);

        //$form->select('projectId', trans('admin.project_name'))->options(SmsTemplate::all()->pluck('title','id'));
        $form->text('title', __('Title'));
        $form->text('content', __('Content'));

        return $form;
    }
}
