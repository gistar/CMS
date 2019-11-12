<?php

namespace App\Admin\Actions\Project;

use App\Imports\ProjectEnterpriseImport;
use Encore\Admin\Actions\Action;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportEnterprise extends Action
{
    protected $selector = '.import-enterprise';

    public function handle(Request $request)
    {

        Excel::import(new ProjectEnterpriseImport(), $request->file('file'));
        return $this->response()->success('Success message...')->refresh();
    }

    public function form()
    {
        $this->file('file', 'Please select file')
            ->options(['showPreview' => false,
                'allowedFileExtensions'=>['xlsx'],
                'showUpload'=>true
            ]);
    }

    public function html()
    {
        return <<<HTML
        <a class="btn btn-sm btn-default import-enterprise">导入企业</a>
HTML;
    }
}