<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SysUser extends Model
{
    //
    protected $table = 'sys_user';

    protected $primaryKey = 'sys_uid';
}
