<?php


namespace CuongDev\Larab\App\Repositories\ACL;


use CuongDev\Larab\Abstraction\Core\Repositories\ABaseRepository;
use Spatie\Permission\Models\Permission;

class PermissionRepository extends ABaseRepository
{

    function model(): string
    {
        return Permission::class;
    }
}
