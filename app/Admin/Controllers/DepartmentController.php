<?php
/**
 * Created by Gongye.
 * User: Administrator
 * Date: 2019/10/18
 * Time: 11:40
 */

namespace App\Admin\Controllers;

use App\Admin\Actions\Department\Project;
use App\Department;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Layout\Content;
use Encore\Admin\Auth\Database\Administrator;
use Encore\Admin\Controllers\HasResourceActions;
use Illuminate\Routing\Controller;
use Illuminate\Database\Eloquent\Collection;

class DepartmentController extends Controller
{

    use HasResourceActions;

    protected $title = '部门';

    protected function title()
    {
        return $this->title;
    }

    protected function grid()
    {
        $grid = new Grid(new Department());
        $grid->column('department_id', 'ID')->sortable();
        $grid->column('department_name', trans('admin.department_name'));
        $grid->column('department_dec', trans('admin.department_description'));
        $grid->column('leader.name', trans('admin.leader'))->label();
        $grid->column('project',trans('admin.project'))->pluck('name')->label();
        $grid->column('members', trans('admin.members'))->pluck('name')->label();
        if(!Admin::user()->isRole('administrator') || Admin::user()->cannot('department.admin.view'))
        {
            $users = Administrator::with('department')->where('id',Admin::user()->id)->get();
            foreach ($users as $user)
            {
                foreach($user->department as $department){
                    $userDepartments[] = $department->department_id;
                }
            }
            $grid->model()->wherein('department_id', $userDepartments);
        }

        $grid->actions(function ($actions) {
            $actions->add(new Project());
        });
        return $grid;
    }

    protected function form()
    {
        $form = new Form(new Department());

        $form->text('department_name', trans('admin.department_name'))->rules('required|min:3');
        $form->text('department_dec', trans('admin.department_description'))->rules('required|min:3');

        $form->select('leader_id', trans('admin.leader'))->options(Administrator::all()->pluck('name','id'));
        $form->multipleSelect('members', trans('admin.members'))->options(Administrator::all()->pluck('name','id'));

        return $form;
    }

    protected function detail($id)
    {
        $show = new Show(Department::findOrFail($id));

        $show->field('department_id', 'ID');
        $show->field('department_name', trans('admin.department_name'));
        $show->field('department_dec', trans('admin.department_description'));

        $show->field('leader',trans('admin.leader'))->as(function($leader){
            return $leader->name;
        })->label();
        $show->field('members', trans('admin.members'))->as(function ($member){
            return $member->pluck('name');
        })->label();

        $show->field('created_at', trans('admin.created_at'));
        $show->field('updated_at', trans('admin.updated_at'));

        return $show;
    }

    protected function index(Content $content)
    {
        return $content->title($this->title())->description(trans('admin.list'))->body($this->grid());
    }

    protected function create(Content $content)
    {
        return $content->title($this->title())->body($this->form());
    }

    protected function show($id, Content $content)
    {
        return $content->title($this->title())->body($this->detail($id));
    }

    protected function edit($id, Content $content)
    {
        return $content
            ->title($this->title())
            ->body($this->form()->edit($id));
    }
}
