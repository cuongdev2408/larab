<?php


namespace CuongDev\Larab\App\Http\Controllers\Api\ACL;


use CuongDev\Larab\Abstraction\Core\Controllers\AApiCrudController;
use CuongDev\Larab\App\Services\ACL\PermissionService;

class PermissionController extends AApiCrudController
{

    public function __construct(PermissionService $permissionService)
    {
        parent::__construct();
        $this->baseService = $permissionService;
    }
}
