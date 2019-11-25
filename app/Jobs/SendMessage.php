<?php

namespace App\Jobs;
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;
use App\SmsLog;
use App\SmsTemplate;
use Encore\Admin\Facades\Admin;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
     * [Message] => OK
     *  [RequestId] => CFD39C67-38C5-43BC-9D22-76C584D181ED
     *  [BizId] => 363802774501268929^0
     *  [Code] => OK
     * @return void
     */
    public function handle()
    {
        $content = SmsTemplate::find($this->templateid)->content;
        AlibabaCloud::accessKeyClient( env('SMS_ACCESS_KEYID', ''), env('SMS_ACCESS_KeySECRET', ''))
            ->regionId('cn-hangzhou')
            ->asDefaultClient();
        try {
            $result = AlibabaCloud::rpc()
                ->product('Dysmsapi')
                ->version('2017-05-25')
                ->action('SendSms')
                ->method('POST')
                ->host('dysmsapi.aliyuncs.com')
                ->options([
                    'query' => [
                        'RegionId' => "cn-hangzhou",
                        'PhoneNumbers' => "13021922850",
                        'SignName' => "中国国际电梯展览会",
                        'TemplateCode' => "SMS_113090028",
                        //'TemplateParam' => "{\"code\":\"462914\"}",
                        'TemplateParam' => "{462914}",
                        'SmsUpExtendCode' => "00000",
                        'OutId' => "11111",
                    ],
                ])
                ->request();
            $messageStatus = $result->toArray()['Code'] == 'OK' ? 'sended' : 'sendwar';
        } catch (ClientException $e) {
            echo $e->getErrorMessage() . PHP_EOL;
            $messageStatus = 'senderr';
        } catch (ServerException $e) {
            $messageStatus = 'senderr';
        }
        $id = DB::table('smslogs')->insertGetId(
            ['phone'=> $this->telephone,
            'templateid' => $this->templateid,
            'content'=> $content,
            'status' => $messageStatus,
            'message' => $result,
            'sender' => $this->sendid]);
        Log::channel('smslog')->info('SendSms id:'. $id . ',phone:'. $this->telephone . ',templateid:' . $this->templateid . ',status:'. $messageStatus);
    }
}
