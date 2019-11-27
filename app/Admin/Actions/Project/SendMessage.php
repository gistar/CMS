<?php

namespace App\Admin\Actions\Project;

use App\Smssign;
use App\SmsTemplate;
use Encore\Admin\Actions\BatchAction;
use Encore\Admin\Facades\Admin;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class SendMessage extends BatchAction
{
    public $name = '发送短信';

    public function handle(Collection $collection, Request $request)
    {
        $sendId = Admin::user()->id;

        $templateid = $request->get('template_id');
        $templateInstant = SmsTemplate::find($templateid);
        $signid = $request->get('sign_id');
        $signInstant = Smssign::find($signid);
        foreach ($collection as $model) {
            preg_match('/.*([\d]{11}).*/', $model->phone, $telephone);
            if(isset($telephone[1])){
                dispatch(new \App\Jobs\SendMessage($telephone[1],
                    $templateInstant,
                    $signInstant,
                    $sendId))
                    ->onQueue('Message');
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
        $this->select('template_id','短信模板')->options($templates);
        $sign = Smssign::all()->pluck('name', 'id');
        $this->select('sign_id', '签名')->options($sign);
    }
}