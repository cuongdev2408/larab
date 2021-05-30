<?php

namespace CuongDev\Larab\Abstraction\Object;

use CuongDev\Larab\Abstraction\Definition\Message;
use CuongDev\Larab\Abstraction\Definition\StatusCode;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;

class ApiResponse
{
    /** @var int HTTP Status Code to set into response */
    protected $httpStatusCode = StatusCode::HTTP_OK;

    protected $headers = [];

    /**
     * @return int
     */
    public function getHttpStatusCode(): int
    {
        return $this->httpStatusCode;
    }

    /**
     * @param int $httpStatusCode
     * @return ApiResponse
     */
    public function setHttpStatusCode(int $httpStatusCode): ApiResponse
    {
        $this->httpStatusCode = $httpStatusCode;
        return $this;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * @param array $headers
     * @return ApiResponse
     */
    public function setHeaders(array $headers): ApiResponse
    {
        $this->headers = $headers;
        return $this;
    }

    public function __construct()
    {
    }

    /**
     * @param $data
     * @param string $message
     * @param null $optional
     * @param array $headers
     * @return JsonResponse
     */
    public function success($data = null, string $message = Message::SUCCESS, $optional = null, array $headers = []): JsonResponse
    {
        $result = new Result(StatusCode::SUCCESS, $data, $message, $optional);

        return $this->respond($result, $headers);
    }

    /**
     * @param mixed $data
     * @param string $message
     * @param null $optional
     * @param array $headers
     * @return JsonResponse
     */
    public function failure($data = null, string $message = Message::FAILURE, $optional = null, array $headers = []): JsonResponse
    {
        $result = new Result(StatusCode::FAILURE, $data, $message, $optional);

        return $this->respond($result, $headers);
    }

    /**
     * @param Result $result
     * @param array $headers
     * @return JsonResponse
     */
    public function respond(Result $result, array $headers = []): JsonResponse
    {
        if (!empty($this->headers)) {
            $headers = array_merge($this->headers);
        }

        $data = $result->getData();
        if ($data instanceof LengthAwarePaginator) {
            $result->setData($data->items());

            $optional = $result->getOptional();
            if (!empty($optional)) {
                $optional = array_merge($optional, ['paginator' => $data->setCollection(collect([]))]);
                $result->setOptional($optional);
            } else {
                $result->setOptional(['paginator' => $data->setCollection(collect([]))]);
            }
        }

        return response()->json($result->toArray(), $this->getHttpStatusCode() ?? StatusCode::HTTP_OK, $headers);
    }
}
