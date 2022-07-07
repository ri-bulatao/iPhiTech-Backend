<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            PositionSeeder::class,
            PositionSeeder::class,
            PermissionSeeder::class,
            AdminPermissionSeeder::class,
        ]);
    }
}
