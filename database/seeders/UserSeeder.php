<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\RoleEnums as Roles;
use App\Models\User;
use Illuminate\Database\Seeder;

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
            'first_name'       => 'Awesome',
            'middle_name'       => '',
            'last_name'       => 'Admin',
            'email'      => 'awesome@email.com',
            'password'   =>  bcrypt('admin12345678'),
        ]);

        $admin->assignRole(Roles::ADMINISTRATOR);

        /**
         * Generate sample employee account.
         */
        $employee = User::factory()->create([
            'first_name'       => 'Awesome',
            'middle_name'       => '',
            'last_name'       => 'Employee',
            'email'      => 'employee@email.com',
            'password'   =>  bcrypt('employee12345678'),
        ]);

        $employee->assignRole(Roles::EMPLOYEE);
    }
}
