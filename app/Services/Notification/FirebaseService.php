<?php

namespace App\Services\Notification;

use Kreait\Firebase\Factory;

class FirebaseService
{
    private $messaging;

    public function __construct()
    {
        $this->messaging = (new Factory)
            ->withServiceAccount(storage_path('app/firebase/firebase.json'))
            ->createMessaging();
    }

    public function sendToToken(string $token, string $title, string $body, array $data = [])
    {
        return $this->messaging->send([
            'token' => $token,
            'notification' => [
                'title' => $title,
                'body' => $body,
            ],
            'data' => array_map('strval', $data), // important for FCM
        ]);
    }

    public function sendToTopic(string $topic, string $title, string $body, array $data = [])
    {
        return $this->messaging->send([
            'topic' => $topic,
            'notification' => [
                'title' => $title,
                'body' => $body,
            ],
            'data' => array_map('strval', $data),
        ]);
    }
}
