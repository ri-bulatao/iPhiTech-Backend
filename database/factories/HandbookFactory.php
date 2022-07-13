<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class HandbookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'version_name' => $this->faker->name,
            'pdf' => '/handbook' . '/' . Str::random(16),
            'path' => '/handbook' . '/' . Str::random(16),
        ];
    }
}
