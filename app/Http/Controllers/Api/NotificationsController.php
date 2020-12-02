<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Notification;
use Bpocallaghan\LogActivity\Models\LogActivity;

class NotificationsController extends ApiController
{
    /**
     * Get all the notifications for a user
     * @param User $user
     * @param bool $unread
     * @return array
     */
    public function index(User $user, $unread = false)
    {
        $notifications = [];
        $rows = $user->notifications;
        if ($unread) {
            $rows = $user->unreadNotifications;
        }

        foreach ($rows as $k => $notification) {
            $notifications[] = [
                'id'         => $notification->id,
                'created_at' => $notification->created_at->format('l d F H:i'),
                'type'       => $notification->type,
                'message'    => $notification->data['message'],
                'read_at'    => $notification->read_at,
                'user_id'    => $user->id,
            ];
        }

        return json_response($notifications);
    }

    /**
     * Get all the unread notifications
     * @param User $user
     * @return array
     */
    public function unread(User $user)
    {
        return $this->index($user, 'unread');
    }

    /**
     * Read a notification
     * @param User         $user
     * @param Notification $notification
     * @return array
     */
    public function read(User $user, Notification $notification)
    {
        $notification->markAsRead();

        return $this->index($user, 'unread');
    }

    /**
     * Get the latest Website Actions
     * @return \Illuminate\Http\JsonResponse
     */
    public function getLatestActions()
    {
        $actions = LogActivity::getLatestMinutes(48 * 60);

        return json_response($this->formatActions($actions));
    }

    private function formatActions($actions)
    {
        $items = [];
        foreach ($actions as $k => $item) {
            $items [] = [
                'id'         => $item->id,
                'name'       => $item->name,
                'message'    => $item->description,
                'read'       => false,
                'created_at' => $item->created_at->diffForHumans(),
            ];
        }

        return $items;
    }
}
