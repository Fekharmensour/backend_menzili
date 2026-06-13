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

class BroadcastToAllTokensJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     */
    public $tries = 3;

    /**
     * Create a new job instance.
     */
    public function __construct(
        protected array $titles,
        protected array $bodies,
        protected array $data = []
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $firebaseService = app(FirebaseService::class);
        
        // Chunk tokens to avoid memory issues if there are many
        FcmToken::query()
            ->with('user')
            ->chunk(100, function ($tokens) use ($firebaseService) {
                foreach ($tokens as $fcmToken) {
                    try {
                        $userLocale = $fcmToken->user->locale ?? 'en';
                        $title = $this->titles[$userLocale] ?? $this->titles['en'] ?? '';
                        $body = $this->bodies[$userLocale] ?? $this->bodies['en'] ?? '';

                        $firebaseService->sendToToken(
                            $fcmToken->token,
                            $title,
                            $body,
                            $this->data
                        );
                    } catch (Throwable $e) {
                        Log::warning('FCM: Failed to send to token during broadcast.', [
                            'token' => substr($fcmToken->token, 0, 20) . '...',
                            'error' => $e->getMessage(),
                        ]);
                    }
                }
            });
    }

    /**
     * Handle a job failure.
     */
    public function failed(Throwable $exception): void
    {
        Log::error('BroadcastToAllTokensJob failed.', [
            'error' => $exception->getMessage(),
        ]);
    }
}
