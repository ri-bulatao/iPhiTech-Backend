<?php

declare(strict_types=1);

namespace App\Http\Controllers;

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use App\Utilities\Result;
use Illuminate\Contracts\Auth\Authenticatable;

class NotificationsController extends Controller
{
    /**
     * @var Authenticatable
     */
    private $user;

    /**
     * @var Result
     */
    private $result;

    public function __construct(Result $result)
    {
        $this->user = auth()->user();
        $this->result = $result;
    }

    public function index()
    {
        $notification = $this->user->with('notifications')->get();

        return $this->result->success($notification);
    }
}
