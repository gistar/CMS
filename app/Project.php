<?php

namespace App;

use Encore\Admin\Form\Field\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Project extends Model
{
    //
    protected $table = 'admin_project';

    protected $primaryKey = 'project_id';

    public function department() : BelongsTo
    {
        return $this->belongsTo('App\Department', 'department_id', 'department_id');
    }
}
