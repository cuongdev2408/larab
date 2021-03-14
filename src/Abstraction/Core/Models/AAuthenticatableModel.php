<?php

namespace CuongDev\Larab\Abstraction\Core\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class AAuthenticatableModel extends Authenticatable
{

    protected $connection = 'mysql';

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'deleted_at' => 'datetime:Y-m-d H:i:s',
    ];
}
