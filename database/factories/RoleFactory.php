<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\RoleEnums as Roles;
use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Role::class;

    /**
     * @return string[]
     */
    public function definition(): array
    {
        return [
            'name' => Roles::EMPLOYEE,
            'guard_name' => 'api',

        ];
    }

    public function administrator()
    {
        return $this->state(function () {
            return ['name' => Roles::ADMINISTRATOR];
        });
    }

    public function employee()
    {
        return $this->state(function () {
            return ['name' => Roles::EMPLOYEE];
        });
    }
}
