<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/10/18
 * Time: 11:10
 */

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Department extends Model
{

    protected $table = 'admin_department';

    protected $fillable = ['department_name', 'department_desc', 'leader'];

    protected $primaryKey = 'department_id';

    public function department() : BelongsToMany
    {
        return $this->belongsToMany('App\Department', 'admin_department_users', 'department_id', 'user_id');
    }
}