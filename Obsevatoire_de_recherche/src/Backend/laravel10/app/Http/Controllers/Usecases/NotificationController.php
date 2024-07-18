<?php

namespace App\Http\Controllers\Usecases;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function getNotifications()
    {
        $user = auth()->user();
        $notifications = $user->unreadNotifications;

        return response()->json($notifications);
    }

    public function markAsRead($notificationId)
    {
        $user = auth()->user();
        $notification = $user->notifications()->find($notificationId);

        if ($notification) {
            $notification->markAsRead();
            return response()->json(['message' => 'Notification marquée comme lue.']);
        }

        return response()->json(['message' => 'Notification introuvable.'], 404);
    }

    public function markAllAsRead()
    {
        $user = auth()->user();
        $user->unreadNotifications->markAsRead();

        return response()->json(['message' => 'Toutes les notifications ont été marquées comme lues.']);
    }


}
