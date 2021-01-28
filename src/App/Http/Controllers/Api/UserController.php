<?php


namespace CuongDev\Larab\App\Http\Controllers\Api;


use CuongDev\Larab\Abstraction\Core\Controllers\AApiCrudController;
use CuongDev\Larab\App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends AApiCrudController
{

    public function __construct(UserService $userService)
    {
        parent::__construct();
        $this->baseService = $userService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function syncRoles(Request $request): JsonResponse
    {
        $data = $request->only(['id', 'roles']);

        if (!isset($data['id'])) {
            return $this->apiResponse->failure(null, 'Vui lòng chọn xác định ID người dùng cần gán vai trò.');
        }

        if (!isset($data['roles'])) {
            return $this->apiResponse->failure(null, 'Vui lòng chọn danh sách vai trò.');
        }

        $result = $this->baseService->syncRoles($data['id'], $data['roles']);

        return $this->apiResponse->respond($result);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function syncPermissions(Request $request): JsonResponse
    {
        $data = $request->only(['id', 'permissions']);

        if (!isset($data['id'])) {
            return $this->apiResponse->failure(null, 'Vui lòng chọn xác định ID người dùng cần gán quyền hạn.');
        }

        if (!isset($data['permissions'])) {
            return $this->apiResponse->failure(null, 'Vui lòng chọn danh sách quyền hạn.');
        }

        $result = $this->baseService->syncPermissions($data['id'], $data['permissions']);

        return $this->apiResponse->respond($result);
    }
}
