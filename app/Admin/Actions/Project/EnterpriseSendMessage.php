<?php

namespace App\Admin\Actions\Project;

use App\Smssign;
use App\SmsTemplate;
use Illuminate\Http\Request;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Actions\RowAction;
use Illuminate\Database\Eloquent\Model;

class EnterpriseSendMessage extends RowAction
{
    public $name = '发送短信';

    public function handle(Model $model, Request $request)
    {
        $sendId = Admin::user()->id;

        $templateid = $request->get('template_id');
        $templateInstant = SmsTemplate::find($templateid);
        $signid = $request->get('sign_id');
        $signInstant = Smssign::find($signid);

        preg_match('/.*([\d]{11}).*/', $model->phone, $telephone);
        if(isset($telephone[1])){
            dispatch(new \App\Jobs\SendMessage($telephone[1],
                $templateInstant,
                $signInstant,
                $sendId))
                ->onQueue('Message');
        }

        return $this->response()->success('Success message...')->refresh();
    }

    public function form()
    {
        $templates = SmsTemplate::all()->pluck('title', 'id');
        $this->select('template_id','短信模板')->options($templates);
        $sign = Smssign::all()->pluck('name', 'id');
        $this->select('sign_id', '签名')->options($sign);
    }

}