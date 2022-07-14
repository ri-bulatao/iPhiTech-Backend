<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\Notification;
use App\Models\User;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    public function get_user()
    {
        $user = User::factory()->create()->first();
        $this->be($user);

        return $user;
    }

    public function get_data()
    {
        return [
            'title' => 'Testing Title',
            'read' => true,
            'url' => 'http://testurl.com',
        ];
    }

    /** @test */
    public function can_get_notification_list()
    {
        $user = $this->get_user();

        $this->withHeaders(['Accept' => 'application/json'])
            ->get(route('notifications.list'))
            ->assertStatus(200);
    }

    /** @test */
    public function can_not_get_notification_list_if_unauthorized()
    {
        $this->withHeaders(['Accept' => 'application/json'])
            ->get(route('notifications.list'))
            ->assertStatus(401);
    }

    /** @test */
    public function can_get_unread_notification_list()
    {
        $user = $this->get_user();

        $this->withHeaders(['Accept' => 'application/json'])
            ->get(route('notifications.unread'))
            ->assertStatus(200);
    }

    /** @test */
    public function can_not_get_unread_notification_list_if_unauthorized()
    {
        $this->withHeaders(['Accept' => 'application/json'])
            ->get(route('notifications.unread'))
            ->assertStatus(401);
    }

    /** @test */
    public function can_update_notification()
    {
        $user = $this->get_user();
        $created = Notification::factory()->create()->first();

        $this->withHeaders(['Accept' => 'application/json'])
            ->put(route('notifications.update', ['id' => $created->id]), $this->get_data())
            ->assertStatus(200);
    }

    /** @test */
    public function can_not_update_notification_if_unauthorized()
    {
        $created = Notification::factory()->create()->first();

        $this->withHeaders(['Accept' => 'application/json'])
            ->put(route('notifications.update', ['id' => $created->id]), $this->get_data())
            ->assertStatus(401);
    }

    /** @test */
    public function can_not_update_notification_if_not_found()
    {
        $user = $this->get_user();

        $this->withHeaders(['Accept' => 'application/json'])
            ->put(route('notifications.update', ['id' => '12321312312321']), $this->get_data())
            ->assertStatus(404);
    }

    /** @test */
    public function can_delete_notification()
    {
        $user = $this->get_user();
        $created = Notification::factory()->create()->first();

        $this->withHeaders(['Accept' => 'application/json'])
            ->delete(route('notifications.delete', ['id' => $created->id]))
            ->assertStatus(200);
    }

    /** @test */
    public function can_not_delete_notification_if_not_found()
    {
        $user = $this->get_user();

        $this->withHeaders(['Accept' => 'application/json'])
            ->delete(route('notifications.delete', ['id' => '12321312312321']))
            ->assertStatus(404);
    }

    /** @test */
    public function can_not_delete_notification_if_unauthorized()
    {
        $created = Notification::factory()->create()->first();

        $this->withHeaders(['Accept' => 'application/json'])
            ->delete(route('notifications.delete', ['id' => $created->id]))
            ->assertStatus(401);
    }
}
