<?php

namespace App\Jobs;

use App\SmsLog;
use App\SmsTemplate;
use Encore\Admin\Facades\Admin;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class SendMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $telephone;

    private $templateid;

    private $sendid;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($telephone, $templateId, $sendId)
    {
        $this->telephone = $telephone;
        $this->templateid = $templateId;
        $this->sendid = $sendId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $content = SmsTemplate::find($this->templateid)->content;
        //todo 发送短信
        $sendStatus = 'sended';
        //echo $sendStatus;
        //记录logo
        $insertStatus = DB::insert('insert into smslogs (phone, templateid, content, status, message, sender) value (?, ?, ?, ?, ?, ?)',
            [$this->telephone, $this->templateid, $content, 'presend', $sendStatus, $this->sendid]);
        echo($insertStatus);
    }
}
