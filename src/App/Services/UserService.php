<?php


namespace CuongDev\Larab\App\Services;


use CuongDev\Larab\Abstraction\Core\Services\ABaseService;
use CuongDev\Larab\Abstraction\Definition\Constant;
use CuongDev\Larab\Abstraction\Object\Result;
use CuongDev\Larab\App\Repositories\ACL\PermissionRepository;
use CuongDev\Larab\App\Repositories\ACL\RoleRepository;
use CuongDev\Larab\App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;

class UserService extends ABaseService
{
    /** @var UserRepository $baseRepository */
    protected $baseRepository;

    /** @var RoleRepository $roleRepository */
    private $roleRepository;

    /** @var PermissionRepository $permissionRepository */
    private $permissionRepository;

    public function __construct(RoleRepository $roleRepository, PermissionRepository $permissionRepository)
    {
        parent::__construct();
        $this->baseRepository = resolve(UserRepository::class);
        $this->roleRepository = $roleRepository;
        $this->permissionRepository = $permissionRepository;

        $this->baseRepository->setComparableFields([
            'email',
            'username',
            'phone',
            'gender',
            'status',
        ]);

        $this->baseRepository->setSearchableFields([
            'name',
            'email',
            'username',
            'phone',
            'address',
            'gender',
            'status',
        ]);
    }

    /**
     * @param $id
     * @param $roleIds
     * @return Result
     */
    public function syncRoles($id, $roleIds): Result
    {
        $roles = $this->roleRepository->getList([
            'limit'   => Constant::MAX_LIMIT,
            'get_all' => true,
            'ids'     => $roleIds,
        ]);

        if ($roles->isEmpty()) {
            return $this->result->failureResult(null, 'Không tìm thấy các vai trò tương ứng.');
        }

        return $this->baseRepository->syncRoles($id, $roles->all());
    }

    /**
     * @param $id
     * @param $permissionIds
     * @return Result
     */
    public function syncPermissions($id, $permissionIds): Result
    {
        $permissions = $this->permissionRepository->getList([
            'limit'   => Constant::MAX_LIMIT,
            'get_all' => true,
            'ids'     => $permissionIds,
        ]);

        if ($permissions->isEmpty()) {
            return $this->result->failureResult(null, 'Không tìm thấy các quyền hạn tương ứng.');
        }

        return $this->baseRepository->syncPermissions($id, $permissions->all());
    }

    /**
     * @param array $data
     * @return array
     */
    protected function processDataBeforeSave(array $data = []): array
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return parent::processDataBeforeSave($data);
    }

    /**
     * @param array $params
     * @return array
     */
    protected function extendProcessParams(array $params = []): array
    {
        $processedParams = [];

        if (isset($params['roles']) && !is_array($params['roles']) && is_string($params['roles'])) {
            $processedParams['roles'] = array_map('trim', explode(',', $params['roles']));
        }

        if (isset($params['permissions']) && !is_array($params['permissions']) && is_string($params['permissions'])) {
            $processedParams['permissions'] = array_map('trim', explode(',', $params['permissions']));
        }

        return $processedParams;
    }
}
