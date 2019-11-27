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

    private $template;

    private $templateid;

    private $tempcode;

    private $sign;

    private $signid;

    private $sendid;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($telephone, $templateInstant, $signInstant, $sendId)
    {
        $this->telephone = $telephone;
        $this->template = $templateInstant->content;
        $this->templateid = $templateInstant->id;
        $this->tempcode = $templateInstant->code;
        $this->sign = $signInstant->name;
        $this->signid = $signInstant->id;
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
                        'PhoneNumbers' => $this->telephone,
                        'SignName' => $this->sign,
                        'TemplateCode' => $this->tempcode
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
            'content'=> $this->template,
            'status' => $messageStatus,
            'message' => $result,
            'sender' => $this->sendid]);
        Log::channel('smslog')->info('SendSms id:'. $id . ',phone:'. $this->telephone . ',templateid:' . $this->templateid . ',status:'. $messageStatus);
    }
}
