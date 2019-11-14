<?php

namespace App\Admin\Actions\Project;

use Encore\Admin\Actions\BatchAction;
use Illuminate\Database\Eloquent\Collection;

class SendMessage extends BatchAction
{
    public $name = '发送短信';

    public function handle(Collection $collection)
    {
        foreach ($collection as $model) {
            preg_match('/.*([\d]{11}).*/', $model->phone, $telephone);
            if(isset($telephone[1])){
                dispatch(new \App\Jobs\SendMessage($telephone[1]));
            }
            continue;
        }

        return $this->response()->success('Success message...')->refresh();
    }

}