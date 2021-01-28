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
     * @return number
     */
    public function getHttpStatusCode()
    {
        return $this->httpStatusCode;
    }

    /**
     * @param int $httpStatusCode
     */
    public function setHttpStatusCode(int $httpStatusCode)
    {
        $this->httpStatusCode = $httpStatusCode;
        return $this;
    }

    /**
     * @return array
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param array $headers
     */
    public function setHeaders(array $headers)
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
    public function success($data = null, $message = Message::SUCCESS, $optional = null, $headers = [])
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
    public function failure($data = null, $message = Message::FAILURE, $optional = null, $headers = [])
    {
        /** @var Result $result */
        $result = new Result(StatusCode::FAILURE, $data, $message, $optional);

        return $this->respond($result, $headers);
    }

    /**
     * @param Result $result
     * @param array $headers
     * @return JsonResponse
     */
    public function respond(Result $result, $headers = [])
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
