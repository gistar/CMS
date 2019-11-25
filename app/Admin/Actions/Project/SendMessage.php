<?php

namespace App\Admin\Actions\Project;

use App\Project;
use App\SmsTemplate;
use Encore\Admin\Actions\BatchAction;
use Encore\Admin\Facades\Admin;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

class SendMessage extends BatchAction
{
    public $name = '发送短信';

    public function handle(Collection $collection, Request $request)
    {
        $sendId = Admin::user()->id;
        foreach ($collection as $model) {
            preg_match('/.*([\d]{11}).*/', $model->phone, $telephone);

            if(isset($telephone[1])){
                dispatch(new \App\Jobs\SendMessage($telephone[1],$request->get('templateId'), $sendId))->onQueue('Message');
            }
            continue;
        }

        return $this->response()->success('Success message...')->refresh();
    }

    public function form()
    {
        /*$projectId = Route::current()->projectId;
        if($projectId != null){
            Session::put('projectId', $projectId);
        }
        $project = Project::find(Session::get('projectId'));
        $templates = $project->smsTemplate()->pluck('title','id');*/
        $templates = SmsTemplate::all()->pluck('title', 'id');
        $this->select('templateId','短信模板')->options($templates);
    }
}