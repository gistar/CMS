<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SmsTemplate extends Model
{
    protected $table = 'smstemplate';

    public function project()
    {
        return $this->belongsTo('App\Project', 'projectId', 'project_id');
    }
}
