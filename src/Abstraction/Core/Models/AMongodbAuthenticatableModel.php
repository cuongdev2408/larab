<?php

namespace CuongDev\Larab\Abstraction\Core\Models;

use Jenssegers\Mongodb\Auth\User as Authenticatable;
use Jenssegers\Mongodb\Eloquent\HybridRelations;

class AMongodbAuthenticatableModel extends Authenticatable
{
    use HybridRelations;

    protected $connection = 'mongodb';
}
