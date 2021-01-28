<?php

namespace CuongDev\Larab\Abstraction\Definition;

class StatusCode
{
    const FAILURE = 0;
    const SUCCESS = 1;

    const HTTP_OK = 200;
    const HTTP_NO_CONTENT = 204;

    const HTTP_UNAUTHORIZED = 401;
    const HTTP_NOT_FOUND = 404;

    const HTTP_INTERNAL_SERVER_ERROR = 500;
}
