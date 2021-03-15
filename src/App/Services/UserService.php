<?php


namespace CuongDev\Larab\App\Services;


use CuongDev\Larab\Abstraction\Core\Services\ABaseService;
use CuongDev\Larab\Abstraction\Definition\Constant;
use CuongDev\Larab\Abstraction\Definition\Message;
use CuongDev\Larab\Abstraction\Object\Result;
use CuongDev\Larab\App\Repositories\ACL\PermissionRepository;
use CuongDev\Larab\App\Repositories\ACL\RoleRepository;
use CuongDev\Larab\App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Prettus\Validator\Exceptions\ValidatorException;

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
            'phone',
            'gender',
            'status',
        ]);

        $this->baseRepository->setSearchableFields([
            'name',
            'email',
            'phone',
            'address',
            'gender',
            'status',
        ]);
    }

    /**
     * @param $id
     * @param $data
     * @return Result
     */
    public function update($id, $data): Result
    {
        try {
            if (isset($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            }

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
     * @param $roleIds
     * @return Result
     */
    public function syncRoles($id, $roleIds): Result
    {
        $roles = $this->roleRepository->getList([
            'limit'  => Constant::MAX_LIMIT,
            'getAll' => true,
            'ids'    => $roleIds,
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
            'limit'  => Constant::MAX_LIMIT,
            'getAll' => true,
            'ids'    => $permissionIds,
        ]);

        if ($permissions->isEmpty()) {
            return $this->result->failureResult(null, 'Không tìm thấy các quyền hạn tương ứng.');
        }

        return $this->baseRepository->syncPermissions($id, $permissions->all());
    }
}
