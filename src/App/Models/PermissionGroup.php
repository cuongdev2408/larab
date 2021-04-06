<?php


namespace CuongDev\Larab\App\Models;


use CuongDev\Larab\Abstraction\Core\Models\AModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PermissionGroup extends AModel
{
    protected $table = 'permission_groups';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'display_name',
    ];

    /**
     * @return HasMany
     */
    public function permissions(): HasMany
    {
        return $this->hasMany(config('permission.models.permission'), 'permission_id', 'id');
    }
}
