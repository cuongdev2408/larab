<?php

namespace CuongDev\Larab\Abstraction\Core\Controllers;

use CuongDev\Larab\Abstraction\Core\Services\ABaseService;
use CuongDev\Larab\Abstraction\Definition\Message;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

abstract class AApiCrudController extends ABaseApiController
{
    /** @var ABaseService $baseService */
    protected $baseService;

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    protected function getList(Request $request): JsonResponse
    {
        $params = $request->all();
        $result = $this->baseService->getList($params);

        return $this->apiResponse->respond($result);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    protected function getAll(Request $request): JsonResponse
    {
        $params = $request->all();
        $result = $this->baseService->getAll($params);

        return $this->apiResponse->respond($result);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    protected function findOne(Request $request): JsonResponse
    {
        $params = $request->all();
        $result = $this->baseService->findOne($params);

        return $this->apiResponse->respond($result);
    }

    /**
     * @param $id
     * @param Request $request
     * @return JsonResponse
     */
    protected function getOne($id, Request $request): JsonResponse
    {
        $params = $request->all();

        $result = $this->baseService->getOne($id, $params);

        return $this->apiResponse->respond($result);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    protected function create(Request $request): JsonResponse
    {
        $result = $this->baseService->create($request->all());

        return $this->apiResponse->respond($result);
    }

    /**
     * @param $id
     * @param Request $request
     * @return JsonResponse
     */
    protected function update($id, Request $request): JsonResponse
    {
        $result = $this->baseService->update($id, $request->all());

        return $this->apiResponse->respond($result);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    protected function delete($id): JsonResponse
    {
        $data = $this->baseService->delete($id);

        return $this->apiResponse->success($data, Message::DELETE_SUCCESS);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    protected function deleteMulti(Request $request): JsonResponse
    {
        $params = $request->all();
        $result = $this->baseService->deleteMulti($params);

        return $this->apiResponse->respond($result);
    }
}
