<?php


namespace CuongDev\Larab\App\Repositories\ACL;


use CuongDev\Larab\Abstraction\Core\Repositories\ABaseRepository;
use CuongDev\Larab\Abstraction\Definition\DefinePermission;
use CuongDev\Larab\Abstraction\Definition\Message;
use CuongDev\Larab\Abstraction\Object\Result;
use CuongDev\Larab\App\Models\PermissionGroup;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class PermissionGroupRepository extends ABaseRepository
{

    function model(): string
    {
        return PermissionGroup::class;
    }


    /**
     * @param $id
     * @return Result
     */
    public function deletePermissionGroup($id): Result
    {
        $res = new Result();

        /** @var PermissionGroup $model */
        $model = $this->model->find($id);

        if ($model) {
            DB::beginTransaction();
            try {
                /** @var PermissionRepository $permissionRepository */
                $permissionRepository = app(PermissionRepository::class);
                $permissionRepository->getModel()->where('permission_group_id', $id)->update([
                    'permission_group_id' => DefinePermission::PERMISSION_GROUP_OTHER
                ]);

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
