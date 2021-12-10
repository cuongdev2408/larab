<?php


namespace CuongDev\Larab\App\Repositories;


use App\Models\User;
use CuongDev\Larab\Abstraction\Core\Repositories\ABaseRepository;
use CuongDev\Larab\Abstraction\Definition\Message;
use CuongDev\Larab\Abstraction\Object\Result;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Spatie\Permission\Contracts\Permission;
use Spatie\Permission\Contracts\Role;

class UserRepository extends ABaseRepository
{

    function model(): string
    {
        return User::class;
    }

    /**
     * @param mixed $id user id
     * @param array|Role|string $roles list of role model
     * @return Result
     */
    public function syncRoles($id, $roles): Result
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
     * @param string|array|Permission|Collection $permissions list of permission model
     * @return Result
     */
    public function syncPermissions($id, $permissions): Result
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

    /**
     * @param $model
     * @param array $params
     * @return Builder
     */
    protected function extendGetList($model, array $params = []): Builder
    {
        if (isset($params['roles']) && is_array($params['roles'])) {
            $model = $model->whereHas('roles', function ($query) use ($params) {
                $query->whereIn('id', $params['roles']);
            });
        }

        if (isset($params['permissions']) && is_array($params['permissions'])) {
            $model = $model->whereHas('permissions', function ($query) use ($params) {
                $query->whereIn('id', $params['permissions']);
            });
        }

        return $model;
    }
}
