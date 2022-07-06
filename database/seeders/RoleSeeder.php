<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\RoleEnums as Roles;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use ReflectionClass;


class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        # Get All Roles
        $roleConstants = collect((new ReflectionClass(Roles::class))->getConstants());

        # Create Roles
        $roles = $roleConstants->map(function ($role) {
            return Role::factory()->make(['name' => $role]);
        });

        # Insert Roles
        Role::insert($roles->toArray());
    }
}
