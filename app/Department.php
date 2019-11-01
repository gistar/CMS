<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/10/18
 * Time: 11:10
 */

namespace App;

use Encore\Admin\Auth\Database\Administrator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Department extends Model
{

    protected $table = 'admin_department';

    protected $fillable = ['department_name', 'department_desc', 'leader_id', 'user_id', 'created_at', 'updated_at'];

    protected $primaryKey = 'department_id';

    public function members() : BelongsToMany
    {
        return $this->belongsToMany('Encore\Admin\Auth\Database\Administrator', 'admin_department_users', 'department_id', 'user_id');
    }

    public function leader() : BelongsTo
    {
        return $this->belongsTo('Encore\Admin\Auth\Database\Administrator',  'leader_id', 'id');
    }

    public function project() : HasMany
    {
        return $this->hasMany('App\Project', 'department_id',  'department_id');
    }
}