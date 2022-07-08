<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Position;
use App\Enums\PositionEnums as Positions;
use Illuminate\Database\Eloquent\Factories\Factory;

class PositionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Position::class;

    /**
     * Define the model's default state.
     *
     * @return string[]
     */
    public function definition()
    {
        return [
            'name' => Positions::DEVELOPER
        ];
    }

    public function developer()
    {
        return $this->state(function() {
            return ['name'  => Positions::DEVELOPER];
        });
    }

    public function graphics()
    {
        return $this->state(function() {
            return ['name'  => Positions::GRAPHICS];
        });
    }

    public function marketing()
    {
        return $this->state(function() {
            return ['name'  => Positions::MARKETING];
        });
    }

    public function project_lead()
    {
        return $this->state(function() {
            return ['name'  => Positions::PROJECT_LEAD];
        });
    }

    public function manager()
    {
        return $this->state(function() {
            return ['name'  => Positions::MANAGER];
        });
    }
}
