<?php

namespace App\Jobs;

use App\Models\FcmToken;
use App\Services\Notification\FirebaseService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;

class SendPushNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected int $userId,
        protected string $title,
        protected string $body,
        protected array $data = []
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $tokens = FcmToken::query()
            ->where('user_id', $this->userId)
            ->pluck('token')
            ->filter()
            ->unique()
            ->values()
            ->all();

        if (empty($tokens)) {
            Log::info('No FCM tokens found for user.', ['userId' => $this->userId]);
            return;
        }

        $firebaseService = app(FirebaseService::class);

        foreach ($tokens as $token) {
            $firebaseService->sendToToken(
                $token,
                $this->title,
                $this->body,
                $this->data
            );
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(Throwable $exception): void
    {
        Log::error('SendPushNotificationJob failed.', [
            'userId' => $this->userId,
            'error' => $exception->getMessage(),
        ]);
    }
}
