<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\Announcement as AnnouncementModel;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AnnouncementTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_add_announcement()
    {
        $announcement = [
            'title' => 'Testing Announcement',
            'excerpt' => 'Testing Excerpt',
            'content' => 'Testing Content',
            'status' => 'pending',
            'receiver' => '1',
        ];

        $user = User::factory()->create()->first();
        $this->be($user);

        $this->withHeaders(['Accept' => 'application/json'])
            ->post(route('announcements.store'), $announcement)
            ->assertStatus(201);
    }

    /** @test */
    public function can_not_add_announcement_with_missing_fields()
    {
        $announcement = [
            'title' => '',
            'excerpt' => '',
            'content' => '',
            'status' => '',
            'receiver' => '',
        ];

        $user = User::factory()->create()->first();
        $this->be($user);

        $this->withHeaders(['Accept' => 'application/json'])
            ->post(route('announcements.store'), $announcement)
            ->assertStatus(422);
    }

    /** @test */
    public function can_fetch_announcements()
    {
        $user = User::factory()->create()->first();
        $this->be($user);

        $this->withHeaders(['Accept' => 'application/json'])
            ->get(route('announcements.list'))
            ->assertStatus(200);
    }

    /** @test */
    public function can_fetch_announcement()
    {
        $user = User::factory()->create()->first();
        $this->be($user);

        $announcement = AnnouncementModel::factory()->create()->first();

        $this->withHeaders(['Accept' => 'application/json'])
            ->get(route('announcements.single', ['id' => $announcement->id]))
            ->assertStatus(200);
    }

    /** @test */
    public function can_post_announcement()
    {
        $user = User::factory()->create()->first();
        $this->be($user);

        $data = AnnouncementModel::factory()->create()->first();

        $announcement = [
            'id' => $data->id,
            'title' => $data->title,
            'excerpt' => $data->excerpt,
            'content' => $data->content,
            'receiver' => $data->receiver,
            'status' => $data->status,
        ];

        $this->withHeaders(['Accept' => 'application/json'])
            ->put(route('announcements.post', ['id' => $data->id]), $announcement)
            ->assertStatus(200);
    }

    /** @test */
    public function can_not_post_announcement_with_status_posted()
    {
        $user = User::factory()->create()->first();
        $this->be($user);

        $data = AnnouncementModel::factory()->create([
            'status' => 'posted',
        ])->first();

        $announcement = [
            'id' => $data->id,
            'status' => 'Posted',
        ];

        $this->withHeaders(['Accept' => 'application/json'])
            ->put(route('announcements.post', ['id' => $data->id]), $announcement)
            ->assertStatus(422);
    }

    /** @test */
    public function can_not_post_announcement_not_found()
    {
        $user = User::factory()->create()->first();
        $this->be($user);

        $announcement = [
            'id' => '1234567891234567',
            'status' => 'posted',
        ];

        $this->withHeaders(['Accept' => 'application/json'])
            ->put(route('announcements.post', ['id' => '1234567891234567']), $announcement)
            ->assertStatus(404);
    }

    /** @test */
    public function can_update_announcement()
    {
        $user = User::factory()->create()->first();
        $this->be($user);

        $data = AnnouncementModel::factory()->create()->first();

        $announcement = [
            'id' => $data->id,
            'title' => 'Edited title',
            'excerpt' => 'edited excerpt',
            'content' => 'edited content',
            'status' => 'pending',
            'receiver' => '1',
        ];

        $this->withHeaders(['Accept' => 'application/json'])
            ->put(route('announcements.update', ['id' => $data->id]), $announcement)
            ->assertStatus(200);
    }

    /** @test */
    public function can_not_update_if_invalid_data()
    {
        $user = User::factory()->create()->first();
        $this->be($user);

        $data = AnnouncementModel::factory()->create()->first();

        $announcement = [
            'id' => $data->id,
            'title' => '',
            'excerpt' => '',
            'content' => '',
            'status' => '',
            'receiver' => '',
        ];

        $this->withHeaders(['Accept' => 'application/json'])
            ->put(route('announcements.update', ['id' => $data->id]), $announcement)
            ->assertStatus(422);
    }

    /** @test */
    public function can_not_update_if_not_found()
    {
        $user = User::factory()->create()->first();
        $this->be($user);

        $announcement = [
            'id' => '1234567891234567',
            'title' => 'Edited title',
            'excerpt' => 'edited excerpt',
            'content' => 'edited content',
            'status' => 'pending',
            'receiver' => '1',
        ];

        $this->withHeaders(['Accept' => 'application/json'])
            ->put(route('announcements.update', ['id' => '1234567891234567']), $announcement)
            ->assertStatus(404);
    }

    /** @test */
    public function can_delete_announcement()
    {
        $user = User::factory()->create()->first();
        $this->be($user);

        $data = AnnouncementModel::factory()->create()->first();

        $this->withHeaders(['Accept' => 'application/json'])
            ->delete(route('announcements.delete', ['id' => $data->id]))
            ->assertStatus(200);
    }

    /** @test */
    public function can_not_delete_if_not_found()
    {
        $user = User::factory()->create()->first();
        $this->be($user);

        $this->withHeaders(['Accept' => 'application/json'])
            ->delete(route('announcements.delete', ['id' => '1234567891234567']))
            ->assertStatus(404);
    }
}
