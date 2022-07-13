<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_register()
    {
        $user = [
            'first_name' => 'Test Firstname',
            'middle_name' => 'Test Middlename',
            'last_name' => 'Test lastname',
            'email' => 'test@test.app',
            'password' => 'secret',
            'password_confirmation' => 'secret',
        ];

        $this->withHeaders(['Accept' => 'application/json'])
            ->post(route('register'), $user)
            ->assertStatus(200);
    }

    /** @test */
    public function can_not_register_with_existing_email()
    {
        User::factory()->create(['email' => 'test@test.app']);

        $user = [
            'first_name' => 'Test Firstname',
            'middle_name' => 'Test Middlename',
            'last_name' => 'test@test.app',
            'email' => 'awesome@email.com',
            'password' => 'secret',
            'password_confirmation' => 'secret',
        ];

        $this->withHeaders(['Accept' => 'application/json'])
            ->post(route('register'), $user)
            ->assertStatus(200);
    }
}
