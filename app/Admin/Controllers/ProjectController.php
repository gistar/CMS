<?php

namespace App\Admin\Controllers;

use App\Department;
use App\Project;
use Encore\Admin\Auth\Database\Administrator;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Encore\Admin\Facades\Admin;

class ProjectController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = '项目';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Project());
        $grid->column('project_id', __('Project id'));
        $grid->column('name', __('Name'));
        $grid->column('department.department_name', '部门名称');
        $grid->column('note', __('备注'));
        $grid->column('createUser.username', '创建人');
        $grid->column('members','成员')->pluck('name')->label();
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        $this->attributes['title'] = 'test';
        $departments = Administrator::find(Admin::user()->id)->department()->get();
        $departmentIds = array();
        foreach ($departments as $department)
        {
            $departmentIds[] = $department->department_id;
        }
        $grid->model()->whereIn('department_id', $departmentIds);

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
        $show = new Show(Project::findOrFail($id));

        $show->field('project_id', __('Project id'));
        $show->field('name', __('Name'));
        $show->field('department', __('部门'))->as(function ($department){
            return $department->department_name;
        });

        $show->field('members', '组员')->as(function ($members){
            return $members->pluck('name');
        })->label();

        $show->field('createUser','创建人')->as(function($createUser){
            return $createUser ? $createUser->name : '';
        });
        $show->field('note', __('Note'));
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
        $form = new Form(new Project);

        $form->text('name', __('Name'));
        $form->select('department_id', '部门')->options(Department::all()->pluck('department_name', 'department_id'));

        $form->multipleSelect('members', '组员')->options(Administrator::all()->pluck('name','id'));

        //$form->multipleSelect('members', '部门组员')->options();

        $form->text('note', '项目备注');
        $form->hidden('create_user_id', 50);
        $form->saving(function (Form $form){
            $form->create_user_id = Admin::user()->id;
        });
        return $form;
    }

    protected function departmentproject(Content $content, $departmentid)
    {
        $grid = new Grid(new Project());
        $grid->column('project_id', __('Project id'));
        $grid->column('name', __('Name'));
        $grid->column('department.department_name', '部门名称');
        $grid->column('note', __('备注'));
        $grid->column('createUser.username', '创建人');
        $grid->column('members','成员')->pluck('name')->label();
        $grid->column('created_at', __('Created at'));
        $grid->column('updated_at', __('Updated at'));

        $grid->model()->where('department_id', '=', $departmentid);
        $grid->setResource("/admin/departmentProjects/{$departmentid}");
        return $content->body($grid);

    }
}
