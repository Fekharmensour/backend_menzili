<?php

namespace App\Listeners;

use App\Events\AppointmentCreated;
use App\Models\User;
use App\Services\Notification\NotificationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;

class SendAppointmentNotification implements ShouldQueue
{
    public function __construct(private readonly NotificationService $notificationService)
    {
    }

    public function handle(AppointmentCreated $event): void
    {
        $appointment = $event->appointment;
        $user = $this->resolveUser($appointment);

        if (!$user) {
            return;
        }

        $date = data_get($appointment, 'date')
            ?? data_get($appointment, 'appointment_date')
            ?? data_get($appointment, 'start_at');

        $this->notificationService->sendFromKey(
            user: $user,
            key: 'appointment_created',
            params: ['date' => $date ? (string) $date : now()->toDateString()],
            reference: $appointment instanceof Model ? $appointment : null,
            icon: 'calendar'
        );
    }

    private function resolveUser($appointment): ?User
    {
        if (!$appointment) {
            return null;
        }

        $user = data_get($appointment, 'user');
        if ($user instanceof User) {
            return $user;
        }

        $memberUser = data_get($appointment, 'member.user');
        if ($memberUser instanceof User) {
            return $memberUser;
        }

        $userId = data_get($appointment, 'user_id');
        if (!$userId) {
            $userId = data_get($appointment, 'member.user_id');
        }

        return $userId ? User::query()->find($userId) : null;
    }
}
