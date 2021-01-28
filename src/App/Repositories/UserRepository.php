<?php


namespace CuongDev\Larab\App\Repositories;


use App\Models\User;
use CuongDev\Larab\Abstraction\Core\Repositories\ABaseRepository;
use CuongDev\Larab\Abstraction\Definition\Message;
use CuongDev\Larab\Abstraction\Object\Result;

class UserRepository extends ABaseRepository
{

    function model(): string
    {
        return User::class;
    }

    /**
     * @param mixed $id user id
     * @param array $roles list of role model
     * @return Result
     */
    public function syncRoles($id, array $roles): Result
    {
        $res = new Result();

        if ($id) {
            /** @var User $model */
            $model = $this->model->find($id);

            if ($model) {
                $role = $model->syncRoles($roles);
                $res = $res->successResult($role, 'Cấp vai trò cho người dùng thành công!');
            } else {
                $res = $res->failureResult(null, Message::NOT_FOUND);
            }
        } else {
            $res = $res->failureResult(null, Message::MISSING_PARAMS);
        }

        return $res;
    }

    /**
     * @param mixed $id user id
     * @param array $permissions list of permission model
     * @return Result
     */
    public function syncPermissions($id, array $permissions): Result
    {
        $res = new Result();

        if ($id) {
            /** @var User $model */
            $model = $this->model->find($id);

            if ($model) {
                $role = $model->syncPermissions($permissions);
                $res = $res->successResult($role, 'Cấp quyền hạn cho người dùng thành công!');
            } else {
                $res = $res->failureResult(null, Message::NOT_FOUND);
            }
        } else {
            $res = $res->failureResult(null, Message::MISSING_PARAMS);
        }

        return $res;
    }
}
