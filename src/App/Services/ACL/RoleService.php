<?php


namespace CuongDev\Larab\App\Services\ACL;


use CuongDev\Larab\Abstraction\Core\Services\ABaseService;
use CuongDev\Larab\Abstraction\Definition\Constant;
use CuongDev\Larab\Abstraction\Object\Result;
use CuongDev\Larab\App\Repositories\ACL\PermissionRepository;
use CuongDev\Larab\App\Repositories\ACL\RoleRepository;

class RoleService extends ABaseService
{
    /** @var RoleRepository $baseRepository */
    protected $baseRepository;

    /** @var PermissionRepository $permissionRepository */
    private $permissionRepository;

    public function __construct(RoleRepository $roleRepository, PermissionRepository $permissionRepository)
    {
        parent::__construct();
        $this->baseRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;

        $this->baseRepository->setComparableFields([
            'name',
        ]);

        $this->baseRepository->setSearchableFields([
            'name',
            'display_name',
        ]);
    }

    /**
     * @param $id
     * @return Result
     */
    public function delete($id): Result
    {
        return $this->baseRepository->deleteRole($id);
    }

    /**
     * @param $id
     * @param $permissionIds
     * @return Result
     */
    public function syncPermissions($id, $permissionIds): Result
    {
        $permissions = $this->permissionRepository->getList([
            'limit'  => Constant::MAX_LIMIT,
            'getAll' => true,
            'ids'    => $permissionIds,
        ]);

        if ($permissions->isEmpty()) {
            return $this->result->failureResult(null, 'Không tìm thấy các quyền hạn tương ứng.');
        }

        return $this->baseRepository->syncPermissions($id, $permissions->all());
    }

    /**
     * @param array $params
     * @return array
     */
    protected function extendProcessParams($params = []): array
    {
        $processedParams = [];

        if (isset($params['permissions']) && !is_array($params['permissions']) && is_string($params['permissions'])) {
            $processedParams['permissions'] = array_map('trim', explode(',', $params['permissions']));
        }

        return $processedParams;
    }
}
