<?php

namespace App\Services\Notification;

use Illuminate\Support\Facades\Log;
use Kreait\Firebase\Contract\Messaging;
use Kreait\Firebase\Factory;
use Throwable;

class FirebaseService
{
    private ?Messaging $messaging = null;

    public function __construct()
    {
        $serviceAccountPath = storage_path('app/firebase/firebase.json');

        if (!is_file($serviceAccountPath)) {
            Log::warning('FCM service account file is missing.', [
                'path' => $serviceAccountPath,
            ]);
            return;
        }

        try {
            $this->messaging = (new Factory())
                ->withServiceAccount($serviceAccountPath)
                ->createMessaging();
        } catch (Throwable $e) {
            Log::error('Unable to initialize Firebase messaging client.', [
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function sendToToken(string $token, string $title, string $body, array $data = []): bool
    {
        if (!$this->messaging) {
            return false;
        }

        try {
            $this->messaging->send([
                'token' => $token,
                'notification' => [
                    'title' => $title,
                    'body' => $body,
                ],
                'data' => $this->stringifyDataPayload($data),
            ]);

            return true;
        } catch (Throwable $e) {
            Log::warning('FCM push failed for token.', [
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    public function sendToTopic(string $topic, string $title, string $body, array $data = []): bool
    {
        if (!$this->messaging) {
            return false;
        }

        try {
            $this->messaging->send([
                'topic' => $topic,
                'notification' => [
                    'title' => $title,
                    'body' => $body,
                ],
                'data' => $this->stringifyDataPayload($data),
            ]);

            return true;
        } catch (Throwable $e) {
            Log::warning('FCM push failed for topic.', [
                'topic' => $topic,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    private function stringifyDataPayload(array $data): array
    {
        $payload = [];

        foreach ($data as $key => $value) {
            $payload[(string) $key] = (string) ($value ?? '');
        }

        return $payload;
    }
}
