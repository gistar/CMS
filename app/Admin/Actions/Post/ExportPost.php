<?php

namespace App\Admin\Actions\Post;

use Encore\Admin\Actions\Action;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExportPost extends Action
{
    protected $selector = '.export-post';

    public function handle(Request $request)
    {
        // $request ...

        return $this->response()->success('导出成功')->refresh();
    }

    public function html()
    {
        $url = asset('storage/excel/import-template.xlsx');
        return <<<HTML
        <a class="btn btn-sm btn-default export-post" href="{$url}" target="_blank">数据导入模板</a>
HTML;
    }
}