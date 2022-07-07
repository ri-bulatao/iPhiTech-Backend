<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Enums\RoleEnums as Roles;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // create permissions
        $permissions = [
            'position_create',
            'position_edit',
            'position_show',
            'position_delete',
            'position_access',
        ];

        foreach ($permissions as $permission) {
            Permission::create([
                'name'  => $permission
            ]);
        }

        // get all permissions via Gate::before rule; see AuthServiceProvider

        $role = Role::findByName(Roles::EMPLOYEE);

        $userPermissions = [
            'position_access',
            'position_show',
        ];

        foreach ($userPermissions as $permission) {
            $role->givePermissionTo($permission);
        }
    }
}
