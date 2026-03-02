<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminNotificationController extends Controller
{
    public function getUnreadCounts()
    {
        $user = Auth::guard('admin')->user();

        if (!$user) {
            return response()->json([]);
        }

        // Fetch unread notifications and group them by the 'category' key in the data json column
        // Note: This approach works well for small to medium notification volumes.
        $counts = $user->unreadNotifications
            ->groupBy(function ($notification) {
                return $notification->data['category'] ?? 'other';
            })
            ->map
            ->count();

        return response()->json($counts);
    }
    
    // Optional: Mark notifications of a specific category as read
    // Call this via AJAX when a user clicks a main tab link
    public function markCategoryAsRead(Request $request, $category)
    {
         $user = Auth::guard('admin')->user();
         
         $user->unreadNotifications->filter(function($notification) use ($category) {
             return ($notification->data['category'] ?? '') === $category;
         })->markAsRead();
         
         return response()->json(['status' => 'success']);
    }
}
