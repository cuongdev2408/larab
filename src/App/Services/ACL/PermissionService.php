<?php


namespace CuongDev\Larab\App\Services\ACL;


use CuongDev\Larab\Abstraction\Core\Services\ABaseService;
use CuongDev\Larab\App\Repositories\ACL\PermissionRepository;

class PermissionService extends ABaseService
{

    public function __construct(PermissionRepository $permissionRepository)
    {
        parent::__construct();
        $this->baseRepository = $permissionRepository;

        $this->baseRepository->setComparableFields([
            'name',
        ]);

        $this->baseRepository->setSearchableFields([
            'name',
            'display_name',
        ]);
    }
}
