<?php


namespace CuongDev\Larab\App\Repositories\ACL;


use CuongDev\Larab\Abstraction\Core\Repositories\ABaseRepository;
use CuongDev\Larab\Abstraction\Definition\Message;
use CuongDev\Larab\Abstraction\Object\Result;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Contracts\Permission;
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
            DB::beginTransaction();
            try {
                $model->syncPermissions([]);

                $data = $model->delete();

                if ($data) {
                    $res = $res->successResult($data, Message::DELETE_SUCCESS);
                } else {
                    $res = $res->failureResult(null, Message::DELETE_FAILURE);
                }

                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();
                $res = $res->failureResult(null, Message::DELETE_FAILURE . $e->getMessage());
            }
        } else {
            $res = $res->failureResult(null, Message::NOT_FOUND);
        }

        return $res;
    }

    /**
     * @param mixed $id role id
     * @param string|array|Permission|Collection $permissions list of permission model
     * @return Result
     */
    public function syncPermissions($id, $permissions): Result
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

    /**
     * @param Builder $model
     * @param array $params
     * @return Builder
     */
    protected function extendGetList(Builder $model, array $params = []): Builder
    {
        if (isset($params['permissions']) && is_array($params['permissions'])) {
            $model = $model->whereHas('permissions', function ($query) use ($params) {
                $query->whereIn('id', $params['permissions']);
            });
        }

        return $model;
    }
}
