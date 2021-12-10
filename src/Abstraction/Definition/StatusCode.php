<?php

namespace CuongDev\Larab\Abstraction\Definition;

class StatusCode
{
    const FAILURE = 0;
    const SUCCESS = 1;

    const HTTP_OK = 200;
    const HTTP_NO_CONTENT = 204;

    const HTTP_BAD_REQUEST = 400;
    const HTTP_UNAUTHORIZED = 401;
    const HTTP_FORBIDDEN = 403;
    const HTTP_NOT_FOUND = 404;
    const HTTP_METHOD_NOT_ALLOWED = 405;

    const HTTP_INTERNAL_SERVER_ERROR = 500;

    protected $httpStatusCodes = [
        self::HTTP_OK                    => 'OK',
        self::HTTP_NO_CONTENT            => 'No content',
        self::HTTP_BAD_REQUEST           => 'Bad Request',
        self::HTTP_UNAUTHORIZED          => 'Unauthorized',
        self::HTTP_FORBIDDEN             => 'Forbidden',
        self::HTTP_NOT_FOUND             => 'Not Found',
        self::HTTP_METHOD_NOT_ALLOWED    => 'Method Not Allowed',
        self::HTTP_INTERNAL_SERVER_ERROR => 'Internal Server Error',
    ];

    /**
     * @return array
     */
    public function getHttpStatusCodes(): array
    {
        return $this->httpStatusCodes;
    }

    /**
     * @param array $httpStatusCodes
     */
    public function setHttpStatusCodes(array $httpStatusCodes): void
    {
        $this->httpStatusCodes = $httpStatusCodes;
    }
}
