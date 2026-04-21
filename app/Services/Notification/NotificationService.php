<?php

namespace App\Services\Notification;

use App\Models\Notification;

class NotificationService
{
    public function send(
        $user,
        array $titles,
        array $bodies,
        $reference = null,
        $icon = null
    ) {
        // 1. Save in DB
        $notification = Notification::create([
            'user_id' => $user->id,

            'title_en' => $titles['en'] ?? null,
            'title_ar' => $titles['ar'] ?? null,
            'title_fr' => $titles['fr'] ?? null,

            'body_en' => $bodies['en'] ?? null,
            'body_ar' => $bodies['ar'] ?? null,
            'body_fr' => $bodies['fr'] ?? null,

            'icon' => $icon,

            'reference_type' => $reference ? get_class($reference) : null,
            'reference_id' => $reference?->id,
        ]);

        // 2. Send FCM push
        if ($user->fcm_token) {

            $locale = $user->locale ?? 'en';

            $title = $titles[$locale] ?? $titles['en'] ?? '';
            $body  = $bodies[$locale] ?? $bodies['en'] ?? '';

            app(FirebaseService::class)->sendToToken(
                $user->fcm_token,
                $title,
                $body,
                [
                    'notification_id' => $notification->id,
                    'reference_type'  => $notification->reference_type,
                    'reference_id'    => $notification->reference_id,
                ]
            );
        }

        return $notification;
    }

    public function broadcastAll(array $titles, array $bodies, $icon = null)
    {
        // Save global notification (optional)
        Notification::create([
            'title_en' => $titles['en'] ?? null,
            'title_ar' => $titles['ar'] ?? null,
            'title_fr' => $titles['fr'] ?? null,

            'body_en' => $bodies['en'] ?? null,
            'body_ar' => $bodies['ar'] ?? null,
            'body_fr' => $bodies['fr'] ?? null,

            'icon' => $icon,
        ]);

        // Send FCM topic (default EN or fallback)
        $title = $titles['en'] ?? '';
        $body  = $bodies['en'] ?? '';

        app(FirebaseService::class)->sendToTopic(
            'all_users',
            $title,
            $body
        );
    }
}
