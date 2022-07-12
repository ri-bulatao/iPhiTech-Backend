<?php

declare(strict_types=1);

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AnnouncementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->text,
            'excerpt' => $this->faker->text,
            'content' => $this->faker->text,
            'receiver' => '1',
            'status' => 'pending',
        ];
    }
}
