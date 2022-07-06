<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\UserPosition;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserPositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /**
         * Generate User Positions.
         */

        // Admin
        $admin = UserPosition::where('name', 'Admin')->first();
        if (! $admin) {
            DB::table('user_positions')->insert([
                'name'      => 'Admin',
            ]);
        }

        // Manager
        $manager = UserPosition::where('name', 'Manager')->first();
        if (! $manager) {
            DB::table('user_positions')->insert([
                'name'      => 'Manager',
            ]);
        }

        // Project Lead
        $lead = UserPosition::where('name', 'Project Lead')->first();
        if (! $lead) {
            DB::table('user_positions')->insert([
                'name'      => 'Project Lead',
            ]);
        }

        // Employee
        $employee = UserPosition::where('name', 'Employee')->first();
        if (! $employee) {
            DB::table('user_positions')->insert([
                'name'      => 'Employee',
            ]);
        }
    }
}
