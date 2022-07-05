<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Role;
use App\Models\User;

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
         * Generate Admin user
         */
        $admin = Role::where('name', 'admin')->first();
        
        if( $admin )
        {
            $admin_user = User::where('email', 'awesome@email.com')->first();

            if( ! $admin_user )
            {
                DB::table('users')->insert([
                    'name'      => 'Awesome Admin',
                    'email'     => 'awesome@email.com',
                    'password'  => bcrypt('admin12345678'),
                    'user_role' => $admin->id
                ]);
            }
        }

        /**
         * Generate sample employee account
         */
        $employee = Role::where('name', 'employee')->first();
        
        if( $employee )
        {
            $employee_user = User::where('email', 'employee@email.com')->first();

            if( ! $employee_user )
            {
                DB::table('users')->insert([
                    'name'      => 'Awsome Employee',
                    'email'     => 'employee@email.com',
                    'password'  => bcrypt('employee12345678'),
                    'user_role' => $employee->id
                ]);
            }

        }
    }
}
