<?php

namespace CuongDev\Larab\Abstraction\Core\Services;

use CuongDev\Larab\Abstraction\Core\Repositories\ABaseRepository;
use CuongDev\Larab\Abstraction\Definition\Constant;
use CuongDev\Larab\Abstraction\Definition\Message;
use CuongDev\Larab\Abstraction\Object\Result;
use Exception;
use Illuminate\Support\Facades\DB;

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
    public function getList(array $params = []): Result
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
    public function getAll(array $params = []): Result
    {
        $params['limit'] = isset($params['limit']) ? intval($params['limit']) : Constant::MAX_LIMIT;
        $params['get_all'] = true;
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
    public function findOne(array $params = []): Result
    {
        $params['limit'] = 1;
        $params['get_one'] = 1;
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
    public function getOne($id, array $params = []): Result
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
        } catch (Exception $e) {
            return $this->result->failureResult(null, Message::CREATE_FAILURE . $e->getMessage());
        }
    }

    /**
     * @param array $data
     * @return Result
     */
    public function createMulti(array $data): Result
    {
        try {
            DB::beginTransaction();
            $objectList = [];
            foreach ($data as $index => $dataItem) {
                $dataItem = $this->processDataBeforeSave($dataItem);

                $object = $this->baseRepository->create($dataItem);

                if ($object) {
                    $objectList[] = $object;
                } else {
                    DB::rollBack();
                    return $this->result->failureResult(null, Message::CREATE_FAILURE);
                }
            }
            DB::commit();

            return $this->result->successResult($objectList, Message::CREATE_SUCCESS);
        } catch (Exception $e) {
            DB::rollBack();
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
            $data = $this->processDataBeforeSave($data, $id);

            $object = $this->baseRepository->update($data, $id);

            if ($object) {
                return $this->result->successResult($object, Message::UPDATE_SUCCESS);
            } else {
                return $this->result->failureResult(null, Message::UPDATE_FAILURE);
            }
        } catch (Exception $e) {
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
     * @param array $params
     * @return Result
     */
    public function deleteMulti(array $params = []): Result
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
    protected function processParams(array $params = []): array
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

        if (isset($params['status']) && !is_array($params['status']) && is_string($params['status'])) {
            $processedParams['status'] = array_map('trim', explode(',', $params['status']));
        }

        $processedParams['get_all'] = $params['get_all'] ?? false;
        $processedParams['get_one'] = $params['get_one'] ?? false;

        return $processedParams;
    }

    /**
     * @param array $data
     * @return array
     */
    protected function processDataBeforeSave(array $data = []): array
    {
        return $data;
    }
}
