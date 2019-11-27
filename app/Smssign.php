<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Smssign extends Model
{
    //
    protected $table = 'smssign';

    public function templates(){
        $this->hasMany('App\SmsTemplate', 'sign', 'id');
    }
}
