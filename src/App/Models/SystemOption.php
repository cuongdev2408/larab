<?php


namespace CuongDev\Larab\App\Models;


use CuongDev\Larab\Abstraction\Core\Models\AModel;

class SystemOption extends AModel
{
    protected $table = 'system_options';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'meta_key',
        'meta_value',
    ];
}
