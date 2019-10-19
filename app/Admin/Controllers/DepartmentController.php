<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/10/18
 * Time: 11:40
 */

namespace App\Admin\Controllers;

use App\Department;
use Illuminate\Routing\Controller;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Auth\Database\Administrator;

class DepartmentController extends Controller
{
    protected function grid()
    {
        $grid = new Grid(new Department);

        $grid->column('department_id', 'ID')->sortable();
        $grid->column('department_name', '组名');
        $grid->column('department_dec', '描述');

        return $grid;
    }

    protected function form()
    {
        $form = new Form(new Department());

        $form->text('department_name', '部门名字')->rules('required|min:3');
        $form->text('department_dec', '部门描述')->rules('required|min:3');

        $form->select('leader_id', '部门领导')->options(Administrator::all()->pluck('username','id'));
        
        $form->multipleSelect('user_id', '组员')->options(Administrator::all()->pluck('username','id'));
        return $form;
    }

    protected function index(Content $content)
    {
        return $content->title('部门')->description('列表')->body($this->grid());
    }

    protected function create(Content $content)
    {
        return $content->title('部门')->body($this->form());
    }

    protected function store()
    {
        return $this->form()->store();
    }
}