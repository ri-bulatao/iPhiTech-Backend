<?php

declare(strict_types=1);

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Event;

class AnnouncementPosted extends Event implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $title;
    public $message;
    public $url;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($announcementTitle, $url)
    {
        $this->title = 'New Announcement was posted!';
        $this->message = $announcementTitle;
        $this->url = $url;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        // return new PrivateChannel('posted-announcement');

        return [
            'posted-announcements',
        ];
    }

    public function broadcastAs()
    {
        return 'posted-announcements';
    }
}
