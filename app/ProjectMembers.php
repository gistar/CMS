<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ProjectMembers extends Model
{
    //
    protected $table = 'admin_project_members';

    public function members() : BelongsToMany
    {
        return $this->belongsToMany('Encore\Admin\Auth\Database\Administrator', 'admin_project_members', 'project_id', 'user_id');
    }
}
