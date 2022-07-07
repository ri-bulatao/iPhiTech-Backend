<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PositionSeeder extends Seeder
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
        $admin = Position::where('name', 'Admin')->first();
        if (! $admin) {
            DB::table('positions')->insert([
                'name'      => 'Admin',
            ]);
        }

        // Manager
        $manager = Position::where('name', 'Manager')->first();
        if (! $manager) {
            DB::table('positions')->insert([
                'name'      => 'Manager',
            ]);
        }

        // Project Lead
        $lead = Position::where('name', 'Project Lead')->first();
        if (! $lead) {
            DB::table('positions')->insert([
                'name'      => 'Project Lead',
            ]);
        }

        // Employee
        $employee = Position::where('name', 'Employee')->first();
        if (! $employee) {
            DB::table('positions')->insert([
                'name'      => 'Employee',
            ]);
        }
    }
}
