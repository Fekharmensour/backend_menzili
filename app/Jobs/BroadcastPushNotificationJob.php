<?php

namespace App\Jobs;

use App\Services\Notification\FirebaseService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;

class BroadcastPushNotificationJob implements ShouldQueue
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
        protected string $topic,
        protected string $title,
        protected string $body,
        protected array $data = []
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        app(FirebaseService::class)->sendToTopic(
            $this->topic,
            $this->title,
            $this->body,
            $this->data
        );
    }

    /**
     * Handle a job failure.
     */
    public function failed(Throwable $exception): void
    {
        Log::error('BroadcastPushNotificationJob failed.', [
            'topic' => $this->topic,
            'error' => $exception->getMessage(),
        ]);
    }
}
