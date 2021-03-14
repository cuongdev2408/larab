<?php

namespace CuongDev\Larab\Abstraction\Core\Models;


use Illuminate\Database\Eloquent\Model;

class AModel extends Model
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
