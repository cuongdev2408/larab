<?php

namespace CuongDev\Larab\Abstraction\Definition;

class Constant
{
    const DEFAULT_LIMIT = 20;
    const MAX_LIMIT = PHP_INT_MAX;

    const DEFAULT_ORDER_BY = 'updated_at';
    const DEFAULT_ORDER_DIRECTION = 'desc';

    const INACTIVE = 0;
    const ACTIVE = 1;
    const PENDING = 2;

    const STATUS_ACTIVE = 'Hoạt động';
    const STATUS_INACTIVE = 'Không hoạt động';
    const STATUS_PENDING = 'Đang chờ';

    const MALE = 1;
    const FEMALE = 0;
}
