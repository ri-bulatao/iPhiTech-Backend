<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\RoleEnums as Roles;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Generate Admin user.
         */
        $admin = User::factory()->create([
            'name'       => 'Awesome Admin',
            'email'      => 'awesome@email.com',
            'password'   =>  bcrypt('admin12345678')
        ]);

        $admin->assignRole(Roles::ADMINISTRATOR);

        /**
         * Generate sample employee account.
         */
        $employee = User::factory()->create([
            'name'       => 'Awesome Employee',
            'email'      => 'employee@email.com',
            'password'   =>  bcrypt('employee12345678'),
        ]);

        $employee->assignRole(Roles::EMPLOYEE);
    }
}
