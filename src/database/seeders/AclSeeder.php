<?php

namespace CuongDev\Larab\Database\Seeders;

use App\Models\User;
use CuongDev\Larab\Abstraction\Definition\DefinePermission;
use CuongDev\Larab\Abstraction\Definition\DefineRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AclSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws \Exception
     */
    public function run()
    {
        $tableNames = config('permission.table_names');

        if (empty($tableNames)) {
            throw new \Exception('Error: config/permission.php not loaded. Run [php artisan config:clear] and try again.');
        }

        // <editor-fold defaultstate="collapsed" desc="Delete ACL table">
        DB::table($tableNames['model_has_permissions'])->delete();
        DB::table($tableNames['model_has_roles'])->delete();
        DB::table($tableNames['role_has_permissions'])->delete();
        DB::table($tableNames['roles'])->delete();
        DB::table($tableNames['permissions'])->delete();
        // </editor-fold>

        // <editor-fold defaultstate="collapsed" desc="Role">
        $roles = (new DefineRole())->getRoles();

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

        // <editor-fold defaultstate="collapsed" desc="Permission">
        $permissions = (new DefinePermission())->getPermissions();

        $syncPermissions = [];
        foreach ($permissions as $name => $displayName) {
            $permission = Permission::updateOrCreate(
                [
                    'name' => $name,
                ],
                [
                    'display_name' => $displayName
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
