<?php

namespace CuongDev\Larab\Abstraction\Core\Services;

use CuongDev\Larab\Abstraction\Core\Repositories\ABaseRepository;
use CuongDev\Larab\Abstraction\Definition\Constant;
use CuongDev\Larab\Abstraction\Definition\Message;
use CuongDev\Larab\Abstraction\Object\Result;
use Exception;
use Prettus\Validator\Exceptions\ValidatorException;

abstract class ABaseService
{
    /** @var ABaseRepository $baseRepository */
    protected $baseRepository;

    /** @var Result $result */
    protected $result;

    public function __construct()
    {
        $this->result = new Result();
    }

    /**
     * @param array $params
     * @return Result
     */
    public function getList($params = []): Result
    {
        $params = $this->processParams($params);
        $data = $this->baseRepository->getList($params);

        return $this->result->successResult($data);
    }

    /**
     * @param $id
     * @return Result
     */
    public function getOne($id): Result
    {
        try {
            $object = $this->baseRepository->find($id);
            if ($object) {
                return $this->result->successResult($object, Message::FIND_SUCCESS);
            } else {
                return $this->result->failureResult(null, Message::NOT_FOUND);
            }
        } catch (Exception $e) {
            return $this->result->failureResult(null, Message::FIND_FAILURE . $e->getMessage());
        }
    }

    /**
     * @param $data
     * @return Result
     */
    public function create($data): Result
    {
        try {
            $object = $this->baseRepository->create($data);

            if ($object) {
                return $this->result->successResult($object, Message::CREATE_SUCCESS);
            } else {
                return $this->result->failureResult(null, Message::CREATE_FAILURE);
            }
        } catch (ValidatorException $e) {
            return $this->result->failureResult(null, Message::CREATE_FAILURE . $e->getMessage());
        }
    }

    /**
     * @param $id
     * @param $data
     * @return Result
     */
    public function update($id, $data): Result
    {
        try {
            $object = $this->baseRepository->update($data, $id);

            if ($object) {
                return $this->result->successResult($object, Message::UPDATE_SUCCESS);
            } else {
                return $this->result->failureResult(null, Message::UPDATE_FAILURE);
            }
        } catch (ValidatorException $e) {
            return $this->result->failureResult(null, Message::UPDATE_FAILURE . $e->getMessage());
        }
    }

    /**
     * @param $id
     * @return Result
     */
    public function delete($id): Result
    {
        $data = $this->baseRepository->delete($id);

        if ($data) {
            return $this->result->successResult($data, Message::DELETE_SUCCESS);
        } else {
            return $this->result->failureResult(null, Message::DELETE_FAILURE);
        }
    }

    /**
     * @param $params
     * @return Result
     */
    public function deleteMulti($params = []): Result
    {
        if (empty($params)) {
            return $this->result->failureResult(null, Message::MISSING_PARAMS);
        }

        $data = $this->baseRepository->deleteMulti($params);

        if ($data) {
            return $this->result->successResult($data, Message::DELETE_SUCCESS);
        } else {
            return $this->result->failureResult(null, Message::DELETE_FAILURE);
        }
    }

    /**
     * @param array $params
     * @return array
     */
    protected function processParams($params = []): array
    {
        $processedParams = $params;
        $processedParams['limit'] = isset($params['limit']) ? intval($params['limit']) : Constant::DEFAULT_LIMIT;
        $processedParams['sort'] = isset($params['sort']) && is_array($params['sort']) ? $params['sort'] : [];
        if (isset($params['ids']) && !is_array($params['ids']) && is_string($params['ids'])) {
            $processedParams['ids'] = array_map('trim', explode(',', $params['ids']));
        }

        if (isset($params['with']) && !is_array($params['with']) && is_string($params['with'])) {
            $processedParams['with'] = array_map('trim', explode(',', $params['with']));
        }

        $processedParams['getAll'] = isset($params['getAll']) ? $params['getAll'] : false;

        return $processedParams;
    }
}
