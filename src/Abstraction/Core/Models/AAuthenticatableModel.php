<?php

namespace CuongDev\Larab\Abstraction\Core\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class AAuthenticatableModel extends Authenticatable
{

    protected $connection = 'mysql';
}
