<?php

namespace App\Admin\Actions\Project;

use Encore\Admin\Actions\Action;
use Illuminate\Http\Request;

class ExportTemplate extends Action
{
    protected $selector = '.export-template';

    public function handle(Request $request)
    {
        // $request ...

        return $this->response()->success('成功导出')->refresh();
    }

    public function html()
    {
        $url = asset('storage/excel/import-project-enterprise-template.xlsx');
        return <<<HTML
        <a class="btn btn-sm btn-default export-template" href="{$url}" target="_blank">导出模板</a>
HTML;
    }
}