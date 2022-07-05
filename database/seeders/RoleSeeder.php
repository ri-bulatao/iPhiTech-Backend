<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Generate Admin Role
         */
        $admin = Role::where('name', 'admin')->first();

        if( ! $admin )
        {
            DB::table('roles')->insert([
                'name'      => 'admin'
            ]);
        }

        /**
         * Generate Employee Role
         */
        $employee = Role::where('name', 'employee')->first();
        
        if( ! $employee )
        {
            DB::table('roles')->insert([
                'name'      => 'employee'
            ]);
        }
    }
}
