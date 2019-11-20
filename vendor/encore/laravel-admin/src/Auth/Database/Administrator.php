<?php

namespace Encore\Admin\Auth\Database;

use Encore\Admin\Form\Field\HasMany;
use Encore\Admin\Traits\AdminBuilder;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;

/**
 * Class Administrator.
 *
 * @property Role[] $roles
 */
class Administrator extends Model implements AuthenticatableContract
{
    use Authenticatable, AdminBuilder, HasPermissions;

    protected $fillable = ['username', 'password', 'name', 'avatar'];

    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $connection = config('admin.database.connection') ?: config('database.default');

        $this->setConnection($connection);

        $this->setTable(config('admin.database.users_table'));

        parent::__construct($attributes);
    }

    /**
     * Get avatar attribute.
     *
     * @param string $avatar
     *
     * @return string
     */
    public function getAvatarAttribute($avatar)
    {
        if (url()->isValidUrl($avatar)) {
            return $avatar;
        }

        $disk = config('admin.upload.disk');

        if ($avatar && array_key_exists($disk, config('filesystems.disks'))) {
            return Storage::disk(config('admin.upload.disk'))->url($avatar);
        }

        $default = config('admin.default_avatar') ?: '/vendor/laravel-admin/AdminLTE/dist/img/user2-160x160.jpg';

        return admin_asset($default);
    }

    /**
     * A user has and belongs to many roles.
     *
     * @return BelongsToMany
     */
    public function roles() : BelongsToMany
    {
        $pivotTable = config('admin.database.role_users_table');

        $relatedModel = config('admin.database.roles_model');

        return $this->belongsToMany($relatedModel, $pivotTable, 'user_id', 'role_id');
    }

    /**
     * A User has and belongs to many permissions.
     *
     * @return BelongsToMany
     */
    public function permissions() : BelongsToMany
    {
        $pivotTable = config('admin.database.user_permissions_table');

        $relatedModel = config('admin.database.permissions_model');

        return $this->belongsToMany($relatedModel, $pivotTable, 'user_id', 'permission_id');
    }

    public function department() : BelongsToMany
    {
        return $this->belongsToMany('App\department', 'admin_department_users', 'user_id', 'department_id')->withTimestamps();
    }

    public function admin() : HasOne
    {
        return $this->hasOne('App\Department', 'leader_id', 'id');
    }

    public function project() : BelongsToMany
    {
        return $this->belongsToMany('App\Project', 'admin_project_members', 'user_id', 'project_id');
    }

    public function projectCreater() : HasMany
    {
        return $this->hasMany('App\Project', 'create_user_id', 'id');
    }

    public function projectMember() : BelongsToMany
    {
        return $this->belongsToMany('App\Project', 'admin_project_members', 'user_id', 'project_id');
    }

    public function projectEnterpriseCreater() : HasMany
    {
        return $this->hasMany('App\ProjectEnterpriseModel', 'create_user_id', 'id');
    }

    public function projectEnterpriseOrder(): HasMany
    {
        return $this->hasMany('App\ProjectEnterpriseModel', 'order_user_id', 'id');
    }

    public function projectEnterpriseLastediter(): HasMany
    {
        return $this->hasMany('App\ProjectEnterpriseModel', 'lastediter_id', 'id');
    }
}
