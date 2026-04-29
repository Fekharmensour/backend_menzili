<?php

namespace App\Listeners;

use App\Events\MessageReceived;
use App\Models\User;
use App\Services\Notification\NotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;

class SendMessageNotification implements ShouldQueue
{
    public function __construct(private readonly NotificationService $notificationService)
    {
    }

    public function handle(MessageReceived $event): void
    {
        $message = $event->message;

        $senderId = data_get($message, 'sender_id') ?? data_get($message, 'user_id');
        $receiverId = data_get($message, 'receiver_id') ?? data_get($message, 'conversation.user_id');

        // In current AI conversation flow: assistant message targets conversation owner.
        if (!$receiverId && data_get($message, 'role') === 'assistant') {
            $receiverId = data_get($message, 'user_id');
            $senderId = null;
        }

        if (!$receiverId || ($senderId && (string) $senderId === (string) $receiverId)) {
            return;
        }

        $receiver = User::query()->find($receiverId);
        if (!$receiver) {
            return;
        }

        $senderName = data_get($message, 'sender.name')
            ?? data_get($message, 'user.name')
            ?? 'System';

        $this->notificationService->sendFromKey(
            user: $receiver,
            key: 'message_received',
            params: ['sender' => (string) $senderName],
            reference: $message instanceof Model ? $message : null,
            icon: 'message'
        );
    }
}
