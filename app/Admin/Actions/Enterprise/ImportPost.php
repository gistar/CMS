<?php

namespace App\Admin\Actions\Enterprise;

use App\EnterpriseModel;
use App\Imports\EnterpriseImport;
use Encore\Admin\Actions\Action;
use function foo\func;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportPost extends Action
{
    public $name = 'import data';

    protected $selector = '.import-post';

    public function model(array $row)
    {
        return new EnterpriseModel();
    }

    public function handle(Request $request)
    {
        Excel::import(new EnterpriseImport, $request->file('file'));
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
        <a class="btn btn-sm btn-default import-post"><i class="fa fa-upload"></i>导入数据</a>
HTML;
    }
}