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
            Log::error('FCM: Unable to initialize Firebase messaging client.', [
                'error' => $e->getMessage(),
                'file' => $serviceAccountPath
            ]);
            // We don't throw here to avoid crashing the whole request if FCM is down,
            // but the individual send methods will return false/throw.
        }
    }

    public function sendToToken(string $token, string $title, string $body, array $data = []): bool
    {
        if (!$this->messaging) {
            return false;
        }

        try {
            $response = $this->messaging->send([
                'token' => $token,
                'notification' => [
                    'title' => $title,
                    'body' => $body,
                ],
                'data' => $this->stringifyDataPayload($data),
            ]);

            Log::info('FCM: Push sent successfully to token.', [
                'token' => substr($token, 0, 20) . '...',
                'message_id' => $response['name'] ?? 'unknown',
            ]);

            return true;
        } catch (Throwable $e) {
            $msg = $e->getMessage();
            
            // Check for invalid tokens or entities not found (common when app is uninstalled)
            if (str_contains($msg, 'Requested entity was not found') || 
                str_contains($msg, 'invalid') || 
                str_contains($msg, 'registration token is not a valid')) {
                
                Log::info('FCM: Deleting invalid token from database.', [
                    'token_prefix' => substr($token, 0, 10),
                ]);
                
                \App\Models\FcmToken::where('token', $token)->delete();
            } else {
                Log::warning('FCM push failed for token.', [
                    'error' => $msg,
                ]);
            }

            throw $e; // Rethrow to fail the job/queue
        }
    }

    public function sendToTopic(string $topic, string $title, string $body, array $data = []): bool
    {
        if (!$this->messaging) {
            return false;
        }

        try {
            $response = $this->messaging->send([
                'topic' => $topic,
                'notification' => [
                    'title' => $title,
                    'body' => $body,
                ],
                'data' => $this->stringifyDataPayload($data),
            ]);

            Log::info('FCM: Push sent successfully to topic.', [
                'topic' => $topic,
                'message_id' => $response['name'] ?? 'unknown',
            ]);

            return true;
        } catch (Throwable $e) {
            Log::warning('FCM push failed for topic.', [
                'topic' => $topic,
                'error' => $e->getMessage(),
            ]);

            throw $e; // Rethrow to fail the job
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
