<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Enums\RoleEnums as Roles;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function create_roles()
    {
        Role::create([
            'name' => Roles::EMPLOYEE,
        ]);

        Role::create([
            'name' => Roles::ADMINISTRATOR,
        ]);
    }

    /** @test */
    public function can_create_user()
    {
        $this->create_roles();

        $user = User::factory()->create()->first();
        $this->be($user);

        $data = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'johndoe@test.app',
            'new_password' => 'Testing123',
        ];

        $this->withHeaders(['Accept' => 'application/json'])
            ->post(route('admin_user.store'), $data)
            ->assertStatus(201);
    }

    /** @test */
    public function can_not_create_without_authentication()
    {
        $data = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'johndoe@test.app',
            'new_password' => 'Testing123',
        ];

        $this->withHeaders(['Accept' => 'application/json'])
            ->post(route('admin_user.store'), $data)
            ->assertStatus(401);
    }

    /** @test */
    public function can_not_create_without_required_fields()
    {
        $user = User::factory()->create()->first();
        $this->be($user);

        $data = [];

        $this->withHeaders(['Accept' => 'application/json'])
            ->post(route('admin_user.store'), $data)
            ->assertStatus(422);
    }

    /** @test */
    public function can_get_user_list()
    {
        $user = User::factory()->create()->first();
        $this->be($user);

        $this->withHeaders(['Accept' => 'application/json'])
            ->get(route('admin_user.list'))
            ->assertStatus(200);
    }

    /** @test */
    public function can_not_get_user_list_if_not_authenticated()
    {
        $this->withHeaders(['Accept' => 'application/json'])
            ->get(route('admin_user.list'))
            ->assertStatus(401);
    }

    /** @test */
    public function can_get_single_user()
    {
        $user = User::factory()->create()->first();
        $this->be($user);

        $created = User::factory()->create()->first();

        $this->withHeaders(['Accept' => 'application/json'])
            ->get(route('admin_user.single', ['id' => $created->id]))
            ->assertStatus(200);
    }

    /** @test */
    public function can_not_get_single_user_if_not_authenticated()
    {
        $created = User::factory()->create()->first();

        $this->withHeaders(['Accept' => 'application/json'])
            ->get(route('admin_user.single', ['id' => $created->id]))
            ->assertStatus(401);
    }

    /** @test */
    public function can_update_user()
    {
        $user = User::factory()->create()->first();
        $this->be($user);

        $created = User::factory()->create()->first();

        $data = [
            'first_name' => 'JohnE',
            'last_name' => 'DoeE',
            'email' => 'johndoe@test.app',
        ];

        $this->withHeaders(['Accept' => 'application/json'])
            ->put(route('admin_user.update', ['id' => $created->id]), $data)
            ->assertStatus(200);
    }

    /** @test */
    public function can_not_update_if_not_authorized()
    {
        $created = User::factory()->create()->first();

        $data = [
            'first_name' => 'JohnE',
            'last_name' => 'DoeE',
            'email' => 'johndoe@test.app',
        ];

        $this->withHeaders(['Accept' => 'application/json'])
            ->put(route('admin_user.update', ['id' => $created->id]), $data)
            ->assertStatus(401);
    }

    /** @test */
    public function can_not_update_if_not_found()
    {
        $user = User::factory()->create()->first();
        $this->be($user);

        $created = User::factory()->create()->first();

        $data = [
            'first_name' => 'JohnE',
            'last_name' => 'DoeE',
            'email' => 'johndoe@test.app',
        ];

        $this->withHeaders(['Accept' => 'application/json'])
            ->put(route('admin_user.update', ['id' => '1234567891234567']), $data)
            ->assertStatus(404);
    }

    /** @test */
    public function can_delete_user()
    {
        $user = User::factory()->create()->first();
        $this->be($user);

        $created = User::factory()->create()->first();

        $this->withHeaders(['Accept' => 'application/json'])
            ->delete(route('admin_user.delete', ['id' => $created->id]))
            ->assertStatus(200);
    }

    /** @test */
    public function can_not_delete_if_not_authorized()
    {
        $created = User::factory()->create()->first();

        $this->withHeaders(['Accept' => 'application/json'])
            ->delete(route('admin_user.delete', ['id' => $created->id]))
            ->assertStatus(401);
    }

    public function can_not_delete_if_not_found()
    {
        $user = User::factory()->create()->first();
        $this->be($user);

        $created = User::factory()->create()->first();

        $this->withHeaders(['Accept' => 'application/json'])
            ->delete(route('admin_user.delete', ['id' => '1234567891234567']))
            ->assertStatus(404);
    }
}
