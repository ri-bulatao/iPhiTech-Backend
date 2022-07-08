<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Seeder;

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
        $positions = ['Developers', 'Graphics', 'Marketing', 'Project Leads', 'Managers'];

        foreach( $positions as $position ) {
            Position::factory()->create([
                'name'  => $position
            ]);
        }
    }
}
