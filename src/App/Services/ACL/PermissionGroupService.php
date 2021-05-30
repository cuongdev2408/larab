<?php


namespace CuongDev\Larab\App\Services\ACL;


use CuongDev\Larab\Abstraction\Core\Services\ABaseService;
use CuongDev\Larab\Abstraction\Object\Result;
use CuongDev\Larab\App\Repositories\ACL\PermissionGroupRepository;

class PermissionGroupService extends ABaseService
{
    /** @var PermissionGroupRepository $baseRepository */
    protected $baseRepository;

    public function __construct(PermissionGroupRepository $permissionGroupRepository)
    {
        parent::__construct();
        $this->baseRepository = $permissionGroupRepository;

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
        return $this->baseRepository->deletePermissionGroup($id);
    }

    /**
     * @param array $params
     * @return array
     */
    protected function extendProcessParams(array $params = []): array
    {
        $processedParams = [];

        if (isset($params['permissions']) && !is_array($params['permissions']) && is_string($params['permissions'])) {
            $processedParams['permissions'] = array_map('trim', explode(',', $params['permissions']));
        }

        return $processedParams;
    }
}
