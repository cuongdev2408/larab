<?php

namespace CuongDev\Larab\App\Http\Controllers\Api\ACL;

use CuongDev\Larab\Abstraction\Core\Controllers\AApiCrudController;
use CuongDev\Larab\App\Services\ACL\RoleService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RoleController extends AApiCrudController
{

    public function __construct(RoleService $roleService)
    {
        parent::__construct();
        $this->baseService = $roleService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function syncPermissions(Request $request): JsonResponse
    {
        $data = $request->only(['id', 'permissions']);

        if (!isset($data['id'])) {
            return $this->apiResponse->failure(null, 'Vui lòng chọn xác định ID vai trò cần gán quyền hạn.');
        }

        if (!isset($data['permissions'])) {
            return $this->apiResponse->failure(null, 'Vui lòng chọn danh sách quyền hạn.');
        }

        $result = $this->baseService->syncPermissions($data['id'], $data['permissions']);

        return $this->apiResponse->respond($result);
    }
}
