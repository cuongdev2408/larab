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

        try {
            $data = $this->baseRepository->getList($params);

            return $this->result->successResult($data);
        } catch (Exception $e) {
            return $this->result->failureResult(null, Message::FIND_FAILURE . $e->getMessage());
        }
    }

    /**
     * @param array $params
     * @return Result
     */
    public function findOne($params = []): Result
    {
        $params['limit'] = 1;
        $params['getOne'] = 1;
        $params = $this->processParams($params);

        try {
            $data = $this->baseRepository->getList($params);

            if ($data) {
                return $this->result->successResult($data);
            }

            return $this->result->failureResult($data);
        } catch (Exception $e) {
            return $this->result->failureResult(null, Message::FIND_FAILURE . $e->getMessage());
        }
    }

    /**
     * @param $id
     * @param array $params
     * @return Result
     */
    public function getOne($id, $params = []): Result
    {
        $params = $this->processParams($params);

        try {
            $object = $this->baseRepository->getOne($id, $params);
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
     * @param array $data
     * @return Result
     */
    public function create(array $data): Result
    {
        try {
            $data = $this->processDataBeforeSave($data);

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
     * @param array $data
     * @return Result
     */
    public function update($id, array $data): Result
    {
        try {
            $data = $this->processDataBeforeSave($data);

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
        $processedParams['getOne'] = isset($params['getOne']) ? $params['getOne'] : false;

        $processedParams = array_merge($processedParams, $this->extendProcessParams($params));

        return $processedParams;
    }

    /**
     * @param array $params
     * @return array
     */
    protected function extendProcessParams($params = []): array
    {
        $processedParams = [];

        return $processedParams;
    }

    /**
     * @param array $data
     * @return array
     */
    protected function processDataBeforeSave($data = []): array
    {
        return $data;
    }
}
