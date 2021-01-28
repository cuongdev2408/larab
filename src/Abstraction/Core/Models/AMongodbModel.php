<?php

namespace CuongDev\Larab\Abstraction\Core\Models;

use Jenssegers\Mongodb\Eloquent\HybridRelations;
use Jenssegers\Mongodb\Eloquent\Model;

class AMongodbModel extends Model
{
    use HybridRelations;

    protected $connection = 'mongodb';
}
