<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Encore\Admin\Facades\Admin;
use Laravel\Scout\Searchable;

class ProjectEnterpriseModel extends Model
{
    use Searchable;

    protected  $table = 'admin_project_enterprise';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable = [
        'name', 'representative', 'address', 'region', 'city', 'district', 'biz_status','credit_code', 'register_code', 'phone', 'email', 'setup_time', 'industry', 'biz_scope', 'company_type',  'registered_capital', 'word', 'project_id', 'create_user_id', 'note'
    ];

    public function creater()
    {
        return $this->belongsTo('Encore\Admin\Auth\Database\Administrator', 'create_user_id', 'id');
    }

    public function order()
    {
        return $this->belongsTo('Encore\Admin\Auth\Database\Administrator', 'order_user_id', 'id');
    }

    public function lasterEditer()
    {
        return $this->belongsTo('Encore\Admin\Auth\Database\Administrator', 'lastediter_id', 'id');
    }

    public function project()
    {
        return $this->belongsTo('App\Project', 'project_id', 'project_id');
    }

    public static function boot()
    {
        parent::boot();

        static::updating(function($model){
            if($model->status == 4)
            {
                $model->order_user_id = Admin::user()->id;
            }
            $model->lastediter_id = Admin::user()->id;
        });
    }

    public function mapping()
    {
        $mapping = array('company' => array('type' => 'keyword'));
        return $mapping;
    }

    public function searchableAs()
    {
        return 'PRIMARY';
    }

    public function toSearchableArray()
    {
        $array = $this->toArray();

        return $array;
    }

    public function getScoutKey()
    {
        return $this->name;
    }

    public function getScoutKeyName()
    {
        return 'company';
    }
}
