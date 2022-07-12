<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    /** @test */
    public function can_create_user()
    {
        // $user = User::factory()->create()->first();
        // $this->be($user);

        $data = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'johndoe@test.app',
            'new_password' => bcrypt('Testing123')
        ];

        $this->withHeaders(['Accept' => 'application/json'])
            ->post(route('admin_user.store'), $data)
            ->assertStatus(201);
    }
}
