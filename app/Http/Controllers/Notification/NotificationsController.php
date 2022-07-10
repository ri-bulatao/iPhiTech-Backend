<?php

declare(strict_types=1);

namespace App\Http\Controllers;

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use App\Utilities\Result;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Models\User;
use App\Http\Requests\NotificationRequest;
use App\Models\Notification as NotificationModel;
use Illuminate\Http\JsonResponse;

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

    /**
     * For fetching all notifications
     * 
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $user_notifications = $this->user->load('notifications');

        return $this->result->success($user_notifications);
    }

    /**
     * For updating the notification
     * 
     * @param NotificationRequest $request
     * @param int $id
     * 
     * @return JsonResponse
     */
    public function update(NotificationRequest $request, $id): JsonResponse
    {
        $title = $request->title;
        $read = $request->read;
        $url = $request->url;

        $notification = NotificationModel::find( $id );

        if( ! $notification ) {
            return $this->result->notFound();
        }

        $notification->title = $title;
        $notification->read = $read;
        $notification->url = $url;
        $notification->save();

        return $this->result->success('Notification Updated');

    }

    /**
     * For deleting the notifications
     * 
     * @param int $id
     * 
     * @return JsonResponse
     */
    public function delete($id): JsonResponse
    {
        $notification  = NotificationModel::find($id);

        if( ! $notification ) {
            return $this->result->notFound();
        }

        $action = $notification->delete();

        if( ! $action ) {
            return $this->result->exception();
        }

        return $this->result->success($notification, 'Notification deleted!');
    }
}
