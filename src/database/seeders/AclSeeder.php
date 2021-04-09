<?php

namespace CuongDev\Larab\Database\Seeders;

use App\Models\User;
use CuongDev\Larab\Abstraction\Definition\DefinePermission;
use CuongDev\Larab\Abstraction\Definition\DefineRole;
use CuongDev\Larab\Abstraction\Definition\StatusCode;
use CuongDev\Larab\App\Models\PermissionGroup;
use CuongDev\Larab\App\Models\SystemOption;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AclSeeder extends Seeder
{
    /** @var DefineRole $defineRole */
    protected $defineRole;

    /** @var DefinePermission $definePermission */
    protected $definePermission;

    public function __construct()
    {
        $this->defineRole = new DefineRole();
        $this->definePermission = new DefinePermission();
    }

    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        $tableNames = config('permission.table_names');

        if (empty($tableNames)) {
            throw new Exception('Error: config/permission.php not loaded. Run [php artisan config:clear] and try again.');
        }

        // <editor-fold defaultstate="collapsed" desc="Delete ACL table">
        $checkRun = SystemOption::where('meta_key', 'init_administrator_and_acl_seeder')->first();
        if (!$checkRun || $checkRun->meta_value != StatusCode::SUCCESS) {
            DB::table($tableNames['model_has_permissions'])->delete();
            DB::table($tableNames['model_has_roles'])->delete();
            DB::table($tableNames['role_has_permissions'])->delete();
            DB::table($tableNames['roles'])->delete();
            DB::table($tableNames['permissions'])->delete();
            DB::table('permission_groups')->delete();
        }
        // </editor-fold>

        // <editor-fold defaultstate="collapsed" desc="Role">
        $roles = $this->defineRole->getRoles();

        foreach ($roles as $name => $displayName) {
            Role::updateOrCreate(
                [
                    'name' => $name,
                ],
                [
                    'display_name' => $displayName
                ]
            );
        }
        // </editor-fold>

        // <editor-fold defaultstate="collapsed" desc="Permission Group">
        $permissionGroups = $this->definePermission->getPermissionGroups();

        $syncPermissionGroups = [];
        foreach ($permissionGroups as $name => $displayName) {
            $permissionGroup = PermissionGroup::updateOrCreate(
                [
                    'name' => $name,
                ],
                [
                    'display_name' => $displayName
                ]
            );

            $syncPermissionGroups[$name] = $permissionGroup;
        }
        // </editor-fold>

        // <editor-fold defaultstate="collapsed" desc="Permission">
        $permissions = $this->definePermission->getPermissions();

        $syncPermissions = [];
        foreach ($permissions as $name => $displayName) {
            $groupName = strtok($name, '__');

            if ($groupName && isset($syncPermissionGroups[$groupName])) {
                $permissionGroup = $syncPermissionGroups[$groupName];
                $permissionGroupId = $permissionGroup['id'];
            } elseif (isset($syncPermissionGroups[DefinePermission::PERMISSION_GROUP_OTHER])) {
                $permissionGroup = $syncPermissionGroups[DefinePermission::PERMISSION_GROUP_OTHER];
                $permissionGroupId = $permissionGroup['id'];
            } else {
                $permissionGroupId = null;
            }

            $permission = Permission::updateOrCreate(
                [
                    'name' => $name,
                ],
                [
                    'display_name'        => $displayName,
                    'permission_group_id' => $permissionGroupId,
                ]
            );

            $syncPermissions[] = $permission;
        }
        // </editor-fold>

        // Assign all permission to role Super Administrator
        $roleSuperAdmin = Role::where('name', DefineRole::SUPER_ADMINISTRATOR)->first();
        if ($roleSuperAdmin) {
            $roleSuperAdmin->syncPermissions($syncPermissions);
        }

        // Assign Super Administrator role and direct permissions to super admin user
        $email = env('SUPER_ADMIN_EMAIL', 'cuongnv.developer@gmail.com');
        /** @var User $user */
        $user = User::where('email', $email)->first();
        if ($user) {
            $user->syncRoles($roleSuperAdmin);
            $user->syncPermissions($syncPermissions);
        }
    }
}
