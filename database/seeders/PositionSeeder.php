<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\PositionEnums as Positions;
use App\Models\Position;
use Illuminate\Database\Seeder;
use ReflectionClass;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get all positions
        $positionConstant = collect((new ReflectionClass(Positions::class))->getConstants());

        // Create positions
        $positions = $positionConstant->map(function ($position) {
            return Position::factory()->make(['name' => $position]);
        });

        // Insert positions
        Position::insert($positions->toArray());
    }
}
