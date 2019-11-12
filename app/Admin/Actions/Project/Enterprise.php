<?php

namespace App\Admin\Actions\Project;

use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;

class Enterprise extends RowAction
{
    public $name = '企业';

    public function handle(Model $model)
    {
        // $model ...

        return $this->response()->success('Success message.')->refresh();
    }

    public function href()
    {
        return "/admin/department/projects/{$this->getKey()}/enterprise";
    }
}