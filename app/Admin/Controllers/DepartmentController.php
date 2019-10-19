<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/10/18
 * Time: 11:40
 */

namespace App\Admin\Controllers;

use App\Department;
use Encore\Admin\Auth\Database\Administrator;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Controllers\AdminController;
use Encore\Admin\Layout\Content;

class DepartmentController extends AdminController
{
    protected function grid(Content $content)
    {
        $group = new Department;
        
        $grid = new Grid($group);

        $grid->column('department_id', 'ID')->sortable();
        $grid->column('department_name', '组名');
        $grid->column('department_dec', '描述');

        return $content->row($grid);
    }

    protected function form(Content $content)
    {
        $form = new Form(new Department());

        $form->text('department_name');
        $form->text('department_dec');
        $form->time('created_at');

        return $content->row($form);
    }
}