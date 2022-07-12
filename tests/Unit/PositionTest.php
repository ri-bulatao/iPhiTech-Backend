<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\Position;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

class PositionTest extends TestCase
{
    use RefreshDatabase;

    public function get_user()
    {
        $user = User::factory()->create()->first();
        $this->be($user);

        return $user;
    }

    public function give_permission($user, $permission)
    {
        $permission = Permission::create(['name' => $permission]);

        return $user->givePermissionTo($permission);
    }

    public function get_data()
    {
        return [
            'name' => 'Test Position',
        ];
    }

    /** @test */
    public function can_add_position()
    {
        $user = $this->get_user();

        $user = $this->give_permission($user, 'position_create');

        $this->withHeaders(['Accept' => 'application/json'])
            ->post(route('position.store'), $this->get_data())
            ->assertStatus(201);
    }

    /** @test */
    public function can_not_add_position_if_invalid_permission()
    {
        $user = $this->get_user();

        $user = $this->give_permission($user, 'invalid');

        $this->withHeaders(['Accept' => 'application/json'])
            ->post(route('position.store'), $this->get_data())
            ->assertStatus(403);
    }

    /** @test */
    public function can_not_add_position_if_not_authorized()
    {
        $this->withHeaders(['Accept' => 'application/json'])
            ->post(route('position.store'), $this->get_data())
            ->assertStatus(401);
    }

    /** @test */
    public function can_get_positions()
    {
        $user = $this->get_user();
        $user = $this->give_permission($user, 'position_show');

        $this->withHeaders(['Accept' => 'application/json'])
            ->get(route('position.list'))
            ->assertStatus(200);
    }

    /** @test */
    public function can_not_get_positions_if_not_authorized()
    {
        $this->withHeaders(['Accept' => 'application/json'])
            ->get(route('position.list'))
            ->assertStatus(401);
    }

    /** @test */
    public function can_not_get_positions_if_no_permission()
    {
        $user = $this->get_user();
        $user = $this->give_permission($user, 'invalid');

        $this->withHeaders(['Accept' => 'application/json'])
            ->get(route('position.list'))
            ->assertStatus(403);
    }

    /** @test */
    public function can_get_position()
    {
        $user = $this->get_user();
        $user = $this->give_permission($user, 'position_show');

        $created = Position::factory()->create()->first();

        $this->withHeaders(['Accept' => 'application/json'])
            ->get(route('position.single', ['id' => $created->id]))
            ->assertStatus(200);
    }

    /** @test */
    public function can_not_get_position_if_not_autorized()
    {
        $created = Position::factory()->create()->first();

        $this->withHeaders(['Accept' => 'application/json'])
            ->get(route('position.single', ['id' => $created->id]))
            ->assertStatus(401);
    }

    /** @test */
    public function can_not_get_permission_if_no_permission()
    {
        $user = $this->get_user();
        $created = Position::factory()->create()->first();

        $this->withHeaders(['Accept' => 'application/json'])
            ->get(route('position.single', ['id' => $created->id]))
            ->assertStatus(403);
    }

    /** @test */
    public function can_update_position()
    {
        $user = $this->get_user();
        $user = $this->give_permission($user, 'position_edit');

        $created = Position::factory()->create()->first();

        $this->withHeaders(['Accept' => 'application/json'])
            ->put(route('position.update', ['id' => $created->id]), $this->get_data())
            ->assertStatus(200);
    }

    /** @test */
    public function can_not_update_position_if_not_authorized()
    {
        $created = Position::factory()->create()->first();

        $this->withHeaders(['Accept' => 'application/json'])
            ->put(route('position.update', ['id' => $created->id]), $this->get_data())
            ->assertStatus(401);
    }

    /** @test */
    public function can_not_update_position_if_not_permitted()
    {
        $user = $this->get_user();
        $created = Position::factory()->create()->first();

        $this->withHeaders(['Accept' => 'application/json'])
            ->put(route('position.update', ['id' => $created->id]), $this->get_data())
            ->assertStatus(403);
    }

    /** @test */
    public function can_not_update_position_if_not_found()
    {
        $user = $this->get_user();
        $user = $this->give_permission($user, 'position_edit');

        $this->withHeaders(['Accept' => 'application/json'])
            ->put(route('position.update', ['id' => '12345678912345678']), $this->get_data())
            ->assertStatus(404);
    }

    /** @test */
    public function can_delete_position()
    {
        $user = $this->get_user();
        $user = $this->give_permission($user, 'position_delete');
        $created = Position::factory()->create()->first();

        $this->withHeaders(['Accept' => 'application/json'])
            ->delete(route('position.delete', ['id' => $created->id]))
            ->assertStatus(200);
    }

    /** @test */
    public function can_not_delete_position_if_not_found()
    {
        $user = $this->get_user();
        $user = $this->give_permission($user, 'position_delete');

        $this->withHeaders(['Accept' => 'application/json'])
            ->delete(route('position.delete', ['id' => '12345678912345678']))
            ->assertStatus(404);
    }

    /** @test */
    public function can_not_delete_position_if_not_authorized()
    {
        $created = Position::factory()->create()->first();

        $this->withHeaders(['Accept' => 'application/json'])
            ->delete(route('position.delete', ['id' => $created->id]))
            ->assertStatus(401);
    }

    public function can_not_delete_position_if_not_permitted()
    {
        $user = $this->get_user();
        $user = $this->give_permission($user, 'invalid');

        $created = Position::factory()->create()->first();

        $this->withHeaders(['Accept' => 'application/json'])
            ->delete(route('position.delete', ['id' => $created->id]))
            ->assertStatus(403);
    }
}
