<?php

namespace App\Http\Controllers\Api\Notification;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Return current user notifications (including global notifications).
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();
        $perPage = min((int) $request->query('per_page', 20), 100);

        $notifications = Notification::query()
            ->where(function ($query) use ($user) {
                $query->where('user_id', $user->id)->orWhereNull('user_id');
            })
            ->latest()
            ->paginate($perPage);

        $notifications->getCollection()->transform(function (Notification $notification) {
            return [
                'id' => $notification->id,
                'title' => $notification->title,
                'body' => $notification->body,
                'is_read' => $notification->is_read,
                'icon' => $notification->icon,
                'reference_type' => $notification->reference_type,
                'reference_id' => $notification->reference_id,
                'created_at' => $notification->created_at,
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $notifications,
        ]);
    }

    /**
     * Mark a notification as read for current user.
     */
    public function markAsRead(Request $request, int $id): JsonResponse
    {
        $user = $request->user();

        $notification = Notification::query()
            ->where('id', $id)
            ->where(function ($query) use ($user) {
                $query->where('user_id', $user->id)->orWhereNull('user_id');
            })
            ->first();

        if (!$notification) {
            return response()->json([
                'success' => false,
                'message' => __('notification.not_found'),
            ], 404);
        }

        $notification->update(['is_read' => true]);

        return response()->json([
            'success' => true,
            'message' => __('notification.marked_as_read'),
        ]);
    }

    /**
     * Delete a notification for current user.
     */
    public function destroy(Request $request, int $id): JsonResponse
    {
        $notification = Notification::query()
            ->where('id', $id)
            ->where('user_id', $request->user()->id)
            ->first();

        if (!$notification) {
            return response()->json([
                'success' => false,
                'message' => __('notification.not_found'),
            ], 404);
        }

        $notification->delete();

        return response()->json([
            'success' => true,
            'message' => __('notification.deleted'),
        ]);
    }
}
