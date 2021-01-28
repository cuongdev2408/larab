<?php

namespace CuongDev\Larab\Abstraction\Object;

use CuongDev\Larab\Abstraction\Definition\Message;
use CuongDev\Larab\Abstraction\Definition\StatusCode;

class Result
{
    /** @var number Status code to check in client side */
    protected $status;

    /** @var mixed Data of result object, ex: array, object, ... */
    protected $data;

    /** @var string Message */
    protected $message;

    /** @var mixed Optional data of result object, ex: array, object, ... */
    protected $optional;

    /**
     * @return number
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param number $status
     */
    public function setStatus(int $status)
    {
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message)
    {
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getOptional()
    {
        return $this->optional;
    }

    /**
     * @param mixed $optional
     */
    public function setOptional($optional)
    {
        $this->optional = $optional;
    }

    /**
     * Result constructor.
     * @param int $status Default status is failure
     * @param mixed $data Default data is null
     * @param string $message Default message is failure message
     * @param mixed $optional
     */
    public function __construct($status = StatusCode::FAILURE, $data = null, $message = Message::FAILURE, $optional = null)
    {
        $this->setStatus($status);
        $this->setData($data);
        $this->setMessage($message);
        $this->setOptional($optional);
    }

    /**
     * @param mixed $data
     * @param string $message
     * @param mixed $optional
     * @return $this
     */
    public function successResult($data, $message = Message::SUCCESS, $optional = null): Result
    {
        return $this->getResult(StatusCode::SUCCESS, $data, $message, $optional);
    }

    /**
     * @param mixed $data
     * @param string $message
     * @param mixed $optional
     * @return $this
     */
    public function failureResult($data, $message = Message::FAILURE, $optional = null): Result
    {
        return $this->getResult(StatusCode::FAILURE, $data, $message, $optional);
    }

    /**
     * @param int $status
     * @param mixed $data
     * @param string $message
     * @param mixed $optional
     * @return $this
     */
    public function getResult($status, $data = null, $message = '', $optional = null): Result
    {
        $this->setStatus($status);
        $this->setData($data);
        $this->setMessage($message);
        $this->setOptional($optional);

        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'status'   => $this->getStatus(),
            'data'     => $this->getData(),
            'message'  => $this->getMessage(),
            'optional' => $this->getOptional(),
        ];
    }
}
