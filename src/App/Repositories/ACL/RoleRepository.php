<?php


namespace CuongDev\Larab\App\Repositories\ACL;


use CuongDev\Larab\Abstraction\Core\Repositories\ABaseRepository;
use CuongDev\Larab\Abstraction\Definition\Message;
use CuongDev\Larab\Abstraction\Object\Result;
use Exception;
use Spatie\Permission\Models\Role;

class RoleRepository extends ABaseRepository
{

    function model(): string
    {
        return Role::class;
    }

    /**
     * @param $id
     * @return Result
     */
    public function deleteRole($id): Result
    {
        $res = new Result();

        /** @var Role $model */
        $model = $this->model->find($id);

        if ($model) {
            try {
                $model->syncPermissions([]);

                $data = $model->delete();

                if ($data) {
                    $res = $res->successResult($data, Message::DELETE_SUCCESS);
                } else {
                    $res = $res->failureResult(null, Message::DELETE_FAILURE);
                }
            } catch (Exception $e) {
                $res = $res->failureResult(null, Message::DELETE_FAILURE . $e->getMessage());
            }
        } else {
            $res = $res->failureResult(null, Message::NOT_FOUND);
        }

        return $res;
    }

    /**
     * @param mixed $id role id
     * @param array $permissions list of permission model
     * @return Result
     */
    public function syncPermissions($id, array $permissions): Result
    {
        $res = new Result();

        if ($id) {
            /** @var Role $model */
            $model = $this->model->find($id);

            if ($model) {
                $role = $model->syncPermissions($permissions);
                $res = $res->successResult($role, 'Cấp quyền hạn cho vai trò thành công!');
            } else {
                $res = $res->failureResult(null, Message::NOT_FOUND);
            }
        } else {
            $res = $res->failureResult(null, Message::MISSING_PARAMS);
        }

        return $res;
    }
}
