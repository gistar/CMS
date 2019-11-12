<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Project extends Model
{
    protected $table = 'admin_project';

    protected $primaryKey = 'project_id';

    public function department() : BelongsTo
    {
        return $this->belongsTo('App\Department', 'department_id', 'department_id');
    }

    public function createUser()
    {
        return $this->belongsTo('Encore\Admin\Auth\Database\Administrator', 'create_user_id' , 'id');
    }

    public function members()
    {
        return $this->belongsToMany('Encore\Admin\Auth\Database\Administrator', 'admin_project_members', 'project_id', 'user_id');
    }

    public function enterprise()
    {
        return $this->hasMany('App\ProjectEnterpriseModel', 'project_id', 'project_id');
    }

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($model){
            ProjectMembers::where('project_id', $model->project_id)->delete();
        });
    }
}
