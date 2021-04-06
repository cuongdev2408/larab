<?php

namespace CuongDev\Larab\App\Http\Controllers\Api\ACL;

use CuongDev\Larab\Abstraction\Core\Controllers\AApiCrudController;
use CuongDev\Larab\App\Services\ACL\PermissionGroupService ;

class PermissionGroupController extends AApiCrudController
{

    public function __construct(PermissionGroupService $permissionGroupService)
    {
        parent::__construct();
        $this->baseService = $permissionGroupService;
    }
}
