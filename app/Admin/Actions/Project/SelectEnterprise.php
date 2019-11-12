<?php

namespace App\Admin\Actions\Project;

use Encore\Admin\Actions\Action;
use Illuminate\Http\Request;

class SelectEnterprise extends Action
{
    protected $selector = '.select-enterprise';

    public function handle(Request $request)
    {
        // Get the `type` value in the form
        $request->get('type');

        // Get the `reason` value in the form
        $request->get('reason');


        return $this->response()->success('Success message...')->refresh();
    }

    public function html()
    {
        return <<<HTML
        <a class="btn btn-sm btn-default select-enterprise" >选择企业</a>
HTML;
    }

    public function form()
    {
        $type = [
            1 => 'Advertising',
            2 => 'Illegal',
            3 => 'Fishing',
        ];

        $this->checkbox('type', 'type')->options($type);
        $this->textarea('reason', 'reason')->rules('required');
    }
}