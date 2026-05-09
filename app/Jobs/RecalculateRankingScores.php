<?php

namespace App\Jobs;

use App\Services\RankingService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class RecalculateRankingScores implements ShouldQueue
{
    use Queueable;

    public function handle(RankingService $service): void
    {
        $service->recalculateAllScores();
    }
}
