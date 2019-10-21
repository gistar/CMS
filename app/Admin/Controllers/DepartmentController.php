<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/10/18
 * Time: 11:40
 */

namespace App\Admin\Controllers;

use App\Department;
use function foo\func;
use Illuminate\Routing\Controller;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Encore\Admin\Layout\Content;
use Encore\Admin\Auth\Database\Administrator;
use Encore\Admin\Controllers\HasResourceActions;

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
        $grid->column('department_name', '组名');
        $grid->column('department_dec', '描述');
        $grid->column('leader.name', '部门经理')->label();
        $grid->column('members', '成员')->pluck('name')->label();
        return $grid;
    }

    protected function form()
    {
        $form = new Form(new Department());

        $form->text('department_name', '部门名字')->rules('required|min:3');
        $form->text('department_dec', '部门描述')->rules('required|min:3');

        $form->select('leader_id', '部门领导')->options(Administrator::all()->pluck('username','id'));
        $form->multipleSelect('members', '组员')->options(Administrator::all()->pluck('username','id'));

        return $form;
    }

    protected function detail($id)
    {
        $show = new Show(Department::findOrFail($id));

        $show->field('department_id', 'ID');
        $show->field('department_name', '部门名字');
        $show->field('department_dec', '部门描述');

        $show->field('leader','test')->as(function($leader){
            return $leader->name;
        })->label();
        $show->field('members', '成员')->as(function ($member){
            return $member->pluck('name');
        })->label();

        $show->field('created_at', trans('admin.created_at'));
        $show->field('updated_at', trans('admin.updated_at'));

        return $show;
    }

    protected function index(Content $content)
    {
        return $content->title($this->title())->description('列表')->body($this->grid());
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