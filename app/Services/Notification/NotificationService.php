<?php

namespace App\Services\Notification;

use App\Models\FcmToken;
use App\Models\Notification;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class NotificationService
{
    /**
     * Create a user notification from translation key and dispatch FCM.
     */
    public function sendFromKey($user, string $key, array $params = [], $reference = null, ?string $icon = null): Notification
    {
        $titles = $this->localizedText($key, 'title', $params);
        $bodies = $this->localizedText($key, 'body', $params);
        [$referenceType, $referenceId] = $this->normalizeReference($reference);

        $notification = Notification::create([
            'user_id' => $user->id,
            'title_en' => $titles['en'] ?? null,
            'title_ar' => $titles['ar'] ?? null,
            'title_fr' => $titles['fr'] ?? null,
            'body_en' => $bodies['en'] ?? null,
            'body_ar' => $bodies['ar'] ?? null,
            'body_fr' => $bodies['fr'] ?? null,
            'reference_type' => $referenceType,
            'reference_id' => $referenceId,
            'icon' => $icon,
        ]);

        $tokens = $this->userTokens($user->id);
        if (!empty($tokens)) {
            $preferredLocale = $user->locale ?? app()->getLocale();
            $locale = in_array($preferredLocale, ['en', 'fr', 'ar'], true) ? $preferredLocale : 'en';
            $title = $titles[$locale] ?? $titles['en'] ?? '';
            $body  = $bodies[$locale] ?? $bodies['en'] ?? '';

            foreach ($tokens as $token) {
                app(FirebaseService::class)->sendToToken(
                    $token,
                    $title,
                    $body,
                    $this->payloadData($notification)
                );
            }
        }

        return $notification;
    }

    /**
     * Create a global notification and broadcast it to all users topic.
     */
    public function broadcastFromKey(string $key, array $params = [], ?string $icon = null): Notification
    {
        $titles = $this->localizedText($key, 'title', $params);
        $bodies = $this->localizedText($key, 'body', $params);

        $notification = Notification::create([
            'user_id' => null,
            'title_en' => $titles['en'] ?? null,
            'title_ar' => $titles['ar'] ?? null,
            'title_fr' => $titles['fr'] ?? null,
            'body_en' => $bodies['en'] ?? null,
            'body_ar' => $bodies['ar'] ?? null,
            'body_fr' => $bodies['fr'] ?? null,
            'icon' => $icon,
        ]);

        $title = $titles['en'] ?? '';
        $body  = $bodies['en'] ?? '';

        app(FirebaseService::class)->sendToTopic(
            'all_users',
            $title,
            $body,
            $this->payloadData($notification)
        );

        return $notification;
    }

    /**
     * Backward compatible API for callers that already send raw title/body arrays.
     */
    public function send($user, array $titles, array $bodies, $reference = null, ?string $icon = null): Notification
    {
        [$referenceType, $referenceId] = $this->normalizeReference($reference);

        $notification = Notification::create([
            'user_id' => $user->id,
            'title_en' => $titles['en'] ?? null,
            'title_ar' => $titles['ar'] ?? null,
            'title_fr' => $titles['fr'] ?? null,
            'body_en' => $bodies['en'] ?? null,
            'body_ar' => $bodies['ar'] ?? null,
            'body_fr' => $bodies['fr'] ?? null,
            'reference_type' => $referenceType,
            'reference_id' => $referenceId,
            'icon' => $icon,
        ]);

        $tokens = $this->userTokens($user->id);
        if (!empty($tokens)) {
            $preferredLocale = $user->locale ?? app()->getLocale();
            $locale = in_array($preferredLocale, ['en', 'fr', 'ar'], true) ? $preferredLocale : 'en';

            foreach ($tokens as $token) {
                app(FirebaseService::class)->sendToToken(
                    $token,
                    $titles[$locale] ?? $titles['en'] ?? '',
                    $bodies[$locale] ?? $bodies['en'] ?? '',
                    $this->payloadData($notification)
                );
            }
        }

        return $notification;
    }

    /**
     * Backward compatible API for callers that already send raw title/body arrays.
     */
    public function broadcastAll(array $titles, array $bodies, ?string $icon = null): Notification
    {
        $notification = Notification::create([
            'user_id' => null,
            'title_en' => $titles['en'] ?? null,
            'title_ar' => $titles['ar'] ?? null,
            'title_fr' => $titles['fr'] ?? null,
            'body_en' => $bodies['en'] ?? null,
            'body_ar' => $bodies['ar'] ?? null,
            'body_fr' => $bodies['fr'] ?? null,
            'icon' => $icon,
        ]);

        app(FirebaseService::class)->sendToTopic(
            'all_users',
            $titles['en'] ?? '',
            $bodies['en'] ?? '',
            $this->payloadData($notification)
        );

        return $notification;
    }

    private function payloadData(Notification $notification): array
    {
        return [
            'notification_id' => (string) $notification->id,
            'reference_type' => (string) ($notification->reference_type ?? ''),
            'reference_id' => (string) ($notification->reference_id ?? ''),
        ];
    }

    private function localizedText(string $key, string $field, array $params = []): array
    {
        $path = "notification.{$key}.{$field}";

        $en = trans($path, $params, 'en');
        $fr = trans($path, $params, 'fr');
        $ar = trans($path, $params, 'ar');

        if ($en === $path && $fr === $path && $ar === $path) {
            Log::warning('Notification translation key not found.', ['key' => $path]);
        }

        return [
            'en' => $en === $path ? null : $en,
            'fr' => $fr === $path ? null : $fr,
            'ar' => $ar === $path ? null : $ar,
        ];
    }

    private function normalizeReference($reference): array
    {
        if ($reference instanceof Model) {
            return [get_class($reference), $reference->getKey()];
        }

        if (is_array($reference)) {
            return [
                $reference['reference_type'] ?? $reference['type'] ?? null,
                $reference['reference_id'] ?? $reference['id'] ?? null,
            ];
        }

        return [null, null];
    }

    private function userTokens(int $userId): array
    {
        return FcmToken::query()
            ->where('user_id', $userId)
            ->pluck('token')
            ->filter()
            ->unique()
            ->values()
            ->all();
    }
}
