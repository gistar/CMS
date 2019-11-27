<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SmsLog extends Model
{
    protected $table = 'smslogs';

    public function template()
    {
        return $this->belongsTo('App\SmsTemplate', 'templateId', 'id');
    }

    public function send()
    {
        return $this->belongsTo('Encore\Admin\Auth\Database\Administrator', 'sender', 'id');
    }
}
