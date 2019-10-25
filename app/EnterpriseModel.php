<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EnterpriseModel extends Model
{
    //
    const CREATED_AT = 'gmt_create';
    const UPDATED_AT = 'gmt_modify';

    protected $table = 'enterprise';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable = [
        'name', 'representative', 'region','city','district', 'biz_status', 'phone', 'email', 'setup_time', 'registered_capital', 'word'
    ];
}
