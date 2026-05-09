<?php

namespace App\Jobs;

use App\Models\Boost;
use App\Services\RankingService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ExpireBoosts implements ShouldQueue
{
    use Queueable;

    public function handle(RankingService $rankingService): void
    {
        Boost::where('status', 'active')
             ->where('expires_at', '<=', now())
             ->each(fn($boost) => $rankingService->expireBoost($boost));
    }
}
