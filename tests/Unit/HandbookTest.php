<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\Handbook;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class HandbookTest extends TestCase
{
    use RefreshDatabase;

    public function get_user()
    {
        $user = User::factory()->create()->first();
        $this->be($user);

        return $user;
    }

    public function get_data()
    {
        $file = UploadedFile::fake()->image('File10.png');

        return [
            'version_name' => 'Test Position',
            'pdf' => 'https://testing.com',
            'path' => '/testing',
            'book' => $file,
        ];
    }

    /** @test */
    public function can_get_handbooks()
    {
        $this->get_user();

        $this->withHeaders(['Accept' => 'application/json'])
            ->get(route('handbook.all'))
            ->assertStatus(200);
    }

    /** @test */
    public function can_not_get_handbooks_if_not_authorized()
    {
        $this->withHeaders(['Accept' => 'application/json'])
            ->get(route('handbook.all'))
            ->assertStatus(401);
    }

    /** @test */
    public function can_get_handbook()
    {
        $this->get_user();

        $created = Handbook::factory()->create()->first();

        $this->withHeaders(['Accept' => 'application/json'])
            ->get(route('handbook.show', ['id' => $created->id]))
            ->assertStatus(200);
    }

    /** @test */
    public function can_not_get_handbook_if_not_authorized()
    {
        $created = Handbook::factory()->create()->first();

        $this->withHeaders(['Accept' => 'application/json'])
            ->get(route('handbook.show', ['id' => $created->id]))
            ->assertStatus(401);
    }

    /** @test */
    public function can_not_get_handbook_if_not_found()
    {
        $this->get_user();

        $this->withHeaders(['Accept' => 'application/json'])
            ->get(route('handbook.show', ['id' => '12345612321312321']))
            ->assertStatus(404);
    }

    /** @test */
    public function can_add_handbook()
    {
        $this->get_user();

        $this->withHeaders(['Accept' => 'application/json'])
            ->post(route('handbook.store'), $this->get_data())
            ->assertStatus(201);
    }

    /** @test */
    public function can_not_add_handbook_if_not_authorized()
    {
        $this->withHeaders(['Accept' => 'application/json'])
            ->post(route('handbook.store'), $this->get_data())
            ->assertStatus(401);
    }

    /** @test */
    public function can_update_handbook()
    {
        $this->get_user();

        $created = Handbook::factory()->create()->first();

        $this->withHeaders(['Accept' => 'application/json'])
            ->put(route('handbook.update', ['id' => $created->id]), $this->get_data())
            ->assertStatus(200);
    }

    /** @test */
    public function can_not_update_handbook_if_not_authorized()
    {
        $created = Handbook::factory()->create()->first();

        $this->withHeaders(['Accept' => 'application/json'])
            ->put(route('handbook.update', ['id' => $created->id]), $this->get_data())
            ->assertStatus(401);
    }

    /** @test */
    public function can_not_update_handbook_if_not_found()
    {
        $this->get_user();

        $created = Handbook::factory()->create()->first();

        $this->withHeaders(['Accept' => 'application/json'])
            ->put(route('handbook.update', ['id' => '12345612321312321']), $this->get_data())
            ->assertStatus(404);
    }

    /** @test */
    public function can_delete_handbook()
    {
        $this->get_user();

        $created = Handbook::factory()->create()->first();

        $this->withHeaders(['Accept' => 'application/json'])
            ->delete(route('handbook.delete', ['id' => $created->id]))
            ->assertStatus(200);
    }

    /** @test */
    public function can_not_delete_handbook_if_not_authorized()
    {
        $created = Handbook::factory()->create()->first();

        $this->withHeaders(['Accept' => 'application/json'])
            ->delete(route('handbook.delete', ['id' => $created->id]))
            ->assertStatus(401);
    }

    /** @test */
    public function can_not_delete_handbook_if_not_found()
    {
        $this->get_user();

        $this->withHeaders(['Accept' => 'application/json'])
            ->delete(route('handbook.delete', ['id' => '12345612321312321']))
            ->assertStatus(404);
    }
}
