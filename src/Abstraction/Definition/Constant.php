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
    const SUSPEND = 3;

    const MALE = 1;
    const FEMALE = 0;

    public static $statusText = [
        self::INACTIVE => 'Không hoạt động',
        self::ACTIVE   => 'Hoạt động',
        self::PENDING  => 'Đang chờ',
        self::SUSPEND  => 'Tạm khoá',
    ];

    /**
     * @param $status
     * @return string
     */
    public static function getStatusText($status): string
    {
        return self::$statusText[$status] ?? 'Không xác định';
    }
}
