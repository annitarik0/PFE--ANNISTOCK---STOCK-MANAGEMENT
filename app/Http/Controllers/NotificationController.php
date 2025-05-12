<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->is_read = true;
        $notification->save();

        // Check if the link exists and is valid
        if ($notification->link) {
            try {
                // Try to parse the URL to see if it's valid
                $url = parse_url($notification->link);
                return redirect($notification->link);
            } catch (\Exception $e) {
                // If there's an error, redirect to dashboard
                return redirect()->route('dashboard');
            }
        }

        // Default redirect to dashboard
        return redirect()->route('dashboard');
    }

    public function getUnreadCount()
    {
        $count = Notification::where('is_read', false)->count();
        return response()->json(['count' => $count]);
    }

    public function markAllAsRead()
    {
        // Mark all unread notifications as read
        Notification::where('is_read', false)->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }
}

