<?php

namespace CuongDev\Larab\Abstraction\Core\Models;


use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;
use Illuminate\Support\Carbon;

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

    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param DateTimeInterface $date
     * @return string
     */
    protected function serializeDate(DateTimeInterface $date)
    {
        return Carbon::parse($date)->setTimezone(config('app.timezone'))->format('Y-m-d H:i:s');
    }
}
