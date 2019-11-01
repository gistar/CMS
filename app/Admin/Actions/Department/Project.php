<?php

namespace App\Admin\Actions\Department;

use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;

class Project extends RowAction
{
    public $name = '项目';

    public function handle(Model $model)
    {
        // $model ...

        return $this->response()->success('Success message.')->refresh();
    }

    public function href()
    {
        return "/admin/departmentProjects/{$this->getKey()}";
    }
}