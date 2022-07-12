<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Auth;
use Mockery;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_not_login_without_required_fields()
    {
        $formData = [
            'email' => '',
            'password'  => ''
        ];

        $this->withHeaders(['Accept' => 'application/json'])
            ->post(route('login'), $formData)
            ->assertStatus(422)
            ->assertJson([
                'message'   => 'The given data was invalid.',
                'errors'    => [
                    'email' => ['The email field is required.'],
                    'password' => ['The password field is required.']
                ]
            ]);
    }

    /** @test */
    public function can_not_login_with_invalid_credentials()
    {
        $user = [
            'email' => 'test@invalid.com',
            'password'  => '123'
        ];

        $this->withHeaders(['Accept' => 'application/json'])
            ->post(route('login'), $user)
            ->assertStatus(422);
    }

    /** @test */
    public function can_login()
    {
        $user = User::factory()->create()->first();

        $this->be($user);

        Auth::shouldReceive('user')->andReturn($user = Mockery::mock('StdClass'));

    }
}
